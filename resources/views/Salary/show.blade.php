
<!-- <link href="http://localhost/mashaueer_noon/resources/layout/styles/layout.css " rel="stylesheet" type="text/css" media="all">
-->
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <title>Admin - Almashwar</title>
    <!-- <meta charset="utf-8"> -->
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset="utf-8">
    <META HTTP-EQUIV="Content-language" CONTENT="ar">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- <link href="http://localhost/mashaueer_noon/resources/ " rel="stylesheet" type="text/css" media="all"> -->
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset("/AdminLTE/css/bootstrap.min.css")}}">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset("/AdminLTE/font-awesome/font-awesome.min.css")}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset("/AdminLTE/css/ionicons.min.css")}}">

        <!-- daterange picker -->
        <link rel="stylesheet" href="{{asset("/AdminLTE/bootstrap-daterangepicker/daterangepicker.css")}}">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet"
              href="{{asset("/AdminLTE/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")}}">
        <!-- Theme style -->
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="{{asset("/AdminLTE/plugins/iCheck/all.css")}}">
        <link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{asset("/AdminLTE/css/_all-skins.min.css")}}">
        <link rel="stylesheet" href="{{asset("/AdminLTE/css/dataTables.bootstrap.min.css")}}">
        <!--<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <link rel="stylesheet" href="{{asset("/AdminLTE/css/w3.css")}}">
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{asset("/AdminLTE/css/AdminLTE.css")}}">
        <link rel="stylesheet" href="{{asset("/AdminLTE/css/customize.css")}}">
</head>
    <style>
        .show_table_1 th {
            padding: 0.0rem 0.3rem !important;
            border:solid 1px !important;
            margin:0!important;
        }
        .show_table_1 td {
           padding: 0.0rem 0.3rem !important;
           border:solid 1px !important;
        }
    </style>
    <center>
        <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;font-size: 14px;font-weight: bold;">
            {{$company->companyName}}  -  {{$company->warehouseName}}   -   {{$company->fullName}}
        </div>
        <div>
            <b>
                <font color="red">
                    {{$company->amount}}
                </font>
             </b>
         </div>
        <div>
            <b>
                <font color="red">
                    {{$from}}  -  {{$to}}
                </font>
            </b>
        </div>

        <table class="table m-0 show_table_1" style="">
            <tr>
                <TH>Date</TH>
                <TH>DayName</TH>
                <TH style="width: 100px !important">Journal_Type</TH>
                <TH>Create By</TH>
                @if ($company->calculation_method_id==2)
                <TH>No_Of_Deliverd</TH>
                 @endif
                @if ($company->calculation_method_id==1)
                <TH>No_Of_TP</TH>
                @endif
                <TH>Unit_Cost</TH>
                <TH>Credit</TH>
                <TH>Debit</TH>
                <TH>Brought_Down</TH>
            </tr>
        
            <?php $t_days = $t_credit = $t_debit = $carried_down = $no_of_touch_point = 0;?>
        
        
            @foreach($qq as $q)
                <?php $carried_down+=$q->Carried_Down;
                    $no_of_touch_point+=$q->no_of_touch_point;
                    $note = '';
                    $t_credit += round($q->credit, 2);
                    $t_debit += round($q->debit, 2);
                    if($q->journal_type == 'Daily Load') {
                        $t_days++;
                    } else if($q->journal_type != '' AND $q->note != '') {
                        $note = " (".$q->note.")
                        <a onclick=\"show_record('".$q->post_id."', '".$q->journal_type."')\" id='".$q->post_id."' data-original-title='view' data-toggle='tooltip' data-placement='top' class='btnaction btn menu-icon vd_bd-green vd_green view'> <i class='fa fa-eye'></i> </a>
                        ";
                    }
                ?>
                <tr>
                    <td>{{$q->date}}</td>
                    <td>{{$q->dayname}}</td>
                    <td style="width: 100px !important">
                        @php echo $q->journal_type . $note;@endphp
                    </td>
                    <td>
                        {{$q->created_by}}
                    </td>
                    @if ($company->calculation_method_id==2)
                    <td>{{$q->no_of_deliverd}}</td>
                     @endif
                    @if ($company->calculation_method_id==1)
                    <td>{{$q->no_of_touch_point}}</td>
                    @endif
                    <td><?php if (isset($q->unit_cost)) echo floatval($q->unit_cost);else echo ""; ?></td>
                    <td><?php if (isset($q->credit)) echo floatval($q->credit);else echo ""; ?></td>
                    <td><?php if (isset($q->debit)) echo floatval($q->debit);else echo ""; ?></td>
                    <td>{{$carried_down +0}}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan=4>Month Balance</th>
                <th>{{$no_of_touch_point+0}}</th>
                <th></th>
                <th>{{$t_credit}}</th>
                <th>{{$t_debit}}</th>
                <th>{{$carried_down+0}}</th>
            </tr>
            <tr>
                <th colspan=8>Carried Down</th>
                <th>{{$Carried_Down->carried_down+0}}</th>
            </tr>
            <tr>
                <th colspan=8>Brought Down</th>
                <th>{{$Carried_Down->carried_down+$carried_down+0}}</th>
            </tr>
            <tr>
                <th colspan=8>T.Days</th>
                <th>{{$t_days}}</th>
            </tr>
        </table>

    </center>
<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
  <button onclick="if (document.getElementById('edit_modal')){document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'}else window.close();" type="button" class="w3-btn w3-red">Close</button>
</div>
<div class="clearfx"></div>
<div id="view_modal" class="w3-modal" style="padding-top: 10px !important;">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:850px">
        <div class="w3-center"><br>
            <span onclick="document.getElementById('view_modal').style.display='none'"
                  class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                  title="Close Modal">&times;</span>
        </div>

        <div style="width:100%;clear:both;" id="responsee">

        </div>
        <br>
        <br>
    </div>
</div>
<script>
    function show_record(id, type) {
        document.getElementById('responsee').innerHTML = "Loading...";
        document.getElementById('view_modal').style.display = 'block';
        let urls = '';
        if(type == 'Loan')
         urls = "https://btcdmins.com/Loans" + "/" + id;
        if(type == 'Credit Note')
         urls = "https://btcdmins.com/CreditNotes" + "/" + id;
        $.ajax({
            type: 'GET',
            url: urls,
            contentType: "html",
            dataType: 'html',
            success: function (data) {

                document.getElementById('responsee').innerHTML = data;

            }
        });
    }
    

</script>
