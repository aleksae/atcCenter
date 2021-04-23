<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(){
        $date =DateTime::createFromFormat('d/m/Y', '17/4/2021');
        $date=date_create('4/17/2021');
        $controller = 'Aleksa Eric';
        $callsign = 'LYBE_APP';
        $start = Carbon::createFromFormat('H:i', '23:56')->setDateFrom($date);
        $end = Carbon::createFromFormat('H:i', '23:59')->setDateFrom($date);
        $localid=floor(1400612 / (date('z') + 1));
        $cid = 1400612;
        $training = 0;
        $event = 0;
        $eu_id=1234;
        $firs=['LYBA', 'LJLA', 'LDZO', 'LQSB', 'LWSS', 'LAAA', 'KFOR'];
        $bookingsAll=[];
        $i=0;
        foreach($firs as $fir){
            $url = "http://vatbook.euroutepro.com/xml2.php?fir=".$fir;
            $bookings = simplexml_load_file($url);
            foreach($bookings->atcs->booking as $booking){
                if($booking){
                    print_r($booking);
                $bookingsAll[$i]=[
                    'callsign'=>$booking->callsign,
                    'time_start'=>$booking->time_start,
                    'time_end'=>$booking->time_end,
                    
                ];
                $i++;}
            }
        }
        foreach($bookingsAll as $booking){
            ?><b>callsign:</b><?php echo $booking['callsign'];?>
            <b>time:</b><?php echo $booking['time_start']."-".$booking['time_end']."<br>";
        }
      /*  $response = file_get_contents(str_replace(' ', '%20',"http://vatbook.euroutepro.com/atc/insert.asp?Local_URL=noredir&Local_ID={$localid}&b_day={$date->format('d')}&b_month={$date->format('m')}&b_year={$date->format('Y')}&Controller={$controller}&Position={$callsign}&sTime={$start->format('Hi')}&eTime={$end->format('Hi')}&cid={$cid}&T={$training}&E={$event}&voice=1"));
        print_r($response);
        preg_match_all('/EU_ID=(\d+)/', $response, $matches);
        $eu_id = $matches[1][0];  
        print_r($response);  
 */
        
        
    }
}
