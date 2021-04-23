@extends('layouts.app')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit trainees allowed airports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Trainee - Airports</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">

                    <!-- /.card-header -->
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col">
                                <h3>Info about member you are currently editing</h3>
                                
                                <strong>Members name: </strong>{{$trainee->full_name}}<br>
                                <strong>Members CID: </strong>{{$trainee->cid}}<br>
                                <strong>Training for: </strong>{{$trainee->type}}<br>
                            </div>
                            <div class="col">
                                @php
                                  $rating_type="";
                                    if($trainee->type=="S2"){
                                        $rating_type="TWR";
                                    }elseif($trainee->type=="S3"){
                                        $rating_type="APP";
                                    }else{
                                        $rating_type="CTR";
                                    } 
                                @endphp
                                <form name="roleUpdate" action="{{route('update_airports')}}">

                                    @csrf
                                <h3>Select airports</h3><input type="text" name="cid" value="{{$trainee->cid}}" hidden>
                                <input type="checkbox" onClick="toggle(this)" /> Select all<br/>
                                    @foreach($airports as $airport)
                                    @if($airport->$rating_type==1)
                                    @if($airport->station!="LYTV")
                                <div class="form-check">
                                    <input class="form-check-input" name="positions[]" type="checkbox" value="{{$airport->station}}" {{ in_array($airport->station, explode(', ',$trainee->airports)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                       {{$airport->station}}_{{$rating_type}}
                                    </label>
                                </div>
                                @elseif($rating_type=="APP"){
                                    <div class="form-check">
                                        <input class="form-check-input" name="positions[]" type="checkbox" value="{{$airport->station}}" {{ in_array($airport->station, explode(', ',$trainee->airports)) ? 'checked' : ''}} id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                           {{$airport->station}}_TWR
                                        </label>
                                    </div>
                                }
                                @endif
                                @endif
                                @endforeach
                                    <input type="submit" class="btn">
                                </form>

                            </div>

                            <!-- /.card -->
                        </div>
                        <!-- /.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div></section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->

<script>
    function toggle(source) {
  checkboxes = document.getElementsByName('positions[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
@endsection