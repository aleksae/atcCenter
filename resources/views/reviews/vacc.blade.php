<form>
    <table class="table table-responsive">
        <thead>
            <tr>
               
            </tr>
        </thead>
        <tbody>
        
            <tr>
                <td>
                    <strong>vACC keep memeber informed about important news on regular basis</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1a">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>vACC communicates with members on a regular bases</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1b">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>vACC Staff is polite and helpful in communication with members</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1c">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            {{-- <tr>
                <td>
                    <strong>vACC Staff </strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1d">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>TD does not favor members in providing trainings and scheduling exams</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1e">{{$i}}</label>
                        @endfor
                </td>
                
            </tr>
            <tr>
                <td>
                    <strong>I am satisfied with the work of TD</strong>
                    </td>
                <td>
                        @for($i=1;$i<6;$i++)
                        <label><input type="radio" id='regular' name="radio1f">{{$i}}</label>
                        @endfor
                </td>
                
            </tr> --}}
            </tbody>
   </table>
   <div class="form-group">
    <label for="exampleFormControlTextarea1">Additional comments</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" cols="50"></textarea>
  </div>
</form>