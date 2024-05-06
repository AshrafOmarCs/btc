<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    SendHttpTpVps

    <script> 
        var drivers = <?php echo json_encode($LM_drivers); ?>; 
        var payload;
        drivers.forEach(element => {
            console.log(element);

            const xhr = new XMLHttpRequest();
            xhr.open("GET", "getDAJournals/"+element.id);
            xhr.send();
            xhr.responseType = "json";
            xhr.onload = () => {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const data = xhr.response;
                if(data.status == true){
                    payload = data.payload;
                    var returnData;
                    this.SendHttpRequest(payload);
                    // payload.forEach(element2 => { 
                     
                        // Something you want delayed.
                        // alert('AA'); 
                    // });
                }
                
            } else {
                console.log(`Error: ${xhr.status}`);
            }
            }; 
            
        });
        function SendHttpRequest(args){
            // var jdata = new Object();
            // jdata.level = levelVal; // level is key and levelVal is value
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "https://btcdmins.com/api/Landmark-api", true);
            xhttp.setRequestHeader('Content-Type', 'application/json');
            xhttp.send(JSON.stringify('ss'));

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                }
            }



            // // alert(driverId+' - '+journal_id);
            // const xhr = new XMLHttpRequest(); 
            // xhr.open("POST", "https://btcdmins.com/api/Landmark-api/",payload);
            // xhr.send();
            // xhr.responseType = "json";
            // xhr.onload = () => {
            // if (xhr.readyState == 4 && xhr.status == 200) {
            //     const data = xhr.response;
            //     return data;
            //     console.log(data);
            // } else {
            //     console.log(`Error: ${xhr.status}`);
            // }
            // };
        }
    </script>
</body>
</html>