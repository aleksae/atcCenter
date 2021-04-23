<form>
    <table class="table table-responsive">
        <thead>
            <tr>
               
            </tr>
        </thead>
        <tbody>
        
            <tr>
                <td>
                    <strong>Events department publishes rosters on time</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1a">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>Events department communicates with members on a regular bases</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1b">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>Events department notifies members about events on time</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1c">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>Events department publishes rosters on time</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1d">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>Events department does not favor members in rosters</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1e">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>I am satisfied with the work of Events department</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1f">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            </tbody>
   </table>
   <div class="form-group">
    <label for="exampleFormControlTextarea1">Additional comments</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" cols="50"></textarea>
  </div>
</form>