<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtcsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(){
        $users1 = User::all();
        $users =[];
        foreach($users1 as $user){
            if(in_array('ATC',explode(', ',$user->roles)) || in_array('Visiting ATC',explode(', ',$user->roles)))
            array_push($users, $user);
        }

        return view('TD.atclist')->with(['users'=>$users]);
 
    }
    public function edit($id){
        $user = User::find($id);
        $airports = DB::table('airports')->get();
        $gnd=[]; $twr=[]; $app=[]; $ctr=[];
        foreach($airports as $airport){
            if($airport->GND==1){
                array_push($gnd, $airport->station);
            }elseif($airport->TWR==1){
                array_push($twr, $airport->station);
            }
            if($airport->APP==1){
                array_push($app, $airport->station);
            }
            elseif($airport->CTR==1){
                array_push($ctr, $airport->station);
            }
        }

        return view('TD.editAirports')->with(['user'=>$user, 'gnd'=>$gnd, 'twr'=>$twr, 'app'=>$app, 'ctr'=>$ctr]);
    }
    public function update(Request $request){
        $user = User::find($request->id);
        $ground = $request->input('gnd');
        if($ground!=''){
        $ground = implode(", ",$ground);
        }
        $twr = $request->input('twr');
        if($ground!=''){
        $twr = implode(", ",$twr);
        }
        $app = $request->input('app');
        if($ground!=''){
        $app = implode(", ",$app);
        }
        $ctr = $request->input('ctr');
        if($ground!=''){
        $ctr = implode(", ",$ctr);
        }
        $user->gnd = $ground;
        $user->twr = $twr;
        $user->app = $app;
        $user->ctr = $ctr;

        $user->save();

        return redirect()->route("atc_list")->with('message', 'Airports updated successfully!');
    }
    public function soloShow(){
        $trainees = Trainee::where('hasSolo', true)->get();
        return view('solo', ['trainees'=> $trainees]);
    }
}
