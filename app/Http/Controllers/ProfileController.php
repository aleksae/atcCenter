<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Models\TrainingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(){

        $provera = Trainee::where('cid', auth()->user()->cid)->first();
        $trening_datum = TrainingRequest::where('cid', auth()->user()->cid)
        ->where('status', '=', 'Taken')
        ->where('mentor_notes', '!=', NULL)
        ->orderBy('date', 'desc')
        ->get();
        $treninglist = TrainingRequest::where('cid', auth()->user()->cid)->where('status', 'Taken')->get();
        $treningCount = $treninglist->count();    
        $trening_start = DB::table('training_applications')->where('cid', auth()->user()->cid)->orderBy('updated_at', 'desc')->first();


        
        return view('profile', ['provera'=>$provera, 'trening_datum'=>$trening_datum, 'treningCount'=> $treningCount, 'trening_start'=>$trening_start]);
    }
}
