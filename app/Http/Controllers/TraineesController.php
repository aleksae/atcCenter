<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Models\User;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Models\TrainingRequest;
use Illuminate\Support\Facades\DB;

class TraineesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function traineesList(){
        $trainees=Trainee::paginate(10);

       return view('training.traineesList', ['trainees'=>$trainees]);
     }
    public function airportsView($cid){
        $trainee = Trainee::where('cid', $cid)->first();
        $airports = DB::table('airports')->get();
        return view('training.manageAirports',['trainee'=>$trainee, 'airports'=>$airports]);

    }
    public function airportUpdate(Request $request){
        $cid = $request->input('cid');
        $positions = $request->input('positions');
        if($positions!=''){
        $positions = implode(", ",$positions);
        
        $trainee = Trainee::where('cid', $cid)->first();

        $trainee->airports = $positions;

        $trainee->save();
        
        return redirect()->route('trainees')->with('message','Airports updated successfully');
        }
        else{
            return redirect()->back()->with('error','Check at least one airport!');}
    }
    
    public function soloEdit($cid){
        $trainee = Trainee::where('cid', $cid)->first();


        return view('training.solo', ['trainee'=>$trainee]);
    }
    public function soloStore(Request $request){
        $trainee = Trainee::where('cid', $request->cid)->first();
        $trainee->hasSolo = true;
        $trainee->soloPosition = $request->position;
        $trainee->soloStart = date("d.m.Y.", strtotime($request->date_start));
        $trainee->soloEnd = date("d.m.Y.", strtotime($request->date_end));
        $trainee->save();

        $user = User::where('cid', $request->cid)->first();
        $type=strtolower(substr($request->position,-3));
        $test = preg_match('/(.*)\_/', $request->position, $pos);
        $user->$type = $pos[1];
        $user->save();

        

        return redirect()->route('trainees')->with('message','Solo issued successfully');
        
    }
    public function viewProfile($cid){
        $trainee = Trainee::where('cid', $cid)->first();
        $table=strtolower($trainee->type)."_training_sheet";
        $items = DB::table($table)->get();
        $trainings = TrainingRequest::where('cid', $cid)->where('training_type', $trainee->type)->get();

        return view('training.profile', ['trainee'=>$trainee, 'trainings'=>$trainings, 'items'=>$items]);
     }

     public function terminateTraining($cid){
         $trainee = Trainee::where('cid', $cid)->first();
         $trainee->isActive = 0;
         $trainee->save();

         $user = User::where('cid', $cid)->first();
         $roles = explode(', ', $user->roles);
         $i=0;
         foreach ($roles as $role){
             if($role=="Trainee"){
                unset($roles[$i]);
             }
         $i++;
        }
        $user->roles = $roles;
        $user->save();

        return redirect()->route('home');

     }
}
