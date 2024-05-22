<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{asset("/AdminLTE/css/bootstrap.min.css")}}">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset("/AdminLTE/font-awesome/font-awesome.min.css")}}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{asset("/AdminLTE/css/ionicons.min.css")}}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset("/AdminLTE/plugins/iCheck/all.css")}}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.css")}}">
<!-- Theme style -->

<link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{asset("/AdminLTE/css/_all-skins.min.css")}}">
<link rel="stylesheet" href="{{asset("/AdminLTE/css/dataTables.bootstrap.min.css")}}">
<!--<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
<link rel="stylesheet" href="{{asset("/AdminLTE/css/customize.css")}}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<body style="margin:30PX;padding:0">

<style>

    .show_table th {
        padding-left: 20px !important;
        white-space: nowrap;
        border: none !important;
        margin: 0 !important;
        font-size: 12px !important;
    }

    .show_table td {
        padding: 0.0rem 0.0rem !important;
        border: none !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
        font-size: 12px !important;
    }
</style>
<div style="width:100%;clear:both;" id="response">

    @include('pages.loader')
    @include('pages.messages2')
    @include('pages.messages')
    <center>
        <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
                style="width:100%;font-size: 14px;font-weight: bold;">{{$Driver->fullName}}</h2>
        </div>

        <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2
                style="width:100%;font-size: 14px;font-weight: bold;"><font color="red">Select Files for Upload
                    .jpg</font></h2>
        </div>


    </center>

    <form method="POST" enctype="multipart/form-data" action="{{ URL('/SaveAttachment')}}">

    @csrf

    <table class="table m-0 show_table" style="width:auto!important;">
        <input type="hidden" name="id" value="{{$Driver->id}}">
        <tr>
            <?php if (isset($drivers_attachments->Image_Identity) && $drivers_attachments->Image_Identity == '1') $img = 'correct'; else $img = 'wrong';?>
            <td><img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px"></td>
            <TH>Image Identity(Iqama)  (الاقامة او الهوية الوطنية)</TH>
            <td style="padding: 0.0rem 1.0rem !important;">
                <?php if(isset($drivers_attachments->Image_Identity) && $drivers_attachments->Image_Identity == '1'){
                ?>
                &nbsp;<a
                    href="javascript:view_attach('Image_Identity');"
                    data-original-title="view" data-toggle="tooltip" data-placement="top"
                    class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                <a
                    href="javascript:delete_attach('Image_Identity');"
                    data-original-title="delete" data-toggle="tooltip" data-placement="top"
                    class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>
                <?php
                }
                ?>
            </td>
            <td><input type="file" name="Image_Identity" id="Image_Identity"/></td>
        </tr>
        <tr>
            <?php if (isset($drivers_attachments->Image_Passport) && $drivers_attachments->Image_Passport == '1') $img = 'correct'; else $img = 'wrong';?>
            <td><img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px"></td>
            <TH>Image Passport (جواز السفر)</TH>
            <td style="padding: 0.0rem 1.0rem !important;">
                <?php if(isset($drivers_attachments->Image_Passport) && $drivers_attachments->Image_Passport == '1'){
                ?>
                &nbsp;<a
                    href="javascript:view_attach('Image_Passport');"
                    data-original-title="view" data-toggle="tooltip" data-placement="top"
                    class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                    <a
                        href="javascript:delete_attach('Image_Passport');"
                        data-original-title="delete" data-toggle="tooltip" data-placement="top"
                        class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>
                <?php
                }
                ?>
            </td>
            <td><input type="file" name="Image_Passport" id="Image_Passport"/></td>
        </tr>
        <tr>
            <?php if (isset($drivers_attachments->Image_DrivingLicence) && $drivers_attachments->Image_DrivingLicence == '1') $img = 'correct'; else $img = 'wrong';?>
            <td><img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px"></td>
            <TH>Image Driving Licence (رخصة القيادة)</TH>
            <td style="padding: 0.0rem 1.0rem !important;">
                <?php if(isset($drivers_attachments->Image_DrivingLicence) && $drivers_attachments->Image_DrivingLicence == '1'){
                ?>
                &nbsp;<a
                    href="javascript:view_attach('Image_DrivingLicence');"
                    data-original-title="view" data-toggle="tooltip" data-placement="top"
                    class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                    <a
                        href="javascript:delete_attach('Image_DrivingLicence');"
                        data-original-title="delete" data-toggle="tooltip" data-placement="top"
                        class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>
                <?php
                }
                ?>
            </td>
            <td><input type="file" name="Image_DrivingLicence" id="Image_DrivingLicence"/></td>
        </tr>
        <tr>
            <?php if (isset($drivers_attachments->Image_VehiclesRegistration) && $drivers_attachments->Image_VehiclesRegistration == '1') $img = 'correct'; else $img = 'wrong';?>
            <td><img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px"></td>
            <TH>Image Vehicles Registration (استمارة السير)</TH>
            <td style="padding: 0.0rem 1.0rem !important;">
                <?php if(isset($drivers_attachments->Image_VehiclesRegistration) && $drivers_attachments->Image_VehiclesRegistration == '1'){
                ?>
                &nbsp;<a
                    href="javascript:view_attach('Image_VehiclesRegistration');"
                    data-original-title="view" data-toggle="tooltip" data-placement="top"
                    class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                    <a
                        href="javascript:delete_attach('Image_VehiclesRegistration');"
                        data-original-title="delete" data-toggle="tooltip" data-placement="top"
                        class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>
                <?php
                }
                ?>
            </td>
            <td><input type="file" name="Image_VehiclesRegistration" id="Image_VehiclesRegistration"/></td>
        </tr>
        <tr>
            <?php if (isset($drivers_attachments->Image_JobContract) && $drivers_attachments->Image_JobContract == '1') $img = 'correct'; else $img = 'wrong';?>
            <td><img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px"></td>
            <TH>Image Job Contract (عقد العمل)</TH>
            <td style="padding: 0.0rem 1.0rem !important;">
                <?php if(isset($drivers_attachments->Image_JobContract) && $drivers_attachments->Image_JobContract == '1'){
                ?>
                &nbsp;<a
                    href="javascript:view_attach('Image_JobContract');"
                    data-original-title="view" data-toggle="tooltip" data-placement="top"
                    class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                    <a
                        href="javascript:delete_attach('Image_JobContract');"
                        data-original-title="delete" data-toggle="tooltip" data-placement="top"
                        class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>
                <?php
                }
                ?>
            </td>
            <td><input type="file" name="Image_JobContract" id="Image_JobContract"/></td>
        </tr>
        <tr>
            <?php if (isset($drivers_attachments->Image_PromissoryNote) && $drivers_attachments->Image_PromissoryNote == '1') $img = 'correct'; else $img = 'wrong';?>
            <td><img src="{{asset("/AdminLTE/img/".$img.".png")}}" style="height:20px;width:20px"></td>
            <TH>Image Promissory Note (سند الامر)</TH>
            <td style="padding: 0.0rem 1.0rem !important;">
                <?php if(isset($drivers_attachments->Image_PromissoryNote) && $drivers_attachments->Image_PromissoryNote == '1'){
                ?>
                &nbsp;<a
                    href="javascript:view_attach('Image_PromissoryNote');"
                    data-original-title="view" data-toggle="tooltip" data-placement="top"
                    class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>
                    <a
                        href="javascript:delete_attach('Image_PromissoryNote');"
                        data-original-title="delete" data-toggle="tooltip" data-placement="top"
                        class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>
                <?php
                }
                ?>
            </td>
            <td><input type="file" name="Image_PromissoryNote" id="Image_PromissoryNote"/></td>
        </tr>
    </table>
    <div class="w3-row">
        <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Save Attachments</button>
    </div>
    </form>
    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button
            onclick="window.close();"
            type="button" class="w3-btn w3-red">Cancel
        </button>
    </div>
