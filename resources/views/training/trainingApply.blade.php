@extends('layouts.app')
@section('content')

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Apply for a training</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Apply for training</li>
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

                <!-- SELECT2 EXAMPLE -->


                    <!-- /.card-header -->
                    <div class="card-body col">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <?php
                        try{
                         
                            $dateApplication = date_create($proveraPrijave->created_at);
                            $dateToday = date_create(date('d-m-Y'));
                            $dateCheck=(date_diff($dateApplication, $dateToday))->format('%a');
                        }catch(Exception $e){
                          $dateCheck=31;
                        }?>
                        @if($dateCheck<=30 && $proveraPrijave->status=="Denied")
                      <span class="badge badge-warning"> You can't apply for training. You need to wait 30 days from the last rejection to apply again.
                       You'll be eligable for another application in {{(30-$dateCheck)}} {{(30-$dateCheck)>1 ? 'days':'day'}}.</span>
                        @endif
                        @if(/* (auth()->user()->division_code=="IL" || auth()->user()->division_code=="PAC")  && */ !in_array('Trainee',explode(", ",(auth()->user()->roles))) && intval($dateCheck)>30 )
                        <form action="/send_application" method="POST">
                            @csrf
                            <div class="row">
                                <!-- left column -->
                                <div class="col-md-6">
                                  <!-- general form elements -->
                                  <div class="card card-primary">
                                    <div class="card-header card-blue">
                                      <h3 class="card-title">Training application</h3>

                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form role="form" method="POST" action="{{route('sendApplication')}}">
                                      <div class="card-body">
                                        <div class="row">
                                        <div class="form-group col">
                                          <label for="cid">CID</label>
                                          <input readonly type="text" class="form-control" name="cid" id="cid" value="{{auth()->user()->cid}}">
                                          <div class="badge badge-danger">{{ $errors->first('cid') }}</div>
                                        </div>
                                        <div class="form-group col">
                                          <label for="name">Full name</label>
                                          <input readonly type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}} {{auth()->user()->last_name}}">
                                          <div class="badge badge-danger">{{ $errors->first('name') }}</div>
                                        </div>
                                      </div>
                                        <div class="row">
                                          <div class="form-group col">
                                              <label >Type of training</label><br>
                                              <select class="form-control" aria-label="Default select example" id="type" name="type">
                                                  @if((auth()->user()->rating=="S1") || (auth()->user()->rating=="OBS"))
                                                  <option value="S2">Tower - S2 (S1 included)</option>
                                                  @elseif(auth()->user()->rating=="S2")
                                                  <option value="S3">Approach - S3</option>
                                                  @elseif(auth()->user()->rating=="S3")
                                                  <option value="C1">Center - C1</option>
                                                  @elseif(auth()->user()->rating=="C1" || auth()->user()->rating=="C3")
                                                  <option value="I1">Intructor - I1</option>
                                                      @endif
                                              </select>
                                              <div class="badge badge-danger">{{ $errors->first('type') }}</div>
                                          </div>
                                          <div class="form-group col">
                                              <label >Desired FIR</label><br>
                                              <select class="form-control" aria-label="Default select example" id="fir" name="fir">
                                                  <option value="LJLA" {{ (old('fir')=="LJLA") ? 'selected' : ''}}>Ljubljana [LJLA]</option>
                                                  <option value="LDZO" {{ (old('fir')=="LDZO") ? 'selected' : ''}}>Zagreb [LDZO]</option>
                                                  <option value="LYBA" {{ (old('fir')=="LYBA") ? 'selected' : ''}}>Belgrade [LYBA]</option>
                                                  <option value="LQSB" {{ (old('fir')=="LQSB") ? 'selected' : ''}}>Sarajevo [LQSB]</option>
                                                  <option value="LWSS" {{ (old('fir')=="LWSS") ? 'selected' : ''}}>Skopje [LWSS]</option>
                                                  <option value="LAAA" {{ (old('fir')=="LAAA") ? 'selected' : ''}}>Tirana [LAAA]</option>
                                                  <option value="KFOR" {{ (old('fir')=="KFOR") ? 'selected' : ''}}>Kosovo [KFOR]</option>

                                              </select>
                                              <div class="badge badge-danger">{{ $errors->first('fir') }}</div>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Motivational letter (minimum 75 characters)</label>
                                            <textarea class="form-control" rows="5" placeholder="Your motivational letter" id="letter" name="letter" minlength="75" required >{{ old('letter') }}</textarea>
                                            <div class="badge badge-danger">{{ $errors->first('letter') }}</div>
                                          </div>




                                      <!-- /.card-body -->


                                        <button type="submit" class="btn" >Submit</button>
                                      </div>
                                    </form>
                                    
                                  </div>
                                </div>
                                <div class="col">
                                  <div class="card card-primary card-tabs">
                                    <div class="card-header p-0 pt-1 " style="background-color: #2c0289;">
                                      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                          <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Home</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Airports<span class="text-danger">*</span></a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Requirements</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Help</a>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="card-body">
                                      <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                           VATSIM Adria's Training Department offers proffesional training to anyone wishing to know how does it feel to be an Air Traffic Controller. We have a devoted team ready to guide you through all neccessary steps in order to start controlling.
                                           <span class="text-danger">Check if you meet the requirements. If you are denied, there is a 30-day period before you can re-apply.</span>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                          <ul class="list-group">
                                            <li class="list-group-item"><strong>LJLA</strong>: LJLJ, LJPZ, LJMB</li>
                                            <li class="list-group-item"><strong>LDZO</strong>: LDZA, LDOS, LDRI, LDPL, LDLO, LDZD, LDSP, LDSB, LDDU</li>
                                            <li class="list-group-item"><strong>LQSB</strong>: LQBK, LQTZ, LQSA, LQMO</li>
                                            <li class="list-group-item"><strong>LYBA</strong>: LYBE, LYKV, LYNI, LYUZ, LYPG, LYTV</li>
                                            <li class="list-group-item"><strong>LAAA</strong>: LATI</li>
                                            <li class="list-group-item"><strong>LWSS</strong>: LWSK, LWOH</li>
                                            <li class="list-group-item"><strong>KFOR</strong>: BKPR</li>
                                            <li class="list-group-item"><strong>CTR</strong>: ADR, LJLA, LDZO, LQSB, LYBA, LAAA, LWSS</li>
                                            <div><span class="text-danger">*</span>You might not get a training in your desired FIR/airport due to vACCs policy. Regardless, you will be offerd other option(s), but you can opt to wait.</div>

                                          </ul>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                           @if(auth()->user()->rating=="S1")
                                           <ul class="list-group list-group-flush">
                                           <li class="list-group-item">At least 15 hours on VATSIM Adria ATC positions in three months before a place is offered</li>
                                           <li class="list-group-item">At Least 75 hours in total on VATSIM Adria TWR positions.</li>
                                           </ul>
                                           @elseif(auth()->user()->rating=="OBS")
                                           If you are able to see this message, then you fulfill all the requirements. Feel free to apply <span style=''>&#128513;</span>.
                                           @elseif(auth()->user()->rating=="S2")
                                           <ul class="list-group list-group-flush">
                                            <li class="list-group-item">At least 50 hours on VATSIM Adria ATC positions in the three months before a place is offered</li>
                                            <li class="list-group-item">At least 200 hours on APP positions in the sector on which you wish to train: <br>o	ADR_W - LDZA, LJLJ, LJMB, LDDU, LDSP, LQSB, LQTZ, LQBK
                                             <br> o	ADR_E  - LYBE, LWSK, LYPG, LATI, LWOH & LYTV (full procedural control)
                                              </li>
                                            </ul>
                                            @elseif(auth()->user()->rating=="S3" || auth()->user()->rating=="C1" || auth()->user()->rating=="C3" || auth()->user()->rating=="I1")
                                           Refere to Training Policy or contact training department for details.
                                           @endif
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                           If you have any issues, feel free to contact staff members at our <a href="">Discord</a>.
                                        </div>
                                      </div>
                                    </div>
                                    <!-- /.card -->
                                  </div>
                                </div>
                            </div>

                        </form>
                        @else
                        @if($prijave->isEmpty())
                            <p>You are not a member of VATSIM Adria, so you cannot apply for regular training. You can change your division on offical VATSIM website or you can apply as
                                Visiting controllor <a href="">here</a>.
                            </p>
                        @endif
                        @endif
                        <!-- /.col (right) -->

                </div>
                @if(!$prijave->isEmpty())
                    <!-- /.row -->
                    <div class="col ml-2">
                        <div class="card">
                            <div class="card-header">
                              <h3 class="card-title">My training apllications</h3>
                              <div class="card-tools">
                                <!-- Buttons, labels, and many other things can be placed here! -->
                                <!-- Here is a label for example -->
                                <span class="badge badge-info">TD</span>
                              </div>
                              <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>

                                            <th scope="col">Type</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Reviewee</th>
                                            <th scope="col">Notes</th>

                                            <th scope="col">Submited</th>
                                            <th scope="col">Last update</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($prijave as $prijava)
                                        <tr>
                                            <td>{{$prijava->type}}</td>
                                            @if($prijava->status=='Accepted')
                                            <td><span class="badge badge-success">{{$prijava->status}}</span></td>
                                            @elseif($prijava->status=='Denied')
                                            <td><span class="badge badge-danger">{{$prijava->status}}</span></td>
                                            @else
                                            <td><span class="badge badge-warning">{{$prijava->status}}</span></td>
                                            @endif
                                            <td>{{$prijava->reviewee}}</td>
                                            <td>{{$prijava->notes}}</td>
                                            <td>{{ \Carbon\Carbon::parse($prijava->created_at)->format('d.m.Y. - H:i:s')}}</td>
                                            <td>{{ \Carbon\Carbon::parse($prijava->updated_at)->format('d.m.Y. - H:i:s')}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <!-- /.card-footer -->
                          </div>
                          <!-- /.card -->

                    </div>
                    @endif
                </div><!-- /.container-fluid -->
           </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->

@endsection
