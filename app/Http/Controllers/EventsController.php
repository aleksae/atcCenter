<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function show(){
        $events = Event::all();
        return view('events.view', ['events'=>$events]);
    }
    public function createEventShow(){
        $airports = DB::table('airports')->where('isAirport', 1)->get();
        return view('events.create', ['airports'=>$airports]);
    }
    public function createEvent(Request $request){

        $event = new Event;
        $airports = preg_split("/[,\s*]+/", $request->airports);
        $airports = implode(', ', $airports);
        $event->name=$request->name;
        $event->description=$request->description;
        $event->type=$request->type;
        $event->date=$request->date;
        $event->start=$request->start;
        $event->end=$request->end;
        $event->positions=$airports;
        $event->save();

        $airports=explode(', ', $airports);
        $i=0;
        foreach($airports as $airport){
        $info = DB::table('airports')->where('station', $airport)->first();
        if($info->TWR==1){
        $date=date_create($request->date);
        $controller = auth()->user()->name." ".auth()->user()->last_name;
        $callsign = $info->station."_TWR";
        $start = Carbon::createFromFormat('H:i', $request->start)->setDateFrom($date);
        $end = Carbon::createFromFormat('H:i', $request->end)->setDateFrom($date);
        $cid = auth()->user()->cid;
        $localid=floor($cid / (date('z') + 1+3*$i));
        $training = 0;
        $event = 0;
        $bookings = Booking::all();
        $error=0;
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
             $booking->type="Event";
             $booking->local_id=$localid; 
             $booking->eu_id=0;
             $booking->save();
          }else{
              return back()->with('error', 'Booking already exists')->withInput();
          }      
    }
    if($info->APP==1){
        $date=date_create($request->date);
        $controller = auth()->user()->name." ".auth()->user()->last_name;
        $callsign = $info->station."_APP";
        $start = Carbon::createFromFormat('H:i', $request->start)->setDateFrom($date);
        $end = Carbon::createFromFormat('H:i', $request->end)->setDateFrom($date);
        $cid = auth()->user()->cid;
        $localid=floor($cid / (date('z') + 2+3*$i));
        $training = 0;
        $event = 0;
        $bookings = Booking::all();
        $error=0;
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
             $booking->type="Event";
             $booking->local_id=$localid; 
             $booking->eu_id=0;
             $booking->save();
          }else{
              return back()->with('error', 'Booking already exists')->withInput();
          }      
    }
    if($request->type=="Weekly"){
        $date=date_create($request->date);
        $controller = auth()->user()->name." ".auth()->user()->last_name;
        $callsign ="ADR_CTR";
        $start = Carbon::createFromFormat('H:i', $request->start)->setDateFrom($date);
        $end = Carbon::createFromFormat('H:i', $request->end)->setDateFrom($date);
        $cid = auth()->user()->cid;
        $localid=floor($cid / (date('z') + 3+3*$i));
        $training = 0;
        $event = 0;
        $bookings = Booking::all();
        $error=0;
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
             $booking->type="Event";
             $booking->local_id=$localid; 
             $booking->eu_id=0;
             $booking->save();
          }   
    }
       
}
     
        return redirect()->route('events')->with('message', 'Successfully');
    }
    public function avlbShow($id){
        $event=Event::find($id);
        return view('events.report', ['event'=>$event]);
    }
    public function updateAvlbShow($id){
        $event=Event::find($id);
        return view('events.update', ['event'=>$event]);
    }


    public function avlbStore(Request $request){
        $rules = [
            'date'=> 'required|date_format:m/d/Y',
            'start' => 'date_format:H:i|after_or_equal:start_old',
            'end' => 'date_format:H:i|after:start|before_or_equal:end_old',
         ];
         $customMessage = [
            'start.after_or_equal' => 'You cannot report available before start of an event.',
            'end.before_or_equal' => 'You cannot report available after end of an event.',
        ];
         $this->validate($request, $rules, $customMessage);
        $event=Event::find($request->id);
        $start="";
        $end="";
        if($request->status=="Available"){
            $start=$request->start;
            $end=$request->end;
        }else{
            $start=NULL;
            $end=NULL;
        }
        if($event->reports!=NULL){
            $reports=json_decode($event->reports, true);
            
            array_push($reports,['full_name'=> auth()->user()->name." ". auth()->user()->last_name, 'cid'=>auth()->user()->cid, 'status'=>$request->status , 'start'=>$start, 'end'=> $end, 'rating'=>auth()->user()->rating]);
            $event->reports = $reports;
        }else{
            $reports= [];
            array_push($reports,['full_name'=> auth()->user()->name." ". auth()->user()->last_name, 'cid'=>auth()->user()->cid,  'status'=>$request->status ,'start'=>$start, 'end'=> $end, 'rating'=>auth()->user()->rating]);
            $event->reports = json_encode($reports);
        }
        $event->save();
        return redirect()->route('events')->with('message', 'Availability reported successfully!');
    }
    public function avlbUpdate(Request $request){
        $rules = [
            'date'=> 'required|date_format:m/d/Y',
            'start' => 'date_format:H:i|after_or_equal:start_old',
            'end' => 'date_format:H:i|after:start|before_or_equal:end_old',
         ];
         $customMessage = [
            'start.after_or_equal' => 'You cannot report available before start of an event.',
            'end.before_or_equal' => 'You cannot report available after end of an event.',
        ];
         $this->validate($request, $rules, $customMessage);
        $event=Event::find($request->id);
        $start="";
        $end="";
        if($request->status=="Available"){
            $start=$request->start;
            $end=$request->end;
        }else{
            $start=NULL;
            $end=NULL;
        }
        $reports = json_decode($event->reports, true);
        for($i=0; $i<count($reports); $i++){
            if($reports[$i]['cid'] == auth()->user()->cid){
            $reports[$i]['status'] = $request->status;
            $reports[$i]['start'] = $start;
            $reports[$i]['end']=$end;
            }
        }
        $event->reports = $reports;
        $event->save();
        return redirect()->route('events')->with('message', 'Availability updated successfully!');
    }

    public function rosterView($id){
        $event = Event::find($id);
        $airports = DB::table('airports')->get();
        return view('events.roster', ['event'=>$event, 'airports'=>$airports]);

    }

    public function rosterStore($id, Request $request){
        $event = Event::find($id);
        $ground=[];
        $tower=[];
        $approach =[];
        $center=[];
        $gnd = $request->gnd;
        $twr = $request->twr;
        $app = $request->app;
        $ctr = $request->ctr;
        for($i=0; $i<$gnd; $i++){
            $prom="gnd".$i;
            $prom2 = "position_gnd".$i;
            array_push($ground,['airport'=>$request->$prom2, 'atcs' => $request->$prom]);
        }
        for($i=0; $i<$request->twr; $i++){
            $prom = "twr".$i;
            $prom2 = "position_twr".$i;
            array_push($tower,['airport'=>$request->$prom2, 'atcs' => $request->$prom]);
        }
        for($i=0; $i<$request->app; $i++){
            $prom = "app".$i;
            $prom2 = "position_app".$i;
            array_push($approach,['airport'=>$request->$prom2, 'atcs' => $request->$prom]);
        }
        for($i=0; $i<$request->app; $i++){
            $prom="ctr".$i;
            $prom2 = "position_ctr".$i;
            array_push($center,['airport'=>$request->$prom2, 'atcs' => $request->$prom]);
        }
        $roster = [];
        array_push($roster, $ground, $tower, $approach, $center);
        print_r($roster);
        print_r($request->position_app1);
        $event -> roster = $roster;
        $event -> notes = $request->notes;
        $event->save();
        return redirect()->route('events');
    }
}
