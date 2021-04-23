@extends('layouts.app')
@section('content')
    <style>
        @media only screen and (max-width: 1000px) {
            .conn {
                display:none;
            }
        }
    </style>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="../../dist/img/ikona.png"
                                         alt="User profile picture">
                                </div>
                                <?php
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
                                ?>

                                <h3 class="profile-username text-center">{{auth()->user()->name}} {{auth()->user()->last_name}}</h3>

                                <p class="text-muted text-center">Controller</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Controller rating</b> <a class="float-right">{{auth()->user()->rating}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Online hours</b> <a class="float-right"><?php
                                            $vreme=$satnica['atc'];
                                            $vreme_sekunde=$vreme*3600;
                                            $vreme_minuti=intdiv($vreme_sekunde,60);
                                            $vreme_sekunde%=60;
                                            $vreme_sati=intdiv($vreme_minuti,60);
                                            $vreme_minuti%=60;
                                            if($vreme_minuti<10){
                                                $vreme_minuti='0'.$vreme_minuti;
                                            }
                                            if($vreme_sekunde<10){
                                                $vreme_sekunde='0'.$vreme_sekunde;
                                            }
                                            if($vreme_sati<10){
                                                $vreme_sati='0'.$vreme_sati;
                                            }

                                            echo $vreme_sati.":".$vreme_minuti.":".$vreme_sekunde;
                                            ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Division</b> <a class="float-right">{{auth()->user()->division}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>View all conections</b>: <a href="" data-toggle="modal" data-target="#exampleModal" class="float-right" style="color: #2c0289">All connections</a>
                                          
                                    </li>
                                    <!-- MODAL -->
                                    
                                </ul>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">All connections</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  @include('connections')
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>


                    </div>
                    <!-- /.col -->

                                <div class="card ml-3 mr-4 col card-outline card-warning conn">
                                    <div class="card-header">
                                        <h3 class="card-title">My last connections</h3>
                                        <div class="card-tools">
                                            <!-- Buttons, labels, and many other things can be placed here! -->
                                            <!-- Here is a label for example -->
                                            <span class="badge badge-primary">ATC</span>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
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

                                        if($konekcije){
                                        foreach($konekcije['results'] as $konekcija ) {
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
                                            ?><tr><td colspan="3">You don't have any connections.</td></tr><?php
                                        }

                                            ?>
                                            </tbody>
                                            </table>
                                    </div>
                                    <!-- /.card-body -->

                                    <!-- /.card-footer -->
                                </div>
                                <!-- /.card -->
                                <!--drugi deo-->

                                    <!-- /.card-body -->

                                    <!-- /.card-footer -->
                    <div class="card card-outline card-success h-50 col">
                        <div class="card-header">
                            <h3 class="card-title">Training status</h3>
                            <div class="card-tools">
                                <!-- Buttons, labels, and many other things can be placed here! -->
                                <!-- Here is a label for example -->
                                <span class="badge badge-primary">TD</span>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(!$provera)
                            <strong>Training status: </strong><span class="badge badge-warning">Not on training</span>
                            <hr>
                            @else
                            @if($provera->isActive==1)
                            <strong>Training status: </strong><span class="badge badge-success">Active</span>
                            <hr>
                            <strong>Training: </strong><span class="badge badge-info">For {{$provera->type}} rating</span>
                            <hr>
                            <strong>Number of session: </strong><span class="badge badge-info">{{$treningCount}}</span>
                            <hr>
                            <strong>Status: </strong>[{{$provera->overall_score}}% Complete]<div class="progress">
                                <div class="progress-bar  @if($provera->overall_score<=30.00)
                                bg-danger
                                @elseif($provera->overall_score>30.00 && $provera->overall_score<90.00)
                                      bg-warning
                                      @else
                                      bg-success
                                      @endif" role="progressbar" aria-valuenow="60"
                                     aria-valuemin="0" aria-valuemax="100" style="width: {{$provera->overall_score}}%;">
                                     
                                </div>
                            </div>
                            <hr>
                            <strong>Training approval date: </strong><span class="badge badge-info">{{ \Carbon\Carbon::parse($trening_start->updated_at)->format('d.m.Y.')}}</span>
                            <hr><strong>Last training date: </strong>
                            @if(!(empty($trening_datum[0])))
                            @php
                              $trening= explode("/", $trening_datum[0]->date);
                            @endphp
                            <span class="badge badge-info">{{$trening[0]}}.{{$trening[1]}}.{{$trening[2]}}.</span>
                            @else
                            <span class="badge badge-info">No trainigs yet</span>
                            @endif
                            <hr>
                            <strong>Solo validation: </strong> @if($provera->hasSolo) <span class="badge badge-success">{{$provera->soloPosition}}</span> @else<span class="badge badge-warning">Not active</span> @endif
                            @else
                            <strong>Training status: </strong><span class="badge badge-danger">Not active</span>
                            <hr>
                            @endif
                            @endif
                        </div>
                        <!-- /.card-body -->

                        <!-- /.card-footer -->
                    </div>
                                </div>
                            </div>
                            <!--novi red-->



        </section>
        <!-- /.content -->
    </div>
@endsection
