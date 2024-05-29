
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$row[0]->companyName}} Verfication</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 650px !important;
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
            background-color: green; /* Change to a different color on hover */
        }
        .styled-input {
            width: 87%; /* Adjust the width as needed */
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none; /* Remove the default input outline */
        }

        /* Style the input field on focus */
        .styled-input:focus {
            border-color: #007bff; /* Change border color on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add a subtle box shadow on focus */
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @else
            <h1>Verification</h1>
            <p>Dear {{$row[0]->companyName}},</p>
            <p>Please choose any one method for verification. Then we will send you an otp code.</p>
            <form action="{{ route('verification')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" value="{{base64_encode($row[0]->id)}}">
                <button type="button" class="btn btn-outline-primary" id="sms_btn">Sim OTP</button>
                <button type="button" class="btn btn-outline-primary" id="email_btn">Email OTP</button>
                <p class="mobile mt-2"><strong>Mobile Number:</strong></p>
                <div class="mobile input-group mb-3">
                  <input type="number" name="info_person_phone_no" class="styled-input mobile" id="info_person_phone_no" placeholder="Example: 512345678" required pattern="^[0-9]{9}$" aria-describedby="button-addon2">
                  <button class="btn btn-outline-secondary" type="button" id="button-addon2">Ok</button>
                  <span class="error-message mobile" id="phone-error" style="color: red"></span>
                </div>
                <p class="email mt-2"><strong>Email:</strong></p>
                <div class="email input-group mb-3">
                  <input type="email" name="email" class="styled-input email" id="email" placeholder="abc@company.com" aria-describedby="button-addon1">
                  <button class="btn btn-outline-secondary" type="button" id="button-addon1">Ok</button>
                  <span class="error-message email" id="email-error" style="color: red"></span>
                </div>
                <p class="otp mt-2"><strong>OTP:</strong></p>
                <input type="number" name="otp" class="styled-input otp" id="otp" placeholder="Please Enter 6 digit otp" required pattern="^[0-9]{6}$">
                <br><br>
                <span id="submit_btn">

                </span>
            </form>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $('.email').hide();
    $('.mobile').hide();
    $('.otp').hide();
    document.getElementById('sms_btn').addEventListener('click', function () {
        $('.mobile').show();
        $('.email').hide();
        $('#submit_btn').html('');
        $('.otp').hide();
        $(".mobile").prop('required',true);
        $(".email").prop('required',false);
    });
    document.getElementById('email_btn').addEventListener('click', function () {
        $('.mobile').hide();
        $('.email').show();
        $('#submit_btn').html('');
        $('.otp').hide();
        $(".email").prop('required',true);
        $(".mobile").prop('required',false);
    });
    document.getElementById('button-addon2').addEventListener('click', function () {
        let phoneInput = $('#info_person_phone_no').val();
        var phoneError = document.getElementById('phone-error');
        if (!phoneInput.match(/^\d{9}$/)) {
            phoneError.textContent = "Please enter a valid 9-digit phone number (e.g., 512345678)";
            $('#submit_btn').html('');
        } else {
            $.ajax({
                type: 'POST',
                url: "{{URL("/ContractsQuotation/phoneEmailVerification")}}",
                data: {
                    id: $('#id').val(),
                    phoneInput: phoneInput,
                    type: 'phone',
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    if(data == 'true') {
                        $('.otp').show();
                        $('#submit_btn').html('<button type="submit" class="submit">Submit</button>');
                        phoneError.textContent = '';

                    } else {
                        phoneError.textContent = "Invalid phone number!";
                        $('.otp').hide();
                        $('#otp').val('');
                    }
                }
            });

        }
    });
    document.getElementById('button-addon1').addEventListener('click', function () {
        let email = $('#email').val();
        var emailError = document.getElementById('email-error');
        $.ajax({
            type: 'POST',
            url: "{{URL("/ContractsQuotation/phoneEmailVerification")}}",
            data: {
                id: $('#id').val(),
                email: email,
                type: 'email',
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                if(data == 'true') {
                    $('.otp').show();
                    $('#submit_btn').html('<button type="submit" class="submit">Submit</button>');
                    emailError.textContent = '';
                } else {
                    emailError.textContent = "Invalid email!";
                    $('.otp').hide();
                    $('#otp').val('');
                }
            }
        });
    });

    function show_hide(type, company_type = 0) {
        $('#person_name').show();
        if(company_type == 1)
        {
            if(type == 1) {
                $('#free_div').hide();
                $('#company_info').show();
                $(".required").prop('required',true);
            } else {
                $('#free_div').show();
                $('#company_info').hide();
                $(".required").prop('required',false);
            }
        } else {
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
        if(type == '')
            $('#person_name').hide();
    }
</script>
