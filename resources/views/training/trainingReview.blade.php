@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>

    </style>

<div class="content-wrapper" >

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Review you progress</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Progress</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="card card-default">
            <div class="card-header card-blue">
                <h3 class="card-title text-white">Score</h3>
        
        
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php
             ?>
            <strong>Overall</strong> [{{round($sum,2)}}% completed]<div class="progress">
          <div class="progress-bar  @if(round($sum,2)<=30.00)
          bg-danger
          @elseif(round($sum,2)>30.00 && round($sum,2)<90.00)
                bg-warning
                @else
                bg-success
                @endif" role="progressbar" aria-valuenow="70"
          aria-valuemin="0" aria-valuemax="100" style="width:{{$sum}}%">
         
          </div>
        </div>
        <hr>
            <?php for($i=0;$i<27;$i++){
              ?><strong>{{$items[$i]->item}}</strong> [{{$sheet[$i]}}% completed]<div class="progress">
          <div class="progress-bar 
          @if($sheet[$i]<=30)
          bg-danger
          @elseif($sheet[$i]>30 && $sheet[$i]<90)
                bg-warning
                @else
                bg-success
                @endif
          
          " role="progressbar" id="progress{{$i}}"aria-valuenow="70"
          aria-valuemin="0" aria-valuemax="100" style="width:{{$sheet[$i]}}%;">
         
          </div>
        </div><?php
            }
             ?>
         
        </div>
    </section>
</div>



@endsection
