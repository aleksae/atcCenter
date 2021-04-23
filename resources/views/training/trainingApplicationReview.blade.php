@extends('layouts.app')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Review members training application</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Training application review</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">

                    <div class="card-body">
                        @foreach($prijave as $prijava)
                        <strong>Full name: </strong>{{$prijava->full_name}}<br>
                        <strong>CID: </strong>{{$prijava->cid}}<br>
                        <strong>Type of training: </strong>Member is applying for <em>{{$prijava->type}}</em> training<br>
                        <strong>Desired FIR: </strong>{{$prijava->FIR}}<br>
                        @if($prijava->letter)
                        <strong>Motivational lettter: </strong>{{$prijava->letter}}<br>
                        @endif
                        @php
                        $id=$prijava->id;
                        $cid=$prijava->cid;
                        $tip=$prijava->type;
                        @endphp
                        @endforeach
                    </div>
                </div>
                <div class="card card-default">
                    <div class="card-body">
                        @foreach($opsteInfo as $info)
                        <strong>Region: </strong>{{$info->region}}<br>
                        <strong>Division: </strong>{{$info->division}}<br>
                        @if($info->subdivision)
                        <strong>Subdivision: </strong>{{$info->subdivision}}<br>
                        @endif
                        <strong>Rating: </strong>{{$info->rating}}<br>
                        @php
                            $rating=$info->rating;
                        @endphp
                        @endforeach
                    </div>
                </div>
                @if($rating!="OBS" && $rating!="S1")
                <div class="card card-default">
                    <div class="card-body">
                        @php
                             try{$url2='https://api.vatsim.net/api/ratings/'.$cid.'/rating_times/';
                                $json1 = file_get_contents($url2);
                                $satnica = json_decode($json1,true);}
                                catch(Exception $e){
                                    $satnica[strtolower($rating)]=00;;
                                }
                                $vreme=$satnica[strtolower($rating)];
                                            $vreme_sekunde=$vreme*3600;
                                            $vreme_minuti=intdiv($vreme_sekunde,60);
                                            $vreme_sekunde%=60;
                                            $vreme_sati=intdiv($vreme_minuti,60);
                                            $vreme_minuti%=60;
                                            if($vreme_minuti<10){
                                                $vreme_minuti='0'.$vreme_minuti;
                                            }

                                            if($vreme_sati<10){
                                                $vreme_sati='0'.$vreme_sati;
                                            }


                        @endphp
                    <strong>Hours on previous rating: </strong>{{$vreme_sati.":".$vreme_minuti}}<br>
                        <strong>Distinct stations that applicant have been controlling:</strong>
                        <?php
                        $url='https://api.vatsim.net/api/ratings/'.$cid.'/atcsessions/';
                        try{$json = file_get_contents($url);
                            $konekcije = json_decode($json,true);}
                        catch(Exception $e){$konekcije = [];}
                        $listaKonekcija=[];
                        if($konekcije){
                            $retjing = $rating;
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
                                if($konekcija['rating']==($rejting-1)){
                                    array_push($listaKonekcija, $konekcija['callsign'] );
                                }
                            }
                        }
                        else{
                            $konekcije['next']=[];
                            echo "No connections";
                        }
                        while($konekcije['next']){
                            $url=$konekcije['next'];
                            $json = file_get_contents($url);
                            $konekcije = json_decode($json,true);
                            if($konekcije){
                                foreach($konekcije['results'] as $konekcija ) {
                                    if($konekcija['rating']==($rejting-1)){
                                        array_push($listaKonekcija, $konekcija['callsign'] );
                                    }
                                }
                            }else{
                                $konekcije['next']=[];
                            }}
                        $jedinstveneStanice = array_unique($listaKonekcija);?>
                        @foreach($jedinstveneStanice as $jedinstvenaStanica)
                            {{$jedinstvenaStanica}}
                            @if(next($jedinstveneStanice))
                                ,
                                @endif
                        @endforeach

                    </div>
                </div>
                @endif
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Process this application</h3>
                        <div class="card-tools">
                          <!-- Buttons, labels, and many other things can be placed here! -->
                          <!-- Here is a label for example -->
                          <span class="badge badge-info">TD</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form" method="POST" action="{{route('send_review_application')}}">
                            @csrf
                            <input type="hidden" name="id" value={{$id}}>
                            <input type="hidden" name="cid" value={{$cid}}>
                            <div class="form-group">
                                <label>Status</label><br>
                                <select class="form-control" aria-label="Default select example" id="status" name="status" required onchange="yesnoCheck(this);">
                                    <option value="Accepted">Accepted</option>
                                    <option value="Denied">Denied</option>
                                    <option value="On hold" selected>On hold</option>
                                </select>
                            </div>
                            <div class="form-group" id="pozicija" style="display: none;">
                                <label>Main position</label><br>
                                @php
                                $trening="";
                                    if($tip=="S2"){
                                        $trening="TWR";
                                    }elseif($tip=="S3"){
                                        $trening="APP";
                                    }else{
                                        $trening="CTR";
                                    }
                                @endphp

                                <select class="form-control mbd-select" aria-label="Default select example" id="position" name="position" required>

                                    @foreach($pozicije as $pozicija)
                                    @if($pozicija->$trening==1)
                                    <option value="{{$pozicija->station}}_{{$trening}}">{{$pozicija->station}}_{{$trening}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>

                          <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" rows="5" placeholder="Enter your notes/message" id="notes" name="notes"  required>

                            </textarea>
                            </div>
                            <input type="submit" class="btn btn-info"/>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
    function yesnoCheck(that) {
        if (that.value == "Accepted") {
            document.getElementById("pozicija").style.display = "block";
            document.getElementById("notes").value='Congratulations. Apply for training in Training->request a training. For the first session, under type put: "Initial".';
        }else if(that.value == "Denied"){
            document.getElementById("notes").value='Unfortunately, you do not meet the requirements to start training with us. For more information contact our Membership department at membership@vatadria.net. Better luck next time';
        }else{
            document.getElementById("pozicija").style.display = "none";
        }
    }
    </script>
@endsection
