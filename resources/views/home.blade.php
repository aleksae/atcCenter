@extends('layouts.app')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                
                @if (session('permission'))
                    <div class="alert alert-danger">
                        Access to this page is restricted! If you think you should have option to
                        access this page, <a href="" class="text-white">contact web department</a>!
                    </div>
                @endif
                    @if (session('noAccess'))
                        <div class="alert alert-danger">
                            {{ session('noAccess') }}
                        </div>
                    @endif

            
                <div class="row">
                    @if(in_array("ATC", explode(', ',auth()->user()->roles)) || in_array("Visiting ATC", explode(', ',auth()->user()->roles)) || in_array("Trainee", explode(', ',auth()->user()->roles)))
                    <div class="card col h-50">
                        <div class="card-header">
                            <h3 class="card-title">Ongoing events</h3>
                            <div class="card-tools">
                                <!-- Buttons, labels, and many other things can be placed here! -->
                                <!-- Here is a label for example -->
                                <span class="badge badge-primary">Events</span>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body ">
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
                                    
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                @endif
                <!-- /.card -->
                    <!--drugi deo-->

                        <!-- /.card-body -->

                        <!-- /.card-footer -->

                </div>
                <!--novi red-->
                @if(in_array("Trainee",explode(", ", auth()->user()->roles)))
                <div class="row">
                    <div class="card mr-3 h-50">
                        <div class="card-header">
                            <h3 class="card-title">Training requests</h3>
                            <div class="card-tools">
                                <!-- Buttons, labels, and many other things can be placed here! -->
                                <!-- Here is a label for example -->
                                <span class="badge badge-primary">TD</span>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Position</th>
                                    <th scope="col">Date and time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Info</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @foreach($trainings as $training)

                                    <td>{{$training->position}}</td>
                                    <td>{{$training->date}} [{{$training->start_time}}-{{$training->end_time}}]</td>
                                    <td>@if($training->status=="Fail")
                                        <span class="badge badge-danger">{{$training->status}}<span>
                                        @elseif($training->status=="Taken")
                                        <span class="badge badge-success">{{$training->status}}<span>
                                        @else
                                        <span class="badge badge-warning">{{$training->status}}<span>
                                        @endif</td>
                                    <td scope="col">@if($training->mentor_name)
                                        Your mentor is: {{$training->mentor_name}} [{{$training->mentor_id}}]
                                        @endif
                                        {{$training->notes}}</td>
         
                                </tr>
                                @endforeach


                                </tbody>
                            </table>
                            Check all request <a href="{{route('request.training')}}">here</a>.
                        </div>
                        </div>
                        <!-- /.card-body -->

                        <!-- /.card-footer -->
                    </div>
                    @endif
                    <!-- /.card -->
                    <!--drugi deo-->
                    <div class="card col h-50">
                        <div class="card-header">
                            <h3 class="card-title">ATC bookings of the day</h3>
                            <div class="card-tools">
                                <!-- Buttons, labels, and many other things can be placed here! -->
                                <!-- Here is a label for example -->
                                <span class="badge badge-primary">ATC</span>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-resposnive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th>Controller</th>
                                            <th>Date</th>
                                            <th>Start</th>
                                            <th>End</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $provera=0; @endphp
                                        @foreach($bookings as $booking)
                                        @php
                                            $date = new DateTime($booking->date);
                                            $date = date_format($date, 'd.m.Y.');
                                            $provera = 0;
                                        @endphp
                                        @if($date==Carbon\Carbon::now()->format('d.m.Y.'))
                                        @php $provera =1;@endphp
                                        <tr>
                                            <td> @if($booking->cid==auth()->user()->cid)<span class="badge badge-danger mr-1"><a href="delete_booking/{{$booking->id}}" style="color: inherit; /* blue colors for links too */
                                                text-decoration: inherit; /* no underline */"><i class="fas fa-trash-alt"></i></a></span>@endif{{$booking->position}} @if($booking->type!=0)<span class="badge badge-info ">{{ucfirst($booking->type)}}</span> @endif
                                           </td>
                                            <td>{{$booking->controller}}</td>
                                            <td>{{date_create($booking->date)->format('d.m.Y')}}</td>
                                            <td>{{date_create($booking->start)->format('H:i')}}z</td>
                                            <td>{{date_create($booking->end)->format('H:i')}}z</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @if($provera==0)
                                            <tr class="center-block text-center"><td colspan="5">No bookings for today.</td></tr>
                                        @endif
                                    </tbody>
        
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
    </div>

@endsection
