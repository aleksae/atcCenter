@extends('layouts.app')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit member's roles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Members/roles</li>
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
                                @foreach($users as $user)
                                <strong>Members name: </strong>{{$user->name}}<br>
                                <strong>Members surname: </strong>{{$user->last_name}}<br>
                                <strong>Members CID: </strong>{{$user->cid}}<br>
                                <strong>Current roles: </strong>{{$user->roles}}<br>
                            </div>
                            <div class="col">
                                <form name="roleUpdate" action="/update_roles/{{$user->cid}}">

                                    @csrf
                                <h3>Info about member you are currently editing </h3><input type="text" name="cid" value="{{$user->cid}}" hidden>
                                    <div class="form-check">
                                    <input class="form-check-input" name="roles[]" type="checkbox" value="member" {{ in_array("member", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        member
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="roles[]" type="checkbox" value="ATC" {{ in_array("ATC", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        ATC
                                    </label>
                                </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="roles[]" type="checkbox" value="Visiting ATC" {{ in_array("Visiting ATC", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Visiting ATC
                                        </label>
                                    </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="roles[]" type="checkbox" value="Mentor" {{ in_array("Mentor", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Mentor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="roles[]" type="checkbox" value="Examiner" {{ in_array("Examiner", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Examiner
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="roles[]" type="checkbox" value="Trainee" {{ in_array("Trainee", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Trainee
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="roles[]" type="checkbox" value="TD" {{ in_array("TD", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        TD
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="roles[]" type="checkbox" value="Events" {{ in_array("Events", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Events
                                    </label>
                                </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="roles[]" type="checkbox" value="Admin" {{ in_array("Admin", explode(', ',$user->roles)) ? 'checked' : ''}} id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Admin
                                        </label>
                                    </div>
                                    <input type="submit">
                                </form>

                            </div>

                            @endforeach
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
