@extends('layouts.app')
@section('content')
@section('title','Training logs')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Training logs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Training log</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                @if(session('count'))
                <div class="alert alert-danger">
                {{session('count')}}
                </div>
                @endif
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Enter training log</h3>


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div>
                        <form action="{{route('store.log')}}" method="POST">
                            @csrf
                            @if($errors->first('notes'))
                            <div class="alert alert-danger">{{ $errors->first('notes') }}</div>@endif
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control" rows="5" placeholder="Your notes" id="notes" name="notes" required >{{ old('letter') }}</textarea>
                          </div>
                    </div>
                    <h4>Sheet</h4>
                    @if($errors->first('item[]'))
                    <div class="alert alert-danger">{{ $errors->first('item[]') }}</div>@endif
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                            </thead>
                            <tbody> 
                            
                                <input hidden type="text" name="id" value="{{$id}}">
                           
                        @foreach($items as $item)
                        
                        <tr>
                              <td><strong>{{$item->id}}. {{$item->item}} <span name="score[]" id="stara">[{{$sheet[$item->id-1]}}]</span></strong></td>
                              <td><input type="number" name="item[]" value={{old('item[]')}}  id="item[]" class="form-control" placeholder="0-100%" style="margin-left: 5px;" min='-100' max="100">
                        </tr>

                          @endforeach
                    
                        </table>
                        
                    <!-- /.col (right) -->
                    </div>
                    <input type="submit" class="btn">
                </form>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
            </div></section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->
      
@endsection
