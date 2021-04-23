@extends('layouts.app')
@section('content')
@section('title','My trainings')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My sessions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">My sessions</li>
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
                    <div class="card-header">
                        <h3 class="card-title">Your mentor sessions</h3>


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="row">

                            <!-- TABELA -->
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Trainee</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Date and time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requests as $training)
                                @php
                                            $date = explode('/', $training->date);
                                            $date = $date[0].".".$date[1].".".$date[2];
                                            $d1= $date." ".$training->end_time;
                                            $d1 = new DateTime($d1);
                                            $d2 = new DateTime(Carbon\Carbon::now());
                                            $interval = date_diff($d1, $d2);
                                            @endphp
                                @if(!$training->sheet || $interval->format('%S')<0)
                                <tr>

                                        <td><a href="trainee_profile/{{$training->cid}}">{{$training->name}}</a> [{{$training->cid}}]</td>
                                        <td>{{$training->position}}</td>
                                        <td>{{$training->type}}</td>
                                        <td>{{$training->date}} [{{$training->start_time}}-{{$training->end_time}}]</td>
                                        <td> @if($training->status=="Fail")
                                            <span class="badge badge-danger">{{$training->status}}<span>
                                            @elseif($training->status=="Taken")
                                            <span class="badge badge-success">{{$training->status}}<span>
                                            @else
                                            <span class="badge badge-warning">{{$training->status}}<span>
                                            @endif</td>
                                        <td>
                                            <div style="display: flex;
                                            ">
                                            @if(($d1<$d2)&&(!$training->sheet))  
                                            <a href="add_log/{{$training->id}}/{{$training->cid}}" class="text-info" style="color: #2c0289">Add log</a>
                                            @elseif(!$training->sheet)
                                            <a href="cancel_session/{{$training->id}}/{{$training->start_old}}/{{$training->end_old}}" class="text-danger" style="color: #2c0289" >Cancel training</a>
                                            @endif
                                            
                                        </div></td></tr>@endif
                                @endforeach
                                </tbody>
                            </table>
                            
  
                              
                              <!-- Modal -->
                            
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

@endsection
