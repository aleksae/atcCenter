@extends('layouts.app')
@section('content')
@section('title','Events')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Events</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Events</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                
                <div class="card h-50">
                    <div class="card-header">
                        <h3 class="card-title">List of events</h3>
                        <div class="card-tools">
                            <!-- Buttons, labels, and many other things can be placed here! -->
                            <!-- Here is a label for example -->
                            <span class="badge badge-primary">Events</span>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body ">
                        @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if(in_array('Events', explode(", ", auth()->user()->roles)))<div class="float-right mb-2"><button class="btn"><a href="create_event" class="text-white" style="text-decoration:none;">Create event</a></button></div>@endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Event name</th>
                                    <th scope="col">Reported availability</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Assigned time</th>
                                    <th scope="col">Notes</th>
                                    @if(in_array('Events', explode(', ', auth()->user()->roles)))
                                    <th scope="col">Events team</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    
                                @if(empty($events))
                                <tr><td colspan="7">No events</td></tr>
                                @else 
                                @foreach($events as $event)
                                <tr>
                                    
                                    <td><strong>{{$event->name}} | {{date('d.m.Y', strtotime($event->date))}} | {{$event->start}}-{{$event->end}}</strong></td>
                                    @php
                                    
                                    $reports = json_decode($event->reports);
                                    $start=0;
                                    $end=0;
                                    if($reports==NULL){$reports=[];}
                                    $reported=false;
                                    for($i=0; $i<count($reports); $i++){
                                        if($reports[$i]->cid==auth()->user()->cid){
                                            $reported=true;
                                            $start = $reports[$i]->start;
                                            $end = $reports[$i]->end;

                                        } 
                                    } 

                                @endphp

                                <!-- TEST -->

                                @php
                                    $roster = json_decode($event->roster, true);
                                    $check = 0;
                                @endphp

                                <!-- KRAJ TEST -->
                                    <td>{{$start}} - {{$end}}</td>
                                
                                    <td>@if($reported)<span class="badge badge-warning">Reported</span>@else<span class="badge badge-danger">Not reported</span>@endif @if($event->roster)<span class="badge badge-success">Roster available</span>@endif</td>
                                    <td>
                                        @if($roster==NULL)@php $roster=[];@endphp @endif
                                        @foreach($roster as $first)
                                            @foreach($first as $pos)
                                            @if($pos['atcs']!=NULL)
                                                @if(in_array(auth()->user()->cid,$pos['atcs']))
                                                @php $check=1; @endphp
                                                <span class="badge badge-success">{{$pos['airport']}}</span>
                                                @endif
                                            @endif
                                            @endforeach
                                        @endforeach
                                        @if($check==0)
                                        <span class="badge badge-warning">No info</span>
                                        @endif
                                    </td>
                                    <td>@if($check==1)<span class="badge badge-success">
                                        {{$start}}-{{$end}}</span>@else <span class="badge badge-warning">No info</span> @endif</td>
                                    <td>@if(!$event->roster)
                                        @if(!$reported)<a class="text-info" href="/report_avlb/{{$event->id}}">Report avaliability</a>
                                    @else <a class="text-info" href="/update_avlb/{{$event->id}}">Update avaliability</a> @endif @else {{$event->notes}} @endif</td>
                                    @if(in_array('Events', explode(', ', auth()->user()->roles)))
                                    <td scope="col"><a class="text-info" href="roster/{{$event->id}}">Manage roster</a></td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif

                                </tbody>
                                
                            </table>
                        </div>

                    </div>
            </div>
            <!-- /.row -->
        

    <!-- kraj 2. kolone-->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

   


@endsection
