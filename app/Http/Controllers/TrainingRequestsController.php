<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Models\TrainingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TrainingRequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function show(){
        $traineeInfo = Trainee::where('cid',auth()->user()->cid)->first(); 
        $requests = TrainingRequest::where('cid',auth()->user()->cid)->where('training_type', $traineeInfo->type)->orderBy('date', 'desc')->orderBy('end_time', 'desc')->paginate(5);
        $table=strtolower($traineeInfo->type)."_training_sheet";
        $items = DB::table($table)->get();
        return view('training.request_training', ['requests'=>$requests, 'traineeInfo'=>$traineeInfo, 'items'=>$items]);
    }
    public function progress(){
        $traineeInfo = Trainee::where('cid',auth()->user()->cid )->first(); 
        $requests = TrainingRequest::where('cid',auth()->user()->cid)->where('training_type', $traineeInfo->type)->get();        
        $table=strtolower($traineeInfo->type)."_training_sheet";
        $items = DB::table($table)->get();
        $numItems = $items->count();
        $sheet=array_fill(0, $numItems, 0);
        foreach($requests as $training){
        
        $niz=json_decode($training->sheet);
        for($i=0;$i<$numItems;$i++){
        if(!$niz){$niz=array_fill(0, $numItems, [0]);} 
        foreach ($niz[$i] as $key) {
        $sheet[$i]=$sheet[$i] + $key;
      }}}
      $sum=0;
      foreach($sheet as $score){
          $sum+=$score;
      }
      $sum=$sum/$numItems;
      Trainee::where('cid',auth()->user()->cid )->update(['overall_score'=>$sum]);
        return view('training.trainingReview', [ 'requests'=>$requests,'traineeInfo'=>$traineeInfo, 'items'=>$items,'sheet'=> $sheet, 'sum'=>$sum]);
    }

    public function store(Request $request){
        $rules = [
            'cid' => 'required|integer',
            'name'=> 'required|regex:/^[a-zA-Z\s]+$/',
            'type'=> 'required',
            'date'=> 'required|date_format:d/m/Y',
            'start' => 'date_format:H:i',
            'end' => 'date_format:H:i|after:start',
            'position'=>'required|regex:/^[a-zA-Z_\s]+$/'
         ];
         $this->validate($request, $rules);
         $cid=$request->input('cid');
         $name=$request->input('name');
         $date=$request->input('date');
         $start_time=$request->input('start');
         $end_time=$request->input('end');
         $position=$request->input('position');
         $type=$request->input('type');
         $trainee = Trainee::where('cid', $cid)->first();
         $training = new TrainingRequest;
         $training->cid = $cid;
         $training->name = $name;
         $training->training_type = $trainee->type;   
         $training->date = $date;
         $training->type = $type;
         $training->start_time = $start_time;
         $training->end_time = $end_time;
         $training->position = $position;
         $training->status = 'Pending';
         $training->save();
              

         Http::post('https://discord.com/api/webhooks/826503233110802452/YTqcfkd7ZHyLC8SMP0_cEcOyeH-lgIpyUAh-JxBTDLv9Md8kX-JeHNtlUtcUbTfKW93a', [
            //'content' => "New training request <@&572740430676885517>",
            'content' => "",
            'embeds' => [
                [
                    'title' => "ATC Center notification [".Carbon::now()->format('H:i')."z]",
                    'description' => "A new training request has been made",
                    'color' => '14783755',
                    "fields" => [
                        // Field 1
                        [
                            "name" => "Trainee",
                            "value" => substr((auth()->user()->name),0,1).".".substr((auth()->user()->last_name),0,1).". "."[".auth()->user()->cid."]",
                            "inline" => false
                        ],
                        [
                            "name" => "Date and time",
                            "value" => $date." [".$start_time."-".$end_time."]",
                            "inline" => false
                        ],
                        [
                            "name" => "Positions",
                            "value" => $position,
                            "inline" => false
                        ],
                        [
                            "name" => "Type",
                            "value" => $type,
                            "inline" => false
                        ]
                    ]
                ]
            ],
        ]);
            
            return redirect()->route('request.training')->with('message','Request sent successfully');
    }

   public function mentorShow(){
    $requests = TrainingRequest::orderBy('date')->paginate(30);
    return view('TD.requests', ['requests'=>$requests]);
   }
   public function editRequest($id)
    {
        $training = TrainingRequest::find($id);
        return view('TD.editRequest',['training'=>$training]);
    }

    public function storeEditRequest(Request $request)
    {
        $rules = [
            'cid' => 'required|integer',
            'name'=> 'required|regex:/^[a-zA-Z\s]+$/',
            'type'=> 'required',
            'date'=> 'required|date_format:d/m/Y',
            'start' => 'date_format:H:i|after_or_equal:start_old',
            'end' => 'date_format:H:i|after:start|before_or_equal:end_old',
            'position'=>'required|regex:/^[a-zA-Z_\s]+$/'
         ];
         $customMessage = [
            'start.after_or_equal' => 'You cannot start before time given by the trainee.',
            'end.before_or_equal' => 'You cannot end after time given by the trainee.',
        ];
         $this->validate($request, $rules, $customMessage);
         $start_time=$request->input('start');
         $end_time=$request->input('end');
         $mentor_name = auth()->user()->name." ".auth()->user()->last_name;
         $mentor_cid = auth()->user()->cid;
         $training = TrainingRequest::where('id', $request->input('id'))->update([
            'start_time' => $start_time,
            'end_time' => $end_time,
            'mentor_name' => $mentor_name,
            'mentor_id' => $mentor_cid,
            'status' => 'Taken',
            'start_old' => $request->input('start_old'),
            'end_old' => $request->input('end_old')
        ]);
        if($request->type=="online"){
        $date = strtotime($request->date);
        $date=date_create($date);
        $controller = $request->name;
        $callsign = $request->position;
        $start = Carbon::createFromFormat('H:i', $request->start)->setDateFrom($date);
        $end = Carbon::createFromFormat('H:i', $request->end)->setDateFrom($date);
        $cid = auth()->user()->cid;
        $localid=floor($cid / (date('z') + 1));
        $training = 1;
        $event = 0;
        $firs=['LYBA', 'LJLA', 'LDZO', 'LQSB', 'LWSS', 'LAAA', 'KFOR'];
        $bookingsAll=[];
        $error = 0;
      /*   foreach($firs as $fir){
            $url = "http://vatbook.euroutepro.com/xml2.php?fir=".$fir;
            $bookings = simplexml_load_file($url);
            foreach($bookings->atcs->booking as $booking){
                    if($booking->callsign==$callsign && date_diff($booking->date, $date)->format('%a')<=0 && $booking->time_start == $start && $booking->time_end == $end){
                        $error = 1;
                    }
                
            }
        } */
      $bookings = Booking::all();
      foreach($bookings as $book){

          var_dump(date_create($start)->format('H:i')>date_create($book->start)->format('H:i'));
          var_dump(date_create($end)->format('H:i')>date_create($book->start)->format('H:i'));
          var_dump(date_create($start)->format('H:i')>date_create($book->end)->format('H:i')); 
          if($book->position==$callsign && date_create($start)->format('d/m/Y')==date_create($book->start)->format('d/m/Y')){
            /* if( !(date_create($start)->format('H:i')>date_create($book->start)->format('H:i')) || !(date_create($end)->format('H:i')>date_create($book->start)->format('H:i')) || !(date_create($start)->format('H:i')>date_create($book->end)->format('H:i'))){ */
          if( !(date_create($start)->format('H:i')>date_create($book->start)->format('H:i'))){
              if(!(date_create($end)->format('H:i')<date_create($book->start)->format('H:i')) && !(date_create($end)->format('H:i')<date_create($book->end)->format('H:i'))){
              echo $error=1;
          }}}
          echo "<br>";
      }
        if($error==0){
           $booking = new Booking;
           $booking->cid=$cid;
           $booking->controller=$controller;
           $booking->position=$callsign;
           $booking->date=$date;
           $booking->start=$start;
           $booking->end=$end;
           $booking->type='training';
           $booking->local_id=$localid; 
           $booking->eu_id=0;
           $booking->save();
           $booking_id = $booking->id;
           $training = TrainingRequest::where('id', $request->input('id'))->update([
            'booking_id' => $booking_id,
        ]);
          return redirect()->route('training.requests')->with('message','Successfully created training');
        }else{
          return back()->with('error', 'Booking already exists')->withInput();
        } 
    } else{
        return redirect()->route('training.requests')->with('message','Successfully confired training.');
    }     
        
        
    }
    public function deleteRequest($id){
        $request = TrainingRequest::find($id);

        $request->delete();    
        return redirect()->route('request.training')->with('message','Request deleted successfully');
    }
    public function mentorSessionShow(){
        $requests = TrainingRequest::where('mentor_id', auth()->user()->cid)->orderBy('date')->get();
        return view('TD.mentorTrainings', ['requests'=>$requests]);
       }
    public function cancelSession($id, $start_old, $end_old){
        
        TrainingRequest::where('id', $id)->update([
            'start_time' => $start_old,
            'end_time' => $end_old,
            'status' => 'Pending',
            'mentor_name' => NULL,
            'mentor_id' => NULL
        ]);
        $training = TrainingRequest::where('id', $id)->first();

        Booking::where('id', $training->booking_id)->delete();
        
        return redirect(route('mentor.sessions'))->with('message', 'Training canceled successfully!');
       }

       public function trainingLog($id, $cid){
        
        $trainee = Trainee::where('cid', $cid)->first();
        $requests = TrainingRequest::where('cid',$cid)->get();
        $table=strtolower($trainee->type)."_training_sheet";
        $items = DB::table($table)->get();
        $numItems = $items->count();
        $sheet=array_fill(0, $numItems, 0);
        foreach($requests as $training){
        
        $niz=json_decode($training->sheet);
        for($i=0;$i<$numItems;$i++){
        if(!$niz){$niz=array_fill(0, $numItems, [0]);}
        foreach ($niz[$i] as $key) {
        $sheet[$i]=$sheet[$i] + $key;
        
      }}}
      $sum=0;
      foreach($sheet as $score){
          $sum+=$score;
      }
      $sum=$sum/$numItems;
      Trainee::where('cid',auth()->user()->cid )->update(['overall_score'=>$sum]);
        
        return view('TD.trainingLog',['items'=>$items, 'id'=>$id,'sheet'=> $sheet]);
       }

       public function logStore(Request $request){
        $rules = [
            'item[]'=> 'integer|between:-100,100',
         ];
         $customMessage = [
        ];
         $this->validate($request, $rules, $customMessage);
        $t1 = TrainingRequest::where('id', $request->id)->first();
        $trainee = Trainee::where('cid', $t1->cid)->first();
        $table=strtolower($trainee->type)."_training_sheet";
        $items = DB::table($table)->get();
        $numItems = $items->count();
        $sheet_sum=array_fill(0, $numItems, 0);;
        $requests = TrainingRequest::where('cid',$t1->cid)->get();
        for($i=0;$i<$numItems;$i++) {
            $sheet[$i]=[
                $i => $request->item[$i],
            ];
        }
        foreach($requests as $training){
        
            $niz=json_decode($training->sheet);
            for($i=0;$i<$numItems;$i++){
            foreach ($sheet[$i] as $key) {
            $sheet_sum[$i]=$sheet_sum[$i] + $key;
            echo $sheet_sum[$i];
            if($sheet_sum[$i]>100){
                return back()->with('count', 'Sum cannot be greater then 100');
            }
            
          }}}
        $sheet=json_encode($sheet);
        TrainingRequest::where('id', $request->id)->update([
            'mentor_notes' => $request->input('notes'),
            'sheet' => $sheet
        ]);
        return redirect(route('mentor.sessions'))->with('message', 'Log created successfully');
       }
     public function submitRate(Request $request){
        TrainingRequest::where('id', $request->id)->update([
            'mentor_rating' => $request->mentor
        ]);
        return back()->with('message', 'Mentor rated successfully');

     } 
     public function mentorReviews(){
        $trainings = TrainingRequest::where('mentor_id', auth()->user()->cid)->get();
        $rates = 0;
                $i=0;
                foreach($trainings as $training){
                    if($training->mentor_rating!=NULL){
                    $rates = $rates + $training->mentor_rating;
                    $i++;
                }
                }
        if($i==0){$i=1;}
        $rates = round($rates/$i,2);
        return view('TD.reviews',['rates'=>$rates]);
     }
     public function mentorReviewsAll(){
         $users = User::all();
         $mentors = [];
         foreach($users as $user){
             if(in_array("Mentor",explode(', ', $user->roles))){
                array_push($mentors,['cid'=>$user->cid,'name'=>$user->name." ".$user->last_name, 'rates'=>'','sessions'=>'']);
             }
         }
         for($i=0;$i<count($mentors);$i++){     
                $trainings = TrainingRequest::where('mentor_id', $mentors[$i]['cid'])->get();
    
                if(!$trainings->isEmpty()){
                $ratesSum = 0;
                $k=0;
                foreach($trainings as $training){
                    if($training->mentor_rating!=NULL){
                    $ratesSum = $ratesSum + $training->mentor_rating;
                    $k++;
                }
                }
                if($k==0){$k=1;}
                $ratesSum = round($ratesSum/$k,2);
                $mentors[$i]['rates']=$ratesSum;
                $mentors[$i]['sessions']=$k;
                }
                
         }
        

       
        return view('TD.mentorReviewsAll',['mentors'=>$mentors]);

     }

     public function ajaxRequest()
     {
         return view('ajaxExample');
     }
 
 
     
    
    
}
