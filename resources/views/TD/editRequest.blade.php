@extends('layouts.app')
@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage training request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage training request</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            

                <form action="{{route('store.edit.request')}}" method="POST" style="width: 100%;">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                        <!-- left column -->
                
                          <!-- general form elements -->
                          <div class="card card-primary">
                            <div class="card-header card-blue">
                              <h3 class="card-title">Manage this request</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                              <div class="card-body">
                                <div class="row">
                                  
                                  <input hidden type="text" class="form-control" name="id" id="id" value="{{$training->id}}">
                                  <input hidden type="text" class="form-control" name="start_old" id="id" value="{{$training->start_time}}">
                                  <input hidden type="text" class="form-control" name="end_old" id="id" value="{{$training->end_time}}">
                                <div class="form-group col">
                                  <label for="cid">CID</label>
                                  <input readonly type="text" class="form-control" name="cid" id="cid" value="{{$training->cid}}">
                                </div>
                                <div class="form-group col">
                                  <label for="name">Full name</label>
                                  <input readonly type="text" class="form-control" id="name" name="name" value="{{$training->name}}">
                                </div>
                              </div>
                                <div class="row">
                                  <div class="form-group col">
                                      <label >Type of session</label><br>
                                      <input readonly type="text" class="form-control" id="name" name="type" value="{{$training->type}}">
                                  </div>
                                  <div class="col">
                                    <div class="form-group">
                                        <label>Date:</label>
                                        <input readonly class="date form-control" name="date" type="text" value="{{$training->date}}">
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Start time:</label>
                                            <input class="timepicker form-control" id="timepicker" name="start" type="text" value="{{$training->start_time}}">
                                          </div>
                                      </div>
                                    <div class="col">
                                      <div class="form-group">
                                          <label>End time:</label>
                                          <input class="timepicker form-control" id="timepicker2" name="end" type="text" value="{{$training->end_time}}">
                                        </div>
                                    </div>
                                  </div>
                                    <div>
                                      <div class="form-group">
                                          <label>Position:</label>
                                          <input readonly class="form-control" id="" name="position" type="text" value="{{$training->position}}">
                                        </div>
                                    </div>
                                  
                                  
                              <!-- /.card-body -->
                              <input type="submit" class="btn" style="background-color: #2c0289; color: white;">
                              </form>
            </div>

    </section>
</div>

<script>
  $('#timepicker').timepicker({
      uiLibrary: 'bootstrap4',
  });
  $('#timepicker2').timepicker({
      uiLibrary: 'bootstrap4',
  });
</script>
@endsection