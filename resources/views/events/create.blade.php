@extends('layouts.app')
@section('content')
@section('title','Create event')
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
                        <h1>Create event</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create event</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
     
 
        <!-- ovde gotova 1. kolona -->
        <!-- 2. kolona-->
        
                      
                            <!-- left column -->
         
                              <!-- general form elements -->
                              <div class="card card-primary">
                                <div class="card-header card-blue">
                                  <h3 class="card-title">Make a booking</h3>

                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" method="POST" action="{{route('create.event')}}">
                                    @csrf
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
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="">
                                        <div class="badge badge-danger">{{ $errors->first('name') }}</div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" rows="5" placeholder="Your motivational letter" id="description" name="description" required >{{ old('letter') }}</textarea>
                                                <div class="badge badge-danger">{{ $errors->first('description') }}</div>
                                              </div>    
                                    </div>
                                    
                                  </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label>Date [m/d/Y]</label>
                                            <input class="date form-control" name="date" type="text" id="datepicker" value="{{old('date')}}">
                                          </div>
                                          <div class="badge badge-danger">{{ $errors->first('date') }}</div>
                                      <div class="form-group col">
                                          <label >Type</label><br>
                                          <select class="form-control" aria-label="Default select example" id="type" name="type">                                    
                                              <option value="Weekly" >Weekly</option>
                                              <option value="Exam" >Exam</option>
                                              <option value="Other" >Other</option>
                                          </select>
                                          <div class="badge badge-danger">{{ $errors->first('type') }}</div>
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
                                  
                                        <div class="form-group">
                                            <label for="name">Airports<span class="text-red">*</span></label>
                                            <input type="text" class="form-control" id="airports" name="airports" value="" placeholder="Enter ICAO codes of airports, separted by commas, with big letter. Example: LYBE, LQSA, LWSK...">
                                            <div class="badge badge-danger">{{ $errors->first('name') }}</div>
                                            <span class="text-red">*Bookings will be created for these airpors [TWR and APP, if any] as well as ADR_CTR if it's a weekly event. Additional
                                                bookings need be done manually.
                                            </span>
                                        </div>
                                 




                                  <!-- /.card-body -->


                                    <button type="submit" class="btn" >Submit</button>
                                  </div>
                                </form>
                                
            <!-- /.row -->
        

    <!-- kraj 2. kolone-->

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
