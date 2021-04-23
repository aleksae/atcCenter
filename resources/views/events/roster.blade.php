<html>
<head>
    <title>Event roster</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <div class="card">
                    <div class="card-header bg-info">
                        <h6 class="text-white">Event roster managment</h6>
                    </div>
                    @php $list=[];
                    $gnd=0;
                    $twr=0;
                    $app=0;
                    $ctr=0;@endphp
                    <div class="card-body">
                        <form method="post" action="{{route('roster.store', $event->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Event</label>
                                <input readonly type="text" name="name" class="form-control" value="{{$event->name}} | {{(new DateTime($event->date))->format('d.m.Y.')}} | {{$event->start}}-{{$event->end}}"/>
                            </div>  
                            <div class="form-group">
                                <label>Roster notes</label>
                                <textarea name="notes" class="form-control"></textarea>
                            </div>  
                            <div class="form-group">
                                <label><strong>All reports:</strong></label>
                                <div class="table-resposnive">
                                    <table class="table table-bordere table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>CID</th>
                                                <th>Status</th>
                                                <th>Start</th>
                                                <th>End</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(json_decode($event->reports, true) as $report)
                                            <tr>
                                                <td>{{$report['full_name']}}</td>
                                                <td>{{$report['cid']}}</td>
                                                <td>{{$report['status']}}</td>
                                                <td>{{$report['start']}}</td>
                                                <td>{{$report['end']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            @foreach(explode(', ', $event->positions) as $airp)
                            @foreach($airports as $airport)
                            @if($airport->station == $airp )
                            @if($airport->GND==1)
                            @php array_push($list, $airport->station."_GND");  @endphp
                            <div class="">
                                @php $ratings="OBS, S1, S2, S3, C1, C3, I1, I3";@endphp
                                <input type="text" name="position_gnd{{$gnd}}" value="{{$airport->station}}_GND">
                                <label name="position_gnd{{$gnd}}"><strong>{{$airport->station}}_GND</strong></label><br/>
                                <select class="selectpicker" multiple data-live-search="true" name="gnd{{$gnd}}[]">
                                    @php $gnd++; @endphp
                                    @foreach(json_decode($event->reports, true) as $report)
                                    @if(in_array($report['rating'],explode(', ', $ratings)) && $report['status']=="Available")
                                    <option value="{{$report['cid']}}">{{$report['full_name']}} [{{$report['start']}}-{{$report['end']}}] </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @if($airport->TWR==1)
                            @php array_push($list, $airport->station."_TWR"); @endphp
                            <div class="">
                                @php $ratings="S1, S2, S3, C1, C3, I1, I3";@endphp
                                <input type="text" name="position_twr{{$twr}}" value="{{$airport->station}}_TWR">
                                <label name="position_twr{{$twr}}"><strong>{{$airport->station}}_TWR</strong></label><br/>
                                <select class="selectpicker" multiple data-live-search="true" name="twr{{$twr}}[]">
                                    @php $twr++; @endphp
                                    @foreach(json_decode($event->reports, true) as $report)
                                    @if(in_array($report['rating'],explode(', ', $ratings)) && $report['status']=="Available")
                                    <option value="{{$report['cid']}}">{{$report['full_name']}} [{{$report['start']}}-{{$report['end']}}] </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @if($airport->APP==1)
                            @php array_push($list, $airport->station."_APP"); @endphp
                            <div class="">
                                @php $ratings="S2, S3, C1, C3, I1, I3";@endphp
                                <input type="text" name="position_app{{$app}}" value="{{$airport->station}}_APP">
                                <label name="position_app{{$app}}"><strong>{{$airport->station}}_APP</strong></label><br/>
                                <select class="selectpicker" multiple data-live-search="true" name="app{{$app}}[]">
                                    @php $app++; @endphp
                                    @foreach(json_decode($event->reports, true) as $report)
                                    @if(in_array($report['rating'],explode(', ', $ratings)) && $report['status']=="Available")
                                    <option value="{{$report['cid']}}">{{$report['full_name']}} [{{$report['start']}}-{{$report['end']}}] </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            @endif
                        
                            @elseif(substr($airport->station, 0, 2)==(substr($airp, 0, 2)))
                            @if($airport->CTR==1)
                            @php array_push($list, $airport->station."_CTR"); @endphp
                            <div class="">
                                @php $ratings="S3, C1, C3, I1, I3";@endphp
                                <input type="text" name="position_ctr{{$ctr}}" value="{{$airport->station}}_CTR">
                                <label><strong>{{$airport->station}}_CTR</strong></label><br/>
                                <select class="selectpicker" multiple data-live-search="true" name="ctr{{$ctr}}[]">
                                    @php $ctr++; @endphp
                                    @foreach(json_decode($event->reports, true) as $report)
                                    @if(in_array($report['rating'],explode(', ', $ratings)) && $report['status']=="Available")
                                    <option value="{{$report['cid']}}">{{$report['full_name']}} [{{$report['start']}}-{{$report['end']}}] </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @endif
                            @endforeach
                            @endforeach
                            <div class="">
                                @php $ratings="S3, C1, C3, I1, I3";@endphp
                                <input type="text" name="position_ctr{{$ctr}}" value="ADR_CTR">
                                <label ><strong>ADR_CTR</strong></label><br/>
                                <select class="selectpicker" multiple data-live-search="true" name="ctr{{$ctr}}[]">
                                    @php $ctr++; @endphp
                                    @foreach(json_decode($event->reports, true) as $report)
                                    @if(in_array($report['rating'],explode(', ', $ratings)) && $report['status']=="Available")
                                    <option value="{{$report['cid']}}">{{$report['full_name']}} [{{$report['start']}}-{{$report['end']}}] </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" name="gnd" value="{{$gnd}}">
                            <input type="text" name="twr" value="{{$twr}}">
                            <input type="text" name="app" value="{{$app}}">
                            <input type="text" name="ctr" value="{{$ctr}}">
                            <div class="text-center" style="margin-top: 10px;">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</body>
  
<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        $('select').selectpicker();
    });
</script>
  
</html>