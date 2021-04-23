@extends('layouts.app')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{strtoupper($trainee->full_name)}}'S PROFILE</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Individual trainees profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">General info</h3>
                      </div>
                    <div class="card-body">
                        <strong>Type of training: </strong>{{$trainee->type}}<br>
                        <strong>Score: </strong>{{$trainee->overall_score}}<br>
                        <strong>Airports: </strong>{{$trainee->airports}}<br>
                        <strong>Solo: </strong>@if($trainee->hasSolo) {{$trainee->soloPosition}} @else Not active @endif
                    </div>
                </div>
                @if(in_array('TD', explode(', ', auth()->user()->roles)))
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Manage training</h3>
                      </div>
                    <div class="card-body">
                        This should be used in 2 occasions: <br>
                        1. If the trainee wished to terminate his training<br>
                        2. If TD Director decided to end training for this trainee<br><br>
                        <button type="button" class="btn btn-danger" style="background-color: red;"><a href="/terminate_training/{{$trainee->cid}}" class="text-white" style="text-decoration: none;">Cancel training</a></button>
                    </div>
                </div>
                @endif
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Training logs</h3>
                      </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Training date</th>
                                        <th>Mentor</th>
                                        <th>Mentor's notes</th>
                                        @foreach($items as $item)
                                        <th style="writing-mode: vertical-rl; ">{{$item->item}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trainings as $training)
                                    @if($training->sheet)
                                        <tr>
                                            <td>{{$training->date}}</td>
                                            <td>{{$training->mentor_id}}</td>
                                            <td>{{$training->mentor_notes}}</td>
                                            @php $i=0; @endphp
                                            @foreach(json_decode($training->sheet, true) as $stavka)
                                            <td>{{$stavka[$i]}}</td>
                                            @php $i++; @endphp
                                            @endforeach
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
  
@endsection