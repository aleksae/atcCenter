@extends('layouts.app')
@section('content')
@section('title','Bookings')
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
                        <h1>ATC Bookings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Bookings</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="row">
                    <div class="col">
                <div class="card card-default">
                    <div class="card-header card-blue">
                        <h3 class="card-title text-white">ATC Bookings - overview</h3>


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if (session('messageBooking'))
                        <div class="alert alert-success">
                            {{ session('messageBooking') }}
                        </div>
                    @endif
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
                                @foreach($bookings as $booking)
                                @php
                                     $date = new DateTime($booking->date);
                                     $date = date_format($date, 'd.m.Y.')
                                @endphp
                                @if($date>=Carbon\Carbon::now()->format('d.m.Y.'))
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
                            </tbody>

                        </table>
                    </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
        </div>
        <!-- ovde gotova 1. kolona -->
        <!-- 2. kolona-->
        
                    <form action="{{route('create_booking')}}" method="POST">
                        @csrf
                            <!-- left column -->
                            <div class="col">
                              <!-- general form elements -->
                              <div class="card card-primary">
                                <div class="card-header card-blue">
                                  <h3 class="card-title">Make a booking</h3>

                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" method="POST" action="{{route('sendApplication')}}">
                                  <div class="card-body">
                                    @if (session('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                                    <div class="row">
                                    <div class="form-group col">
                                      <label for="cid">CID</label>
                                      <input readonly type="text" class="form-control" name="cid" id="cid" value="{{auth()->user()->cid}}">
                                      <div class="badge badge-danger">{{ $errors->first('cid') }}</div>
                                    </div>
                                    <div class="form-group col">
                                      <label for="name">Full name</label>
                                      <input readonly type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}} {{auth()->user()->last_name}}">
                                      <div class="badge badge-danger">{{ $errors->first('name') }}</div>
                                    </div>
                                  </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label>Date [m/d/Y]</label>
                                            <input class="date form-control" name="date" type="text" id="datepicker" value="{{old('date')}}">
                                          </div>
                                          <div class="badge badge-danger">{{ $errors->first('date') }}</div>
                                      <div class="form-group col">
                                          @php
                                              $gnd=explode(', ', auth()->user()->gnd);
                                              $twr=explode(', ', auth()->user()->twr);
                                              $app=explode(', ', auth()->user()->app);
                                              $ctr=explode(', ', auth()->user()->ctr);
                                              $hasPositions=1;
                                          @endphp
                                        
                                          <label >Position</label><br>
                                          @if($gnd[0]==NULL && $twr[0]==NULL && $app[0]==NULL && $ctr[0]==NULL)
                                          @php $hasPositions=0; @endphp
                                         <input type="text" readonly class="bg-danger form-control" value="No positions to book">
                                         @else
                                          <select class="form-control" aria-label="Default select example" id="position" name="position">
                                              
                                              @foreach($gnd as $position)
                                              @if($position)
                                              <option value="{{$position}}_GND" {{ (old('position')==$position."_GND") ? 'selected' : ''}}>{{$position}}_GND</option>
                                              @endif
                                              @endforeach
                                              @foreach($twr as $position)
                                              @if($position)
                                              <option value="{{$position}}_TWR" {{ (old('position')==$position."_TWR") ? 'selected' : ''}}>{{$position}}_TWR</option>
                                              @endif
                                              @endforeach
                                              @foreach($app as $position)
                                              @if($position)
                                              <option value="{{$position}}_APP" {{ (old('position')==$position."_APP") ? 'selected' : ''}}>{{$position}}_APP</option>
                                              @endif
                                              @endforeach
                                              @foreach($ctr as $position)
                                              @if($position)
                                              <option value="{{$position}}_CTR" {{ (old('position')==$position."_CTR") ? 'selected' : ''}}>{{$position}}_CTR</option>
                                              @endif
                                              @endforeach
                                              
                                          </select>
                                          @endif
                                          <div class="badge badge-danger">{{ $errors->first('fir') }}</div>
                                      </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Start time:</label>
                                                <input class="timepicker form-control" id="timepicker" name="start" type="text" value="{{old('start')}}">
                                              </div>
                                              <div class="badge badge-danger">{{ $errors->first('start') }}</div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>End time:</label>
                                                <input class="timepicker form-control" id="timepicker2" name="end" type="text" value="{{old('end')}}">
                                              </div>
                                              <div class="badge badge-danger">{{ $errors->first('end') }}</div>
                                        </div>
                                    </div>
                                    @if(in_array('Events', explode(', ', auth()->user()->roles)))
                                    <div class="form-group">
                                        <label for="name">Type</label>
                                        <select class="form-control" aria-label="Default select example" id="type" name="type">
                                        <option value="regular">Regular</option>
                                        <option value="event">Event</option>
                                        </select>
                                        <div class="badge badge-danger">{{ $errors->first('type') }}</div>
                                      </div>
                                    @endif




                                  <!-- /.card-body -->


                                    <button type="submit" class="btn" @if($hasPositions==0) {{'disabled'}}@endif>Submit</button>
                                  </div>
                                </form>
                                
            <!-- /.row -->
        
    </div>
    <!-- kraj 2. kolone-->
        </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
         today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            minDate: today
        });
    </script>
    <script>
        $('#timepicker').timepicker({
            uiLibrary: 'bootstrap4',
            mode: '24hr',
        });
        $('#timepicker2').timepicker({
            uiLibrary: 'bootstrap4',
            mode: '24hr',
     });
      </script>      
@endsection
