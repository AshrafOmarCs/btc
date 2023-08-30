<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Request Accepted</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .submit {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }
        .submit:hover {
            background-color: #c82333; /* Change to a different color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @else
        @if ($status === 0)
            <h1>You have already Rejected this quotation</h1>
        @elseif ($status === 1)
            <h1>You have already Accepted this quotation</h1>
        @else
        <h1>Quotation Request Accepted</h1>
        <p>Dear {{$company}},</p>
        <p>We are pleased to inform you that you have successfully accepted our quotation request. Please provide the following details.</p>
        <form action="{{ route('QuotationAccept')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <p><strong>Company Registration Number:</strong></p>
            <input type="number" name="reg_number" required>
            <p><strong>Commercial Registration Certificate:</strong></p>
            <input type="file" name="reg_certificate" required>
            <p><strong>National Address:</strong></p>
            <input type="file" name="address" required>
            <p><strong>Chamber File:</strong></p>
            <input type="file" name="chamber_file" required>
            <p><strong>Owner ID/Iqama:</strong></p>
            <input type="file" name="iqama" required>
            <p><strong>Vat Registration Certificate:</strong></p>
            <input type="file" name="vat_certificate" required>
            <p><strong>IBAN Certificate:</strong></p>
            <input type="file" name="iban_certificate" required>
            <p><strong>IBAN Number:</strong></p>
            <input type="text" name="iban_number" required>
            <p><strong>Who are you?:</strong></p>
            <label class="radio-inline">
              <input type="radio" name="info_person" value="0" checked onclick="show_hide(0)">Owner
            </label>
            <label class="radio-inline">
              <input type="radio" name="info_person" value="1" onclick="show_hide(1)">Authenticated Person
            </label>
            <span id="person" style="display: none;">
                <p><strong>Authentication Letter:</strong></p>
                <input type="file" name="auth_letter" id="auth_letter">
                <p><strong>ID/Iqama Image:</strong></p>
                <input type="file" name="iqama_image" id="iqama_image">
            </span>
            <br><br>
            <button type="submit" class="submit">Submit</button>
        </form>
        @endif
        @endif
        <p>Feel free to reach out if you have any questions or need further information.</p>
        <p>Best regards,</p>
        <p>Bandar Trading Company</p>
        <a href="https://btclogistic.com/" class="btn">Visit Our Website</a>
    </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    function show_hide(type) {
        if(type == 0) {
            $("#auth_letter").prop('required',false);
            $("#iqama_image").prop('required',false);

 
            $('#person').hide();
        } else {
            $("#auth_letter").prop('required',true);
            $("#iqama_image").prop('required',true);
            $('#person').show();
        }
    }
</script>