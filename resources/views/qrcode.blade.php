<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>qrcode </title>
</head>
<body>
    <div id="data_id">
        <div class="col">
        <?php
        echo '<img id="qrcode" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https://linktr.ee/bandr_trading_co">';
        ?>
        </div>
        </div>
        <button id="downloadid" class="btn btn-small btn-primary">Download</button>

        
<script>
    var d = document.getElementById("downloadid");
    d.addEventListener("click", function(e) {
        this.qrcode = new QRCode(document.getElementById('qrcode'), {
      logo: logoLink,
      text: link,
      width: 256,
      height: 256,
      colorDark: '#000000',
      colorLight: '#ffffff',
      correctLevel: QRCode.CorrectLevel.H,
      logoWidth: undefined,
      logoHeight: undefined,
      logoBackgroundColor: '#ffffff',
      logoBackgroundTransparent: false,
    });

    
    // var div = document.getElementById("data_id");
    // var opt = {
    // margin: [20, 20, 20, 20],
    // filename: `filname.pdf`,
    // image: {
    //    type: 'jpg',
    //    quality: 0.98
    // },
    // html2canvas: {
    //   scale: 2,
    //   useCORS: true
    // },
    // jsPDF: {
    // unit: 'mm',
    // format: 'letter',
    // orientation: 'portrait'
    // }
    // };
    // html2pdf().from(div).set(opt).save();
    });
    </script>
</body>
</html>