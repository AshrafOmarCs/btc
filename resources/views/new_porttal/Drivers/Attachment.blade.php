<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Input Form</title>
    <!-- Bootstrap CSS (version 5.0) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
        <style>
        .card {
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .form-label {
            font-weight: bold;
        }
        .dropify-wrapper {
            border: 2px dashed #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            @include('pages.messages2')
            @include('pages.messages')
            <div>
                <h4 style="font-weight: bold;">{{$drivers_attachments->fullName}} (<span style="color: #B7A758">{{$drivers_attachments->job_id}}</span>)</h4>
            </div>
            <div>
                <h2 style="font-size: 14px;font-weight: bold;"><font color="red">Select Files for Upload .jpg</font></h2>
            </div>
            <!-- Loop to create 5 cards -->
            <form method="POST" enctype="multipart/form-data" action="{{ URL('/SaveAttachment')}}" style="display: contents">
                @csrf
                <input type="hidden" name="id" value="{{$drivers_attachments->id}}">

                <div class="col-md-4 mb-4" style="padding: 10px">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php if (isset($drivers_attachments->Image_Identity) && $drivers_attachments->Image_Identity == '1') $img = 'correct'; else $img = 'wrong';?>
                                <img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px">
                                Image Identity(Iqama)  (الاقامة او الهوية الوطنية)</h5>
                            <div class="mb-3">
                                <label for="Image_Identity" class="form-label">
                                    <?php if(isset($drivers_attachments->Image_Identity) && $drivers_attachments->Image_Identity == '1'){?>
                                        <a
                                            target="_blank"
                                            href='{{asset("/Attachment/Image_Identity/".$drivers_attachments->id.".jpg")}}'
                                            style="background-color: green"
                                            class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="bi bi-eye"></i> </a>
                                        <a
                                            href="javascript:delete_attach('Image_Identity');"
                                            style="background-color: red"
                                            class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-trash"></i> </a>
                                        <?php
                                        }
                                    ?>
                                </label>
                                <input type="file" accept=".jpg" id="Image_Identity" name="Image_Identity" class="dropify" data-height="150" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4" style="padding: 10px">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php if (isset($drivers_attachments->Image_Passport) && $drivers_attachments->Image_Passport == '1') $img = 'correct'; else $img = 'wrong';?>
                                <img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px">
                                Image Passport (جواز السفر)</h5>
                            <div class="mb-3">
                                <label for="Image_Passport" class="form-label">
                                    <?php if(isset($drivers_attachments->Image_Passport) && $drivers_attachments->Image_Passport == '1'){?>
                                        <a
                                            target="_blank"
                                            href='{{asset("/Attachment/Image_Passport/".$drivers_attachments->id.".jpg")}}'
                                            style="background-color: green"
                                            class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="bi bi-eye"></i> </a>
                                        <a
                                            href="javascript:delete_attach('Image_Passport');"
                                            style="background-color: red"
                                            class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-trash"></i> </a>
                                        <?php
                                        }
                                    ?>
                                </label>
                                <input type="file" accept=".jpg" id="Image_Passport" name="Image_Passport" class="dropify" data-height="150" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4" style="padding: 10px">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php if (isset($drivers_attachments->Image_DrivingLicence) && $drivers_attachments->Image_DrivingLicence == '1') $img = 'correct'; else $img = 'wrong';?>
                                <img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px">
                                Image Driving Licence (رخصة القيادة)</h5>
                            <div class="mb-3">
                                <label for="Image_DrivingLicence" class="form-label">
                                    <?php if(isset($drivers_attachments->Image_DrivingLicence) && $drivers_attachments->Image_DrivingLicence == '1'){?>
                                        <a
                                            target="_blank"
                                            href='{{asset("/Attachment/Image_DrivingLicence/".$drivers_attachments->id.".jpg")}}'
                                            style="background-color: green"
                                            class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="bi bi-eye"></i> </a>
                                        <a
                                            href="javascript:delete_attach('Image_DrivingLicence');"
                                            style="background-color: red"
                                            class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-trash"></i> </a>
                                        <?php
                                        }
                                    ?>
                                </label>
                                <input type="file" accept=".jpg" id="Image_DrivingLicence" name="Image_DrivingLicence" class="dropify" data-height="150" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4" style="padding: 10px">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php if (isset($drivers_attachments->Image_VehiclesRegistration) && $drivers_attachments->Image_VehiclesRegistration == '1') $img = 'correct'; else $img = 'wrong';?>
                                <img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px">
                                Image Vehicles Registration (استمارة السير)</h5>
                            <div class="mb-3">
                                <label for="Image_VehiclesRegistration" class="form-label">
                                    <?php if(isset($drivers_attachments->Image_VehiclesRegistration) && $drivers_attachments->Image_VehiclesRegistration == '1'){?>
                                        <a
                                            target="_blank"
                                            href='{{asset("/Attachment/Image_VehiclesRegistration/".$drivers_attachments->id.".jpg")}}'
                                            style="background-color: green"
                                            class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="bi bi-eye"></i> </a>
                                        <a
                                            href="javascript:delete_attach('Image_VehiclesRegistration');"
                                            style="background-color: red"
                                            class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-trash"></i> </a>
                                        <?php
                                        }
                                    ?>
                                </label>
                                <input type="file" accept=".jpg" id="Image_VehiclesRegistration" name="Image_VehiclesRegistration" class="dropify" data-height="150" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4" style="padding: 10px">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php if (isset($drivers_attachments->Image_JobContract) && $drivers_attachments->Image_JobContract == '1') $img = 'correct'; else $img = 'wrong';?>
                                <img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px">
                                Image Job Contract (عقد العمل)</h5>
                            <div class="mb-3">
                                <label for="Image_JobContract" class="form-label">
                                    <?php if(isset($drivers_attachments->Image_JobContract) && $drivers_attachments->Image_JobContract == '1'){?>
                                        <a
                                            target="_blank"
                                            href='{{asset("/Attachment/Image_JobContract/".$drivers_attachments->id.".jpg")}}'
                                            style="background-color: green"
                                            class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="bi bi-eye"></i> </a>
                                        <a
                                            href="javascript:delete_attach('Image_JobContract');"
                                            style="background-color: red"
                                            class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-trash"></i> </a>
                                        <?php
                                        }
                                    ?>
                                </label>
                                <input type="file" accept=".jpg" id="Image_JobContract" name="Image_JobContract" class="dropify" data-height="150" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4" style="padding: 10px">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php if (isset($drivers_attachments->Image_PromissoryNote) && $drivers_attachments->Image_PromissoryNote == '1') $img = 'correct'; else $img = 'wrong';?>
                                <img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px">
                                Image Promissory Note (سند الامر)</h5>
                            <div class="mb-3">
                                <label for="Image_PromissoryNote" class="form-label">
                                    <?php if(isset($drivers_attachments->Image_PromissoryNote) && $drivers_attachments->Image_PromissoryNote == '1'){?>
                                        <a
                                            target="_blank"
                                            href='{{asset("/Attachment/Image_PromissoryNote/".$drivers_attachments->id.".jpg")}}'
                                            style="background-color: green"
                                            class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="bi bi-eye"></i> </a>
                                        <a
                                            href="javascript:delete_attach('Image_PromissoryNote');"
                                            style="background-color: red"
                                            class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-trash"></i> </a>
                                        <?php
                                        }
                                    ?>
                                </label>
                                <input type="file" accept=".jpg" id="Image_PromissoryNote" name="Image_PromissoryNote" class="dropify" data-height="150" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-12 text-center">
                    <button class="btn btn-primary" type="submit">Save Attachments</button>
                    <br /><br /><br />
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle with Popper (version 5.0) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Dropify JS -->
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Dropify
            $('.dropify').dropify();
            $('.file-icon').html('<p style="font-size: 25px">Drop file here</p>');

        });
        function view_attach(name) {
            alert(name);
            // myWindow1 = window.open("{{URL("/Attachment")}}" + "/" + name + "/" + {{$drivers_attachments->id}} + ".jpg", "mywin2",
            //     "height=900,width=800,scrollbars=yes,top=1,left=1,status,resizable");
            // myWindow1.focus();
    }
    function delete_attach(name) {
        var result = confirm("Are you sure Want to delete?");
        if (result) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: "{{URL("/DeleteAttachment")}}" + "/" + name + "/" + {{$drivers_attachments->id}},
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    location.reload();
                    // document.getElementById('response').innerHTML = data;
                }
            });
        }
    }
    </script>
</body>
</html>
