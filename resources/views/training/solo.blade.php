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
                    <h1>Issue solo validation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Solo validation</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            

                <form action="{{route('store.solo.request')}}" method="POST" style="width: 100%;">
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
                              <h3 class="card-title">Issue solo validation</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                              <div class="card-body">
                                <div class="row">
                                <div class="form-group col">
                                  <label for="cid">CID</label>
                                  <input readonly type="text" class="form-control" name="cid" id="cid" value="{{$trainee->cid}}">
                                </div>
                                <div class="form-group col">
                                  <label for="name">Full name</label>
                                  <input readonly type="text" class="form-control" id="name" name="name" value="{{$trainee->full_name}}">
                                </div>
                              </div>
                                <div class="row">
                                  <div class="form-group col">
                                      <label >Type of training</label><br>
                                      <input readonly type="text" class="form-control" id="name" name="type" value="{{$trainee->type}}">
                                  </div>
                                 
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Date start[m/d/Y]</label>
                                            <input class="date form-control" name="date_start" type="text" id="datepicker" value="{{old('date_start')}}">
                                          </div>
                                      </div>
                                      <div class="col">
                                        <div class="form-group">
                                            <label>Date end[m/d/Y]</label>
                                            <input class="date form-control" name="date_end" type="text" id="datepicker2" value="{{old('date_end')}}">
                                          </div>
                                      </div>
                                  </div>
                                    <div>
                                      <div class="form-group">
                                          <label>Position:</label>
                                          @php $airports=explode(', ',$trainee->airports); 
                                          $type=0;
                                          if($trainee->type=='S2'){
                                            $type='TWR';
                                          }elseif($trainee->type=='S3'){
                                              $type="APP";
                                          }else{
                                              $type="CTR";
                                          }
                                          @endphp
                                          <select class="form-control" aria-label="Default select example" id="position" name="position">
                                            @foreach ($airports as $airport)
                                            <option value="{{$airport}}_{{$type}}" >{{$airport}}_{{$type}}</option>
                                            @endforeach
    
                                        </select>  
                                        </div>
                                    </div>
                                  
                                  
                              <!-- /.card-body -->
                              <input type="submit" class="btn" style="background-color: #2c0289; color: white;">
                              </form>
            </div>

    </section>
</div>

<script>
    today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
   $('#datepicker').datepicker({
       uiLibrary: 'bootstrap4',
       minDate: today
   });
   
</script>
<script>
   today = new Date(new Date().getFullYear(), new Date().getMonth()+1, new Date().getDate());

    $('#datepicker2').datepicker({
       uiLibrary: 'bootstrap4',
       minDate: today,
   });
    </script>
<script>
  $('#timepicker').timepicker({
      uiLibrary: 'bootstrap4',
  });
  $('#timepicker2').timepicker({
      uiLibrary: 'bootstrap4',
  });
</script>
@endsection