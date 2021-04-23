@extends('layouts.app')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Request a training</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Training session request</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          @if (session('message'))
          <div class="alert alert-success">
              {{ session('message') }}
          </div>
      @endif
            <div class="container-fluid row">
                
                <div class="card card-outline card-secondary">
                    
                </div>
                    
           </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->

@endsection