</div>
<script>
    function view_attach(name) {
        myWindow1 = window.open("{{URL("/Attachment")}}" + "/" + name + "/" + {{$Driver->id}} + ".jpg", "mywin2",
            "height=900,width=800,scrollbars=yes,top=1,left=1,status,resizable");
        myWindow1.focus();
    }

    function delete_attach(name) {

        document.getElementById('response').innerHTML = loader;
        // document.getElementById('edit_modal').style.display = 'block';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
         $.ajax({
             type: 'GET',
             url: "{{URL("/DeleteAttachment")}}" + "/" + name + "/" + {{$Driver->id}},
            contentType: "html",
            dataType: 'html',
            success: function (data) {

                document.getElementById('response').innerHTML = data;
            }
        });


    }
</script>

<!-- ./wrapper -->

<!-- jQuery 3 -->

<script src="{{asset("/AdminLTE/js/jquery.min.js")}}"></script>

<script src="{{asset("/AdminLTE/js/select2.full.min.js")}}"></script>
<!-- Bootstrap 3.3.7 -->

<script src="{{asset("/AdminLTE/js/bootstrap.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("/AdminLTE/moment/min/moment.min.js")}}"></script>
<script src="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.js")}}"></script>

<script src="{{asset("/AdminLTE/js/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/AdminLTE/js/dataTables.bootstrap.min.js")}}"></script>
<!-- FastClick -->
<script src="{{asset("/AdminLTE/js/fastclick.js")}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset("/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("/AdminLTE/js/adminlte.min.js")}}"></script>


