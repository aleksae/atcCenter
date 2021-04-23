@extends('layouts.app')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Advanced Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Training applications</li>
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
                        <h3 class="card-title">Application processing</h3>

                       
                    </div>
                    <!-- /.card-header -->
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

                            <!-- TABELA -->
                            
                        <table class="table table-bordered table-striped " >
                                <thead>
                                    <tr>
                                        <th colspan="5" style="text-align: center;">Ongoing applications</th>
                                    </tr>
                                <tr>
                                    <th scope="col">Full name</th>
                                    <th scope="col">CID</th>
                                    <th scope="col">Last change</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=0;
                                    @endphp
                                @foreach($prijave as $prijava)
                                @if($prijava->status!="Accepted"&&$prijava->status!="Denied")
                                <tr>

                                        <td>{{$prijava->full_name}}</td>
                                        <td>{{$prijava->cid}}</td>
                                        <td>{{ \Carbon\Carbon::parse($prijava->updated_at)->format('d.m.Y. - H:i:s')}}</td>
                                        <td>{{$prijava->status}}</td>
                                        <td><a class="button-warning" href="review_application/{{$prijava->id}}/{{$prijava->cid}}">Review</a></td>
                                </tr>
                                @php
                                   $i++;
                                @endphp
                                @endif
                                @endforeach
                                @if($i==0)
                                <tr>
                                    <td colspan="5" style="text-align: center;">No applications</td>
                                </tr>
                                @endif
                                </tbody>
                                
                            </table> 

                            {{ $prijave->links() }} 
                           

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
