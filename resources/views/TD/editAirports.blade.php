@extends('layouts.app')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit airports of controller</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">AirportsA</li>
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
                        <form name="roleUpdate" action="{{route('update_ATC_airports')}}">
                            @csrf
                        <div class="row">
                            <div class="col">
                                <h3>Info about controller you are currently editing</h3>

                                <strong>Members name: </strong>{{$user->name}}<br>
                                <strong>Members surname: </strong>{{$user->last_name}}<br>
                                <strong>Members CID: </strong>{{$user->cid}}<br>
                            </div>
                          
                                <input type="text" name="id" value="{{$user->id}}" hidden> 
                
                      <div class="col">
                                   
                                <h3>Ground positions</h3>
                                <input type="checkbox" onClick="toggleGnd(this)" /> Select all<br/>
                                @foreach($gnd as $ground)
                                <div class="form-check">
                                    <input class="form-check-input" name="gnd[]" type="checkbox" value="{{$ground}}" {{ in_array($ground, explode(', ', $user->gnd)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{$ground}}_GND
                                    </label>
                                </div>
                                @endforeach
                            </div> 
                            <div class="col">
                                @csrf
                            <h3>Tower positions</h3>
                            <input type="checkbox" onClick="toggleTwr(this)" /> Select all<br/>
                            @foreach($twr as $tower)
                            <div class="form-check">
                                <input class="form-check-input" name="twr[]" type="checkbox" value="{{$tower}}" {{ in_array($tower, explode(', ', $user->twr)) ? 'checked' : ''}} id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{$tower}}_TWR
                                </label>
                            </div>
                            @endforeach
                                
                            

                        </div>
                        <div class="col">
                            @csrf
                        <h3>Approach positions</h3>
                        <input type="checkbox" onClick="toggleApp(this)" /> Select all<br/>
                        @foreach($app as $approach)
                        <div class="form-check">
                            <input class="form-check-input" name="app[]" type="checkbox" value="{{$approach}}" {{ in_array($approach, explode(', ', $user->app)) ? 'checked' : ''}} id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{$approach}}_APP
                            </label>
                        </div>
                        @endforeach

                    </div><div class="col">
                        @csrf
                    <h3>CTR positions</h3>
                    <input type="checkbox" onClick="toggleCtr(this)" /> Select all<br/>
                    @foreach($ctr as $center)
                    <div class="form-check">
                        <input class="form-check-input" name="ctr[]" type="checkbox" value="{{$center}}" {{ in_array($center, explode(', ', $user->ctr)) ? 'checked' : ''}} id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{$center}}_CTR
                        </label>
                    </div>
                    @endforeach

                </div>
                    </div>
                            <input type="submit" class="float-right btn">
                        </form>
                            <!-- /.card -->
                        
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
    function toggleGnd(source) {
  checkboxes = document.getElementsByName('gnd[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
function toggleTwr(source) {
  checkboxes = document.getElementsByName('twr[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
function toggleApp(source) {
  checkboxes = document.getElementsByName('app[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
function toggleCtr(source) {
  checkboxes = document.getElementsByName('ctr[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
@endsection
