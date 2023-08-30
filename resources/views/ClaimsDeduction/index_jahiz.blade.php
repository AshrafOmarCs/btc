@extends('AdminLTE')
@section('content')  
<link rel="stylesheet" href="{{asset('dropAndDrag/src/style.css')}}">


    <style>
        th{
            /* background-color: #d4c8b8; */
        }
        td{
            /* box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; */
            border: 1px solid white;
        }
        .card1 {
          box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
          transition: 0.3s;
          width: 98%;
          margin-top: 150px;
          margin-left: 13px;
          background-color: white;
          overflow-x: auto; 
        }
        .card1:hover {
          box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
    </style>
    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;">
            <h2 style="width:100%;font-size: 14px;font-weight: bold;">Jahiz Sync Claims</h2>
            <p class="card-text">By this module you can synchronize data of each driver by selecting a specific city.</p>
        </div>
    </div>
    <!-- end of header -->
    <div class="card card-default" style="width:100%;clear:both;"></div>

        <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->
    <!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
                </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>
                        <TH>City</TH>
                        <td>
                            <select name="filter_cityId" id="filter_cityId"
                                    class="form-control" style="width:200px;" required>
                                <option value=""></option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->warehouseName }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-info" onclick="confirmSearch()">Filter</button>

                    <button type="button" name="reset" id="reset" class="btn btn-sm btn-default" onclick="reset_records()">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->

    <!--<div id="" class="box box-primary box box-primary">-->
    <!--    <div id="box-body1" class="box-body1 table-responsive">-->
    <!--        <div class="table-responsive" style="width: 100%;">-->
    <div class="card1">
        <div style="width:100%;clear:both;" id="response">
    
        </div>
        <div style="width:95%;clear:both; display: none" id="data">
            <table class="table m-0" style="width:10px!important;">
                <tr>
                    <TH>URL1</TH>
                    <td>
                        <input name="url1" id="url1" type="url"
                                class="form-control" style="width:200px;" required>
                    </td>
                    <TH>URL2</TH>
                    <td>
                        <input name="url2" id="url2" type="url"
                                class="form-control" style="width:200px;" required>
                    </td>
                    <TH>Cookie</TH>
                    <td>
                        <input name="cookie" id="cookie"
                                class="form-control" style="width:200px;" required>
                    </td>
                </tr>
            </table>
            
            <div class="row">
                <div class="col-md-12" id="buttons_div"></div>
                
            </div>
            
            <div class="row">
                <div class="col-md-12" id="drivers_table_div"></div>

            </div>

        </div>
    </div>
    
    <div id="sync_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:850px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('sync_modal').style.display='none'"
                    class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                    title="Close Modal">&times;
                </span>
            </div>
            <div style="width:100%;clear:both;" id="response1">
    
            </div>
            @include('pages.messages2')
            <div class="row sync_table">
                <div class="col-lg-6">
                    <h4>Jahiz Drivers Syncronization</h4>
                </div>
            </div>
            <table id="customer_data" class="table table-bordered table-striped table-responsive sync_table">
                <thead>
                    <TH>Sr. No</TH>
                    <TH >AMP/Job ID</TH>
                    <TH >Driver</TH>
                    <TH >Last Settlement Date</TH>
                    <TH >Current Amount</TH>
                    <TH >Claims Amount</TH>
                </thead>
                <tbody id="sync_body">
                   
                    
                </tbody>
            </table>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button
                    onclick="document.getElementById('response').innerHTML='';document.getElementById('sync_modal').style.display='none'"
                    type="button" class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
        


    <script>
       function isValidHttpUrl(string) {
          let url;
          try {
            url = new URL(string);
          } catch (_) {
            return false;  
          }
          return url.protocol === "http:" || url.protocol === "https:";
        }
        function show_drivers(city_id, start, end) {
 
            if($('#url1').val() == '' || $('#url2').val() == '' || $('#cookie').val() == ''){ 
                alert('URL1, URL2 and Cookie can not Be Empty');
            } else if (isValidHttpUrl($('#url1').val()))
            {
                $('.sync_table').hide();
                document.getElementById('sync_modal').style.display = 'block';
                $("#response1").show();
                document.getElementById('response1').innerHTML = loader;
                var filter_url1 = filter_url2 = filter_cookie = '';
                filter_url1 = $('#url1').val();
                filter_url2 = $('#url2').val();
                filter_cookie = $('#cookie').val();
                var url = '{{url('ClaimsDeduction/SyncJahiz/SearchDrivers')}}';                
                var postData = {
                    url1: filter_url1,
                    url2: filter_url2,
                    filter_cookie: filter_cookie,
                    warehouse_id: city_id,
                    start: start,
                    end: end,
                    
                    _token: "{{ csrf_token() }}",
                };

                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (data) { 
                        $('.sync_table').show();
                        data = data.split(":::");
                        $("#sync_body").html(data[0]);
                        $("#buttons_div").html(data[1]);
                        $("#response1").hide();
                    },
                    error: function (jqXHR, status, error) {
                        alert(status + ": " + error);
                    }
                }); 
            } else {
                alert('URL1 is not correct. It should start with http or https');
            }
        }
        function card_change() {
            if (document.getElementById('card_box').className == "box box-primary") {
                document.getElementById('card_box').className = "box box-primary collapsed-box";
                document.getElementById('i_box').className = "fa fa-plus";
                document.getElementById('box-body').style.display = 'none';
            } else {
                document.getElementById('card_box').className = "box box-primary";
                document.getElementById('i_box').className = "fa fa-minus";
                document.getElementById('box-body').style.display = '';
            }
        }
        
        
        function confirmSearch(){ 
            if($('#filter_cityId').val() == ''){ 
                alert('City can not Be Empty');
            }else{
                var filter_cityId = '';
                filter_cityId = $('#filter_cityId').val();
                $("#response").show();
                $("#data").hide();
                document.getElementById('response').innerHTML = loader;
                let url = '{{url('ClaimsDeduction/SyncJahiz/Search')}}';
                var postData = {
                    filter_cityId: filter_cityId,
                    
                    _token: "{{ csrf_token() }}",
                }; 
                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (data) { 
                        $("#buttons_div").html(data);
                        $("#drivers_table_div").html('');
                        $('#url1').val('');
                        $('#url2').val('');
                        $('#cookie').val('');
                        $("#response").hide();
                        $("#data").show();
                    },
                    error: function (jqXHR, status, error) {
                        alert(status + ": " + error);
                    }
                }); 
            }
        }
        
        function reset_records() {
            $('#filter_cityId').val('');
            
        }
        
    </script>
@endsection