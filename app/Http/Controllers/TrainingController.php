<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Trainee;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function applicationRequest(){

        $proveraPrijave = DB::table('training_applications')->where('cid', [auth()->user()->cid])->latest('created_at')->first();
        //$prijave = DB::select('select * from training_applications where cid = ?', [auth()->user()->cid]);
        $prijave =  DB::table('training_applications')->where('cid', [auth()->user()->cid])->get();
        return view('training.trainingApply',['prijave'=>$prijave],['proveraPrijave'=>$proveraPrijave]);
    }
    public function sendApplication(Request $request){
      $rules = [
         'cid' => 'required|integer',
         'name'=> 'required|regex:/^[a-zA-Z\s]+$/',
         'type'=> 'required',
         'letter'=> 'required|min:75|regex:/^[a-zA-Z0-9\s.]*$/',
         'fir' => 'required|string'
      ];
     $customMessage = [
      'letter.regex' => 'Only letters, dots, numbers and spaces are allowed.',
  ];
  $this->validate($request, $rules, $customMessage);

       $cid=$request->input('cid');
       $full_name=$request->input('name');
       $type=$request->input('type');
       $letter=$request->input('letter');
       $fir=$request->input('fir');

       DB::insert('insert into training_applications (cid, full_name, type, letter, created_at, updated_at, FIR) values (?, ?, ?, ?, ?, ?, ?)', [$cid, $full_name, $type, $letter, Carbon::now(), Carbon::now(), $fir]);
       return back()->withInput()->with('message', 'Application send sucessfully');
    }
    public function viewApplications(){

        //$prijave = DB::select('select * from training_applications');
        $prijave=DB::table('training_applications')->paginate(10);
        return view('training.trainingApplicationsList',['prijave'=>$prijave]);
     }

     public function reviewApplication($id, $cid){

        DB::table('training_applications')
              ->where('id', $id)
              ->update(['status' => 'Under review']);
        $prijave = DB::table('training_applications')->where('id', [$id])->get();
        $opsteInfo = User::where('cid', $cid)->get();
        $pozicije = DB::select('select * from airports');
        return view('training.trainingApplicationReview',['prijave'=>$prijave, 'opsteInfo'=>$opsteInfo, 'pozicije'=>$pozicije]);
     }
     public function sendReviewApplication(Request $request){
        $cid=$request->input('cid');
        $id=$request->input('id');
        $status=$request->input('status');
        $position=$request->input('position');
        if($status=="Accepted"){
        $notes=$request->input('notes')." Your main position is:".$position;}else{
         $notes=$request->input('notes');
        }
        $reviewee=auth()->user()->name." ".auth()->user()->last_name." [".auth()->user()->cid."]";

        DB::update('update training_applications set status = ?,notes=?,reviewee=?,updated_at=? where id = ?',[$status,$notes,$reviewee,Carbon::now(),$id]);
        if($status=="Accepted"){
         $results = User::where('cid', [$cid])->first();

           $roles = $results->roles;
           $full_name=$results->name." ".$results->last_name;

         $results = DB::select('select *  from training_applications where id = ?', [$id]);
         foreach($results as $result){
           $type= $result->type;
         }
         $roles2=explode(', ', $roles);
         if(!in_array('Trainee', $roles2)){
         $roles=$roles.", Trainee";}
        DB::update('update users set roles = ?, updated_at = ? where cid = ?',[$roles, Carbon::now(), $cid]);
        $trening = DB::select('select *  from trainees where cid = ?', [$cid]);
        
        if(!$trening) {

         DB::insert('insert into trainees (created_at, updated_at, cid, full_name, type, isActive, airports) values (?, ?, ?, ?, ?, ?, ?)', [Carbon::now(), Carbon::now(), $cid, $full_name, $type, 1,substr($position,0,4)]);
      }else{
        DB::update('update trainees set updated_at = ?, type = ?, isActive=?, airports=? where cid = ?',[Carbon::now(), $type, 1, $cid, substr($position,0,4)]);
      }
        return redirect('training_applications')->with('message', 'Application processed successfully');
     }
     return redirect('training_applications')->with('message', 'Application prpcessed successfully');
   }

  
   


}
