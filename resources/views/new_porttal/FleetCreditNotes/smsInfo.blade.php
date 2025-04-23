<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>

  </style>
</head>
<body>
    <h6>Claim #<span style='color:#007dff'>{{$extra_data['claim_rererance']}} </span>, DA (<span style="color:red">{{$extra_data['fullname']}}</span>)</h6>
    <p>Bellow a list of the pushed sms messages that been sent or under proccess, you can resent the faild attempts.</p>
    <br>
    <br>
  <table class="table">
  <thead>
    <tr style='background-color: #577984; color: #fffdfd; font-weight: bold;'>
      <th scope="col">#</th>
      <!--<th scope="col">Payment date</th>-->
      <th scope="col">Mobile</th>
      <th scope="col">Messages</th>
      <th scope="col">Status</th>
      <th scope="col">Attempts</th>
      <th scope="col">First attempt</th>
      <th scope="col">Last attempt at</th>
      <th scope="col">Provider</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
     @foreach($sms_push_attempts as $count=>$sms_push_attempt)
        <tr>
             <td scope="col">{{$count+1}}</td>
             <td scope="col"  style='vertical-align: middle;'>{{$sms_push_attempt->mobile}}</td>
             <td scope="col"  style='vertical-align: middle;'>{{$sms_push_attempt->msg_body}}</td>
             <th scope="col"  style='vertical-align: middle;'>
                 @if($sms_push_attempt->status == 'faild_attempt' || $sms_push_attempt->status == 'pending')
                    <span style='color:red;min-height: 100px; display: inline-flex;align-items: center;'> {{$sms_push_attempt->status}} </span>
                 @else
                 <span style='color:green;min-height: 100px; display: inline-flex;align-items: center;'> {{$sms_push_attempt->status}} </span>
                 @endif
             </th>
             <th scope="col"  style='vertical-align: middle;'><span style='    padding: 1px; font-size: 18px; border: 1px solid #9E9E9E; border-radius: 7px;'>{{$sms_push_attempt->attempts}}</span> </th>
             <td scope="col"  style='vertical-align: middle;'><strong> {{$sms_push_attempt->name}}</strong> <br>{{$sms_push_attempt->created_at}} </td>
             <td scope="col"  style='vertical-align: middle;'><strong>{{$sms_push_attempt->updated_by}} </strong> <br> {{$sms_push_attempt->updated_at}}</td>
             <td scope="col"  style='vertical-align: middle;'>
                 @if($sms_push_attempt->status == 'faild_attempt' || $sms_push_attempt->status == 'pending')

                    <select name='provider_name'>
                        <option value='{{$sms_push_attempt->provider}}'> {{$sms_push_attempt->provider}} </option>
                    </select>
                 @else
                 <span style='color:green;min-height: 100px; display: inline-flex;align-items: center;'> {{$sms_push_attempt->provider}} </span>
                 @endif


                </td>
             <td scope="col"  style='vertical-align: middle;' >
                @if($sms_push_attempt->status == 'faild_attempt' || $sms_push_attempt->status == 'pending')
                    <button onclick='resend_msg({{$sms_push_attempt->id}})'>Resend</button>
                @else
                    <span>Sent successfully</span>
                @endif

             </td>
        </tr>
    @endforeach
    <tr style='background-color: #577984; color: #fffdfd; font-weight: bold;'>
      <th scope="col">#</th>
      <!--<th scope="col">Payment date</th>-->
      <th scope="col">Mobile</th>
      <th scope="col">Messages</th>
      <th scope="col">Status</th>
      <th scope="col">Attempts</th>
      <th scope="col">First attempt</th>
      <th scope="col">Last attempt at</th>
      <th scope="col">Provider</th>
      <th scope="col">Action</th>
    </tr>
  </tbody>
</table>


</body>
</html>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
