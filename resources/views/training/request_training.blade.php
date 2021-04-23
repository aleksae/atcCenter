@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Request a training session</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Request a training</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content"> 
        <div class="card-body col">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{route('store.request')}}" method="POST">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                      <!-- general form elements -->
                      <div class="card card-primary">
                        <div class="card-header card-blue">
                          <h3 class="card-title">Training request form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                          <div class="card-body">
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
                                  <label >Type of session</label><br>
                                  <select class="form-control" aria-label="Default select example" id="type" name="type">
                                      <option value="online">Online</option>
                                      <option value="sweatbox">Sweatbox</option>
                                      <option value="introductory">Introductory</option>
                                      <option value="theory">Theory</option>
                                      <option value="other">Other</option>
                                  </select>
                                  <div class="badge badge-danger">{{ $errors->first('type') }}</div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                    <label>Date:</label>
                                    <input class="date form-control" name="date" type="text" value="{{old('date')}}">
                                  </div>
                                  <div class="badge badge-danger">{{ $errors->first('date') }}</div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Start time:</label>
                                        <input class="timepicker form-control" name="start" type="text" value="{{old('start')}}">
                                      </div>
                                      <div class="badge badge-danger">{{ $errors->first('start') }}</div>
                                  </div>
                                <div class="col">
                                  <div class="form-group">
                                      <label>End time:</label>
                                      <input class="timepicker form-control" name="end" type="text" value="{{old('end')}}">
                                    </div>
                                    <div class="badge badge-danger">{{ $errors->first('end') }}</div>
                                </div>
                              </div>
                              @php
                              $type="";
                              if($traineeInfo->type=="S2"){
                                  $type="TWR";
                              }elseif($traineeInfo->type=="S3"){
                                  $type="APP";
                              }else{
                                  $type="CTR";
                              }
                              @endphp

                              
                                    <div class="form-group">
                                        <label>Position:</label>
                                        <select class="form-control" aria-label="Default select example" id="position" name="position" required>
                                            @foreach(explode(", ", $traineeInfo->airports) as $airport)
                                            <option value="{{$airport."_".$type}}" {{ (old('position')==$airport."_".$type) ? 'selected' : ''}}>{{$airport."_".$type}}</option>
                                            @endforeach
                                        </select>

                                      <div class="badge badge-danger">{{ $errors->first('position') }}</div>
                                  </div>
                                
                          <!-- /.card-body -->
                          <input type="submit" class="btn" style="background-color: #2c0289; color: white;">
                          </form>
                          </div>

       
                      </div>
                    </div>
                    <div class="col">
                      <div class="card">
                        <div class="card-header card-blue">
                          <h3 class="card-title" style="color: white;">My requests</h3>
                          <div class="card-tools">
                            <!-- Buttons, labels, and many other things can be placed here! -->
                            <!-- Here is a label for example -->
                            <span class="badge badge-primary">TD</span>
                          </div>
                          <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          @if($requests->count() > 0)
                          <div class="table-responsive" >
                          <table class="table table-striped" id="laravel_crud">
                            <thead>
                              <tr>
                                <th scope="col">Position</th>
                                <th scope="col">Date and time</th> 
                                <th scope="col">Status</th>
                                <th scope="col">Notes</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($requests as $training)
                              <tr id="row_{{$training->id}}">
                                <td>{{$training->position}}</td>
                                <td>{{$training->date}} [{{$training->start_time}}-{{$training->end_time}}]</td>
                                <td> 
                                @if($training->status=="Fail")
                                <span class="badge badge-danger">{{$training->status}}<span>
                                @elseif($training->status=="Taken")
                                <span class="badge badge-success">{{$training->status}}<span>
                                @else
                                <span class="badge badge-warning">{{$training->status}}<span>
                                @endif
                                 </td>
                                <td>@if($training->mentor_name)
                                  Your mentor is: <strong>{{$training->mentor_name}} [{{$training->mentor_id}}]</strong>
                                  @endif
                                  {{$training->notes}}</td>

                                <td>
                                  @php
                                      $date = explode('/', $training->date);
                                      $date = $date[0].".".$date[1].".".$date[2];
                                      $d1= $date." ".$training->end_time;
                                      $d1 = new DateTime($d1);
                                      $d2 = new DateTime(Carbon\Carbon::now());
                                        
                                  @endphp   
                                  @if(($training->mentor_notes===NULL)&&($d1>=$d2))<a href="{{route('delete.request',['id' => $training->id])}}"  class="link text-danger">Delete</a>
                                @elseif(!$training->mentor_rating)
                                <form method="POST" action="submit_rate">
                                  @csrf
                                  <input type="hidden" name="id" value={{$training->id}}>
                                  <div class="form-group col w-100">
                                    <label >Rate mentor</label><br>
                                    <select class="form-control" aria-label="Default select example" id="mentor" name="mentor">
                                        <option value="1" >1</option>
                                        <option value="2" >2</option>
                                        <option value="3" >3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>

                                    </select>  
                                </div>
                                  <input type="Submit" class="btn btn-info">
                                </form>
                                @else No actions to take. @endif</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          {{$requests->links()}} 
                          
                        </div>
                          @else
                              <h5>You don't have training requests.</h5>
                          @endif
                        </div>
                      
                      </div>
                      <!-- /.card -->
                    </div>
                </div>




            <!-- /.col (right) -->
<div >
  
    </div>
    </section>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
 <script type="text/javascript">
    $('.date').datepicker({
       format: 'dd/mm/yyyy'
     });
</script>
<script type="text/javascript">

    $('.timepicker').datetimepicker({

        format: 'HH:mm'

    });

</script>

@endsection
