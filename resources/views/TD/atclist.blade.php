@extends('layouts.app')
@section('content')
@section('title', 'ATC list')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Controller</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Controllers</li>
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
                        <h3 class="card-title">List of ATCs</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

                        </div>
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Surname</th>
                                    <th scope="col">CID</th>
                                    <th scope="col">Airports</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>

                                        <td>{{$user->name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>{{$user->cid}}</td>
                                        <td>
                                        @php
                                           $gnd=explode(', ', $user->gnd);
                                           foreach($gnd as $position){
                                               $position=$position."_GND";
                                           }
                                           $twr=explode(', ', $user->twr);
                                           foreach($gnd as $position){
                                               $position=$position."_TWR";
                                           }
                                           $app=explode(', ', $user->app);
                                           foreach($gnd as $position){
                                               $position=$position."_APP";
                                           }
                                           $ctr=explode(', ', $user->ctr);
                                           foreach($gnd as $position){
                                               $position=$position."_CTR";
                                           }
                                        @endphp
                                        
                                        GND: @foreach($gnd as $airport) <span class="badge badge-info">{{$airport}}</span> @endforeach<hr>
                                        TWR: @foreach($twr as $airport) <span class="badge badge-info">{{$airport}}</span> @endforeach<hr>
                                        APP: @foreach($app as $airport) <span class="badge badge-info">{{$airport}}</span> @endforeach<hr>
                                        CTR: @foreach($ctr as $airport) <span class="badge badge-info">{{$airport}}</span> @endforeach
                                        </td>
                                        <td><a class="button-warning" href="/edit_airports/{{$user->id}}">Edit</a></td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
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
