<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\TrainingRequest;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(){
        $title = 'ATC Center';
        $trainings=TrainingRequest::where('cid',auth()->user()->cid)->orderBy('date','desc')->take(3)->get();
        $bookings=Booking::all();
        $events=Event::all();
        return view('home',['trainings'=>$trainings, 'bookings'=>$bookings, 'events'=>$events])->with('title', $title);
    }

}
