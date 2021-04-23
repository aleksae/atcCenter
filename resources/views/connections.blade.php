
    @php
    $i=0;
/*  $cid=auth()->user()->cid; */
$cid=auth()->user()->cid;
                                $url='https://api.vatsim.net/api/ratings/'.$cid.'/atcsessions/';
                                try{
                                $json = file_get_contents($url);
                                $konekcije = json_decode($json,true);
                                $url2='https://api.vatsim.net/api/ratings/'.$cid.'/rating_times/';
                                $json1 = file_get_contents($url2);
                                $satnica = json_decode($json1,true);}
                                catch(Exception $e){
                                    $konekcije = [];
                                    
                                    $satnica['atc']=00;;
                                }
    @endphp
    <?php if($konekcije){?>
    <table class="table table-hover table-responsive">
        <thead>
        <tr>
            <th scope="col">Postion</th>
            <th scope="col">Date</th>
            <th scope="col">Duration</th>


        </tr>
        </thead>
        <tbody>
        <?php

        
        foreach($konekcije['results'] as $konekcija ) {
            $i++;
        $pocetak=date("d.m.Y", strtotime($konekcija['start']));?>
        <tr>

            <td><?php echo $konekcija['callsign'] ?></td>
            <td><?php echo $pocetak ?></td>
            <td><?php $ulaz = $konekcija['minutes_on_callsign'];
                $sati = intdiv($ulaz, 60);
                $minuti=$ulaz % 60;
                if($sati<10){
                    $sati='0'.$sati;
                } if($minuti<10){
                    $minuti='0'.$minuti;
                }
                echo $sati.":".$minuti;?></td>
        </tr><?php

        }}else{

        $konekcije['next']=[];
        }?>

    @php
        while($konekcije['next']){
        $url=$konekcije['next'];
        $json = file_get_contents($url);
        $konekcije = json_decode($json,true);

    @endphp

        <?php

        if($konekcije){
        foreach($konekcije['results'] as $konekcija ) {
            $i++;
        $pocetak=date("d.m.Y", strtotime($konekcija['start']));?>
        <tr>

            <td><?php echo $konekcija['callsign'] ?></td>
            <td><?php echo $pocetak ?></td>
            <td><?php $ulaz = $konekcija['minutes_on_callsign'];
                $sati = intdiv($ulaz, 60);
                $minuti=$ulaz % 60;
                if($sati<10){
                    $sati='0'.$sati;
                } if($minuti<10){
                    $minuti='0'.$minuti;
                }
                echo $sati.":".$minuti;?></td>
        </tr><?php

        }}}

        ?>
        </tbody>
        Total number of connections: <strong><?php echo($i);?></strong>
    </table>
