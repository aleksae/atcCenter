@extends('layouts.app')
@section('content')
@section('title','Trainees List')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Manage trainees</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Manage trainees</li>
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
                        <h3 class="card-title">Manage trainees</h3>


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
                                    <th scope="col">Full name</th>
                                    <th scope="col">CID</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Airports</th>
                                    <th scope="col">Solo</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($trainees as $trainee)
                                @if($trainee->isActive)
                                <tr>

                                        <td>{{$trainee->full_name}}</td>
                                        <td>{{$trainee->cid}}</td>
                                        <td>On training for {{$trainee->type}}</td>
                                        <td>{{$trainee->airports}}</td>
                                        <td>@if($trainee->hasSolo) <span class="badge badge-success mr-1">Active</span>
                                           <strong> {{$trainee->soloPosition}}</strong>  </span> @else <span class="badge badge-warning">Not active @endif</td>
                                        <td>
                                            <div style="display: flex;
                                            justify-content: space-between;">
                                            <a href="/manage_airports/{{$trainee->cid}}"  data-toggle="tooltip" data-placement="top" title="Manage airports"><i class="fas fa-plane-departure text-warning"></i></a>
                                            <a href="/trainee_profile/{{$trainee->cid}}" data-toggle="tooltip" data-placement="top" title="Manage trainee's profile"><i class="fas fa-graduation-cap text-warning"></i></a>
                                            <a href="/issue_solo/{{$trainee->cid}}"  data-toggle="tooltip" data-placement="top" title="Solo validation"><i class="fas fa-headphones-alt text-warning"></i></a>
                                        </div></td>
                               
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                            {{$trainees->links()}}


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
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    </script>
@endsection
