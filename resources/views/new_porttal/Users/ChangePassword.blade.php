@extends('layout2')
@section('content')
@section('title', __('users.ResetPassword'))


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('users.ResetPassword')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">{{__('users.userPassDes')}}</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <form  method="POST"  action="{{ URL('/ChangePasswordSave')}}">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 col-sm-6 col-12">
                                <!-- Form Field Start -->
                                <div class="mb-3">
                                    <label for="country" class="form-label">{{__('users.password')}}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" onkeyup="validate_Password()" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-sm-6 col-12">
                                <!-- Form Field Start -->
                                <div class="mb-3">
                                    <label for="country" class="form-label">{{__('users.confirm_password')}}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" onkeyup="is_match_password(this.value)" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-sm-12 col-12">
                                <small id="lengthMessage" style="color: red; display: block;"> * {{__('passwords.validation1')}}</small>
                                <small id="lowercaseMessage" style="color: red; display: block;"> * {{__('passwords.validation2')}}</small>
                                <small id="uppercaseMessage" style="color: red; display: block;"> * {{__('passwords.validation3')}}</small>
                                <small id="digitMessage" style="color: red; display: block;"> * {{__('passwords.validation4')}}</small>
                                <small id="specialCharMessage" style="color: red; display: block;"> * {{__('passwords.validation5')}}</small>
                                <small id="repeatingCharMessage" style="color: red; display: block;"> * {{__('passwords.validation6')}}</small>
                                <small id="sequenceCharMessage" style="color: red; display: block;"> * {{__('passwords.validation7')}}</small>
                                <small id="confirmPasswordMessage" style="color: red; display: block;"> * {{__('passwords.validation8')}}</small>
                            </div>
                            <button type="" class="btn btn-success" id="change_btn">{{__('passwords.change_password')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <!-- Card end -->

    </div>
</div>


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        function validate_Password(password = '') {
        if(password == '')
            password = document.getElementById("password").value;
        const lengthMessage = document.getElementById("lengthMessage");
        const lowercaseMessage = document.getElementById("lowercaseMessage");
        const uppercaseMessage = document.getElementById("uppercaseMessage");
        const digitMessage = document.getElementById("digitMessage");
        const specialCharMessage = document.getElementById("specialCharMessage");
        const repeatingCharMessage = document.getElementById("repeatingCharMessage");
        const sequenceCharMessage = document.getElementById("sequenceCharMessage");

        // Define validation rules
        const minLength = 8;
        const hasLowercase = /[a-z]/.test(password);
        const hasUppercase = /[A-Z]/.test(password);
        const hasDigit = /\d/.test(password);
        const specialChars = /[!@#$%^&*()_+{}\[\]:;<>,.?/~\\-]/;
        const hasSpecialChar = specialChars.test(password);

        const repeatingCharsRegex = /(.)\1\1/;
        const hasRepeatingChars = !repeatingCharsRegex.test(password);

        // Check for sequential patterns (e.g., 123, 456, abc)
        const sequentialPatternsRegex = /(123|234|345|456|567|678|789|890|abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/;
        const hasSequentialPatterns = !sequentialPatternsRegex.test(password);

        // Check and display messages
        let check = 'false';
        let validation1 = @json(__('passwords.validation1'));
        if (password.length >= minLength) {
            lengthMessage.style.color = "green";
            lengthMessage.textContent = validation1;
        } else {
            lengthMessage.style.color = "red";
            check = 'true';
            lengthMessage.textContent = " * " + validation1;
        }
        let validation2 = @json(__('passwords.validation2'));
        if (hasLowercase) {
            lowercaseMessage.style.color = "green";
            lowercaseMessage.textContent = validation2;
        } else {
            lowercaseMessage.style.color = "red";
            check = 'true';
            lowercaseMessage.textContent = " * " + validation2;
        }
        let validation3 = @json(__('passwords.validation3'));

        if (hasUppercase) {
            uppercaseMessage.style.color = "green";
            uppercaseMessage.textContent = validation3;
        } else {
            uppercaseMessage.style.color = "red";
            check = 'true';
            uppercaseMessage.textContent = " * " + validation3;
        }
        let validation4 = @json(__('passwords.validation4'));

        if (hasDigit) {
            digitMessage.style.color = "green";
            digitMessage.textContent = validation4;
        } else {
            digitMessage.style.color = "red";
            check = 'true';
            digitMessage.textContent = " * " + validation4;
        }
        let validation5 = @json(__('passwords.validation5'));
        if (hasSpecialChar) {
            specialCharMessage.style.color = "green";
            specialCharMessage.textContent = validation5;
        } else {
            specialCharMessage.style.color = "red";
            check = 'true';
            specialCharMessage.textContent = " * " + validation5;
        }
        let validation6 = @json(__('passwords.validation6'));
        if (hasRepeatingChars && password != '') {
            repeatingCharMessage.style.color = "green";
            repeatingCharMessage.textContent = validation6;
        } else {
            repeatingCharMessage.style.color = "red";
            check = 'true';
            repeatingCharMessage.textContent = " * " + validation6;
        }
        let validation7 = @json(__('passwords.validation7'));
        if (hasSequentialPatterns && password != '') {
            sequenceCharMessage.style.color = "green";
            sequenceCharMessage.textContent = validation7;
        } else {
            sequenceCharMessage.style.color = "red";
            check = 'true';
            sequenceCharMessage.textContent = " * " + validation7;
        }
        const changeButton = document.getElementById("change_btn");
        if(check == 'true') {
            changeButton.type = "button";
        } else {
            changeButton.type = "submit";
        }
        return check;
    }
    function is_match_password(m_password) {
        const changeButton = document.getElementById("change_btn");
        const password = document.getElementById("password").value;
        // let check = validate_Password(m_password)
        let check = 'false';
        let validation8 = @json(__('passwords.validation8'));
        if(password == m_password && check == 'false' && m_password != '' && password != '') {
            changeButton.type = "submit";
            $('#confirmPasswordMessage').html(validation8)
            $('#confirmPasswordMessage').css('color', 'green');
        }
        else {
            $('#confirmPasswordMessage').html(' * ' + validation8)
            changeButton.type = "button";
            $('#confirmPasswordMessage').css('color', 'red');
        }
    }
    </script>
@stop
@endsection
