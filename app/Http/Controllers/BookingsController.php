<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(){
        $bookings = Booking::orderBy('date', 'asc')->orderBy('end', 'asc')->get();
        foreach($bookings as $booking){
            $date = new DateTime($booking->date);
            $date = date_format($date, 'd.m.Y.');
            if(!($date>=Carbon::now()->format('d.m.Y.'))){
                $book = Booking::find($booking->id);
                $book->delete();
            }
        }
        return view('bookings',['bookings'=>$bookings]);
    }

    public function create(Request $request){

        $rules = [
            'cid' => 'required|integer',
            'name'=> 'required|regex:/^[a-zA-Z\s]+$/',
            'date'=> 'required|date_format:m/d/Y',
            'start' => 'date_format:H:i',
            'end' => 'date_format:H:i|after:start',
            'position'=>'required|regex:/^[a-zA-Z_\s]+$/'
         ];
            /* $customMessage = [
            'letter.regex' => 'Only letters, dots, numbers and spaces are allowed.',
          ]; */
            $this->validate($request, $rules);
        $date=date_create($request->date);
        $controller = $request->name;
        $callsign = $request->position;
        $start = Carbon::createFromFormat('H:i', $request->start)->setDateFrom($date);
        $end = Carbon::createFromFormat('H:i', $request->end)->setDateFrom($date);
        $cid = $request->cid;
        $localid=floor($cid / (date('z') + 1));
        $training = 0;
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
           if(in_array('Events', explode(', ', auth()->user()->roles))){
            if($request->type=='event'){
                $booking->type='event';
            }else{
                $booking->type=0;
            }
        }
           
           $booking->local_id=$localid; 
           $booking->eu_id=0;
           $booking->save();
          return redirect()->route('bookings')->with('message', 'Successfully created booking for '.$date->format('d.m.Y').' from '.$start->format('H:i').'z to '.$end->format('H:i').'z at '.$callsign);
        }else{
            return back()->with('error', 'Booking already exists')->withInput();
        }      
        
    }
    public function delete($id){
        $booking = Booking::find($id);
        $booking->delete();
        return redirect()->route('bookings')->with('messageBooking', 'Booking removed successfully');

    }
}
