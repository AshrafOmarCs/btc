<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$row[0]->companyName}} Information</title>
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
        .styled-input {
            width: 98%; /* Adjust the width as needed */
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

        /* Style a label for the input (optional) */
        .input-label {
            font-size: 14px;
            color: #555;
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
        @if ($row[0]->status === 0 OR $row[0]->status === 1 OR $row[0]->status === 2 OR $row[0]->status > 3)
            <h1>You have already Done with this.</h1>
        @else
        <select onchange="change_lang(this.value)" class="arb1" id="language">
            <option value="eng">EN</option>
            <option value="arb">AR</option>
        </select>
        <h1 class="eng">{{$row[0]->companyName}} Information</h1>
        <h1 class="arb">معلومات {{$row[0]->companyName_ar}}</h1>
        <p class="eng">Dear {{$row[0]->companyName}},</p>
        <p class="arb">عزيزي {{$row[0]->companyName_ar}}،</p>
        <p class="eng">We are pleased to inform you that you are going to become a part of BTC. Please provide the following details.</p>
        <p class="arb">يسعدنا أن نعلمك أنك ستصبح جزءًا من BTC. يرجى تقديم التفاصيل التالية.</p>

        <form action="{{ route('QuotationAccept')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{base64_encode($row[0]->id)}}">
            @if($row[0]->contractType == 2)
            <p class="eng"><strong>Type:</strong></p>
            <p class="arb"><strong>يكتب:</strong></p>
            <select class="styled-input" name="company_type" required onchange="show_hide(this.value, 1)" style="width: 101%;">
                <option class="eng" value="">Select Type</option>
                <option class="eng" @if($row[0]->company_type == 1) selected @endif value="1">Company/Institution</option>
                <option class="arb" @if($row[0]->company_type == 1) selected @endif value="1">الشركة/المؤسسة</option>
                <option class="eng" @if($row[0]->company_type == 2) selected @endif value="2">Individual</option>
                <option class="arb" @if($row[0]->company_type == 2) selected @endif value="2">فردي</option>
            </select>
            @endif

            <span id="company_info" @if($row[0]->contractType == 2 OR $row[0]->company_type == 2) style="display: none;"  @endif>
                <p class="eng"><strong>Company Registration Number:</strong></p>
                <p class="arb"><strong>رقم تسجيل الشركة:</strong></p>
                <input type="number" class="styled-input required" name="reg_number" value="{{$row[0]->reg_number}}">
                @if($row[0]->reg_certificate_check == 1 OR $row[0]->reg_certificate =='')
                <p class="eng"><strong>Commercial Registration Certificate:</strong></p>
                <p class="arb"><strong>شهادة السجل التجاري:</strong></p>
                <input type="file" class="styled-input required" name="reg_certificate">
                @endif
                <p class="eng"><strong>National Address English:</strong></p>
                <p class="arb"><strong>العنوان الوطني الإنجليزية:</strong></p>
                <textarea name="national_address_en" class="styled-input required">{{$row[0]->national_address_en}}</textarea>
                <p class="eng"><strong>National Address Arabic:</strong></p>
                <p class="arb"><strong>العنوان الوطني العربية:</strong></p>
                <textarea name="national_address_ar" class="styled-input required">{{$row[0]->national_address_ar}}</textarea>
                @if($row[0]->address_check == 1 OR $row[0]->address == '')
                <p class="eng"><strong>National Address:</strong></p>
                <p class="arb"><strong>العنوان الوطني:</strong></p>
                <input type="file" name="address" class="styled-input required">
                @endif
                @if($row[0]->chamber_file_check == 1 OR $row[0]->chamber_file == '')
                <p class="eng"><strong>Chamber File:</strong></p>
                <p class="arb"><strong>ملف الغرفة:</strong></p>
                <input type="file" name="chamber_file" class="styled-input required">
                @endif
                <!--<p><strong>Owner ID:</strong></p>-->
                <!--<input type="text" name="owner_id" required>-->
                <p class="eng"><strong>Vat Registration Certificate Number:</strong></p>
                <p class="arb"><strong>رقم شهادة تسجيل ضريبة القيمة المضافة:</strong></p>
                <input type="text" name="vat_certificate_number" class="styled-input required" value="{{$row[0]->vat_certificate_number}}">
                @if($row[0]->vat_certificate_check == 1 OR $row[0]->vat_certificate == '')
                <p class="eng"><strong>Vat Registration Certificate:</strong></p>
                <p class="arb"><strong>رقم شهادة تسجيل ضريبة القيمة المضافة:</strong></p>
                <input type="file" name="vat_certificate" class="styled-input required">
                @endif
                @if($row[0]->iban_certificate_check == 1 OR $row[0]->iban_certificate == '')
                <p class="eng"><strong>IBAN Certificate:</strong></p>
                <p class="arb"><strong>شهادة الآيبان:</strong></p>
                <input type="file" name="iban_certificate" class="styled-input required">
                @endif
                <p class="eng"><strong>IBAN Number:</strong></p>
                <p class="arb"><strong>رقم الآيبان:</strong></p>
                <input type="text" name="iban_number" class="styled-input required" value="{{$row[0]->iban_number}}">
                <p class="eng"><strong>Who are you?:</strong></p>
                <p class="arb"><strong>من أنت؟:</strong></p>
                <label class="radio-inline">
                  <input type="radio" name="info_person" value="0" @if($row[0]->info_person == 0) checked @endif onclick="show_hide(0)"><span class="eng">Owner</span><span class="arb">مالك</span>
                </label>
                <label class="radio-inline">
                  <input type="radio" name="info_person" value="1" @if($row[0]->info_person == 1) checked @endif onclick="show_hide(1)"><span class="eng">Authenticated Person</span><span class="arb">الشخص المعتمد</span>
                </label>

            </span>
            <span id="person_name" @if($row[0]->contractType == '') style="display: none" @endif>
                <p class="eng"><strong>Name:</strong></p>
                <p class="arb" style="direction: rtl"><strong>اسم:</strong></p>
                <input type="text" name="info_person_name" class="styled-input" id="info_person_name" value="{{$row[0]->info_person_name}}" required>
                <p class="eng"><strong>Name (Arabic):</strong></p>
                <p class="arb" style="direction: rtl"><strong>الاسم (عربي):</strong></p>
                <input type="text" name="info_person_name_ar" class="styled-input" id="info_person_name_ar" value="{{$row[0]->info_person_name_ar}}" required>
                <p class="eng"><strong>Mobile Number:</strong></p>
                <p class="arb" style="direction: rtl"><strong>رقم الهاتف المحمول:</strong></p>
                <input type="number" name="info_person_phone_no" class="styled-input" id="info_person_phone_no" value="{{$row[0]->info_person_phone_no}}" placeholder="Example: 512345678" required pattern="^[0-9]{9}$">
                <span class="error-message" id="phone-error" style="color: red"></span>
                @if($row[0]->iqama_check == 1 OR $row[0]->iqama == '')
                    <p class="eng"><strong>Owner ID/Iqama:</strong></p>
                    <p class="arb" style="direction: rtl"><strong>هوية المالك/الإقامة:</strong></p>
                    <input type="number" name="iqama_number" class="styled-input" required>
                    <p class="eng"><strong>Owner ID/Iqama:</strong></p>
                    <p class="arb" style="direction: rtl"><strong>هوية المالك/الإقامة:</strong></p>
                    <input type="file" name="iqama" class="styled-input" required>
                @endif
                @if(($row[0]->freelance_cert_check == 1 OR $row[0]->freelance_cert == '') AND $row[0]->contractType == '2')
                    <span id="free_div" @if($row[0]->company_type == '1') style="display: none;" @endif><p class="eng"><strong>Freelance certificate:</strong></p><p class="arb" style="direction: rtl;"><strong>شهادة العمل الحر:</strong></p>
                    <input type="file" name="freelance_cert" class="styled-input"></span>
                @endif
            </span>
            <span id="person" @if($row[0]->info_person != 1) style="display: none;" @endif>
                <p class="eng"><strong>Authentication Letter:</strong></p>
                <p class="arb" style="direction: rtl"><strong>خطاب المصادقة:</strong></p>
                <input type="file" name="auth_letter" class="styled-input required" id="auth_letter">
                <p class="eng"><strong>ID/Iqama Image:</strong></p>
                <p class="arb" style="direction: rtl"><strong>صورة الهوية/الإقامة:</strong></p>
                <input type="file" name="iqama_image" class="styled-input required" id="iqama_image">
            </span>
            <br><br>
            <span id="submit_btn">
                <button type="submit" class="submit"><span class="eng">Submit</span><span class="arb">يُقدِّم</span></button>
            </span>
        </form>
        @endif
        @endif
        @if ($row[0]->status === 0 || $row[0]->status === 1)
        <p>Feel free to reach out if you have any questions or need further information.</p>
        <a href="https://btclogistic.com/" class="btn">Visit Our Website</a>
        @endif
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    document.getElementById('info_person_phone_no').addEventListener('blur', function () {
        var phoneInput = this.value;
        var phoneError = document.getElementById('phone-error');
        if (!phoneInput.match(/^\d{9}$/)) {
            phoneError.textContent = "Please enter a valid 9-digit phone number (e.g., 512345678)";
            $('#submit_btn').html('');
        } else {
            if($('#language').val() == 'eng')
                $('#submit_btn').html('<button type="submit" class="submit">Submit</button>');
            else
                $('#submit_btn').html('<button type="submit" class="submit">يُقدِّم</button>');
            phoneError.textContent = '';
        }
    });
    $('.arb').hide();

    function change_lang(lang) {
        if(lang == 'eng') {
            $('.eng').show();
            $('.arb').hide();
            $('.styled-input').css("direction", "ltr");
            $('.arb').css("direction", "ltr");
        } else {
            $('.styled-input').css("direction", "rtl");
            $('.arb').css("direction", "rtl");
            $('.eng').hide();
            $('.arb').show();
        }
    }
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
        if(type === '')
            $('#person_name').hide();
    }
</script>

