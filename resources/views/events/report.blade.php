@extends('layouts.app')
@section('content')
@section('title','Report availability')
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
                        <h1>Report availability</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Event availability report</li>
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
                                  <h3 class="card-title">Report availability</h3>

                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" method="POST" action="{{route('report.avlb')}}">
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
                                            <label>Event name</label>
                                            <input readonly class="form-control" name="name" type="text"  value="{{$event->name}}">
                                          </div>
                                          <div class="badge badge-danger">{{ $errors->first('name') }}</div>
                                        <div class="form-group col">
                                            <label>Date [m/d/Y]</label>
                                            <input readonly class="date form-control" name="date" type="text"  value="{{$event->date}}">
                                          </div>
                                          <div class="badge badge-danger">{{ $errors->first('date') }}</div> 
                                    </div>
                                    <input readonly style="display: none;" name="id" type="text" value={{$event->id}}>
                                    <input readonly style="display: none;" name="start_old" type="text" id="start" value={{$event->start}}>
                                    <input readonly style="display: none;" name="start_new" type="text" id="end" value={{$event->end}}>
                                    <div class="form-group">
                                        <label>Status</label><br>
                                        <select class="form-control" aria-label="Default select example" id="status" name="status" required onchange="yesnoCheck(this);">
                                            <option value="Not available">Not available</option>
                                            <option value="Available">Available</option>
                                        </select>
                                    </div>
                                    <div class="row" id="pozicija" style="display: none;">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Start time:</label>
                                                <input class="timepicker form-control" id="timepicker" name="start" type="text" value="">
                                              </div>
                                              <div class="badge badge-danger">{{ $errors->first('start') }}</div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>End time:</label>
                                                <input class="timepicker form-control" id="timepicker2" name="end" type="text" value="">
                                              </div>
                                              <div class="badge badge-danger">{{ $errors->first('end') }}</div>
                                        </div>
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
    <script type="text/javascript">
        var start = document.getElementById("start").value;
        var end = document.getElementById("end").value;
        $('#timepicker').timepicker({
            uiLibrary: 'bootstrap4',
            mode: '24hr',
            value: start
        });
        $('#timepicker2').timepicker({
            uiLibrary: 'bootstrap4',
            mode: '24hr',
            value:  end
     });
 

      </script>   
      
      <script>
        function yesnoCheck(that) {
            if (that.value == "Available") {
                document.getElementById("pozicija").style.display = "block";
            }else if(that.value == "Not available"){
                document.getElementById("pozicija").style.display = "none";
            }
        }
        </script>


@endsection
