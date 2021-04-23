@extends('layouts.app')
@section('content')
@section('title',"Mentor's scores and reviews")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mentor's scores and reviews</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Scores and reviews</li>
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
                        <h3 class="card-title">Mentor's scores and reviews</h3>


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Mentor</th>
                                        <th>Average score</th>
                                        <th>Number of sessions</th>
                                    </tr>
                                </thead>
                                <tbody>
                       @foreach($mentors as $mentor)
                                <tr>
                                    <td>{{$mentor['name']}}  [{{$mentor['cid']}}]</td>
                                    <td>{{$mentor['rates']}} / 5</td>
                                    <td>{{$mentor['sessions']}}</td>
                                </tr>
                        
                       
                        @endforeach 
                                </tbody>
                            </table>
                        </div>
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
