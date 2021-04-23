<?php
$cid='1400612';
$url='https://api.vatsim.net/api/ratings/'.$cid.'/atcsessions/';
try{$json = file_get_contents($url);
$konekcije = json_decode($json,true);}
catch(Exception $e){$konekcije = [];}
$listaKonekcija=[];
if($konekcije){
    $retjing = "C1";
    switch ($retjing) {
        case "OBS":
            $rejting="1";
            break;
            case "S1":
                $rejting="2";
                break;
                case "S2":
                    $rejting="3";
                    break;
                    case "S3":
                        $rejting="4";
                        break;
                        case "C1":
                            $rejting="5";
                            break;
                            case "C3":
                                $rejting="6";
                                break;
                                case "I1":
                                    $rejting="7";
                                    break;
}
foreach($konekcije['results'] as $konekcija ) {
    if($konekcija['rating']==$rejting-1){
            array_push($listaKonekcija, $konekcija['callsign'] );
            echo $konekcija['callsign']."-".$konekcija['rating']."<br>";
        }
        }
        }
else{
        $konekcije['next']=[];
    }
while($konekcije['next']){
    $url=$konekcije['next'];
    $json = file_get_contents($url);
    $konekcije = json_decode($json,true);
    if($konekcije){
        foreach($konekcije['results'] as $konekcija ) {
            if($konekcija['rating']==$rejting-1){
                array_push($listaKonekcija, $konekcija['callsign'] );
            }
        }
    }else{
        $konekcije['next']=[];
    }}
$jedinstveneStanice = array_unique($listaKonekcija);?>
@foreach($jedinstveneStanice as $jedinstvenaStanica)
    {{$jedinstvenaStanica}},
@endforeach

