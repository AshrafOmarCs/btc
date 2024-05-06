<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

</head>
<body>
    <button onclick="sendHttpRequest()">sendHttpRequest</button>
   <script>
    function sendHttpRequest(){ 
        $.ajax({
            url: "http://REST.GATEWAY.SA/api/SendSMS?api_id=API85085034640&api_password=As@050987&phonenumber=966539529559&templateid=1969&V1=555558&sms_type=T&encoding=U&sender_id=BTC.sa",
            type: 'GET', 
            success: function(res) {
                console.log(res);
                alert(res);
            }
        });
        
    }
   </script>
</body>
</html>