<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Views</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&display=swap" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
   

    <!-- <table>
        <tr>
            <th>username</th>
            <th>name</th>
            <th>id</th>
        </tr>
        @foreach($payload as $items)
        <tr>
            <td>{{$items['username']}}</td>
            <td>{{$items['name']}}</td>
            <td>{{$items['id']}}</td>
           
        </tr>
        @endforeach
    </table> -->

<script>
    $(document).ready(function(){

    // jQuery methods go here...
    var settings = {
        "url": "https://saned.io/retrieveDriverInfo?sEcho=6&iColumns=15&sColumns=%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C%2C&iDisplayStart=0&iDisplayLength=10&mDataProp_0=id&sSearch_0=&bRegex_0=false&bSearchable_0=true&mDataProp_1=username&sSearch_1=&bRegex_1=false&bSearchable_1=true&mDataProp_2=organization.name&sSearch_2=&bRegex_2=false&bSearchable_2=true&mDataProp_3=mobile&sSearch_3=&bRegex_3=false&bSearchable_3=true&mDataProp_4=name&sSearch_4=&bRegex_4=false&bSearchable_4=true&mDataProp_5=imei&sSearch_5=&bRegex_5=false&bSearchable_5=true&mDataProp_6=posSerialNumber&sSearch_6=&bRegex_6=false&bSearchable_6=true&mDataProp_7=terminalId&sSearch_7=&bRegex_7=false&bSearchable_7=true&mDataProp_8=online&sSearch_8=&bRegex_8=false&bSearchable_8=true&mDataProp_9=status&sSearch_9=&bRegex_9=false&bSearchable_9=true&mDataProp_10=ceased&sSearch_10=&bRegex_10=false&bSearchable_10=true&mDataProp_11=citcApprovalStatus&sSearch_11=&bRegex_11=false&bSearchable_11=true&mDataProp_12=citcApprovalStatus&sSearch_12=&bRegex_12=false&bSearchable_12=true&mDataProp_13=citcErrorCodes&sSearch_13=&bRegex_13=false&bSearchable_13=true&mDataProp_14=&sSearch_14=&bRegex_14=false&bSearchable_14=true&sSearch=&bRegex=false&_=1647021075923",
        "method": "GET",
        "timeout": 0,
        "headers": {
            "cookie": "JSESSIONID=8htdZBiRy3FU9T1bA2SxtAugpF9JnL6tHj8aJhoa.ip-172-31-26-48; AWSALB=hkL0FyCDcbKdAw7djWPeK+M0PQKrgEEKe+Yo4XHvI2SvQ4eTD+MSST/lcNv8tHudPGAz/Qpf7qiBWoCb4EKhBC1whiYO1q1nehbQajogaiWLIXvgxnxBNTgB7bwbpCCtn1SrQV1O2cj45adDqxJpX7yCVZf5VQWfS9USPtnuFzSEH6cRPVue9CTGLFerQg==; AWSALBCORS=hkL0FyCDcbKdAw7djWPeK+M0PQKrgEEKe+Yo4XHvI2SvQ4eTD+MSST/lcNv8tHudPGAz/Qpf7qiBWoCb4EKhBC1whiYO1q1nehbQajogaiWLIXvgxnxBNTgB7bwbpCCtn1SrQV1O2cj45adDqxJpX7yCVZf5VQWfS9USPtnuFzSEH6cRPVue9CTGLFerQg==; JSESSIONID=IEwQJ3hwER93qCYD6V2B0XzLcJiXvdawq8uaHU1F.ip-172-31-26-48; AWSALB=BApnLvhI40gn0fjxDqDMNRKKiMvLZ78ZdlH9bLtrtPbc44tAu7ShqCC6e3ut9v4clFHDkmmKd/k1yaq7BVtmz0z4kocc8EOZeH1PSBpdelwVhjPX9NaddAyHRQJ3EXn3JCszvTD7uBa00KzdQQFNajJ2ZyjDj4XLcCHwpV5RX9f+hMiGoH3FygPEJh1TSg==; AWSALBCORS=BApnLvhI40gn0fjxDqDMNRKKiMvLZ78ZdlH9bLtrtPbc44tAu7ShqCC6e3ut9v4clFHDkmmKd/k1yaq7BVtmz0z4kocc8EOZeH1PSBpdelwVhjPX9NaddAyHRQJ3EXn3JCszvTD7uBa00KzdQQFNajJ2ZyjDj4XLcCHwpV5RX9f+hMiGoH3FygPEJh1TSg=="
        },
        };

        $.ajax(settings).done(function (response) {
        console.log(response);
        });
    });
    
</script>
</body>
</html>