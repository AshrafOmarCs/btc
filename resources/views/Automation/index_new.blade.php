@extends('AdminLTE')
@section('content')
@section('title', 'Actions')

    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Actions</h2>
        </div>
    </div>
    <div class="card card-default" style="width:100%;clear:both;"></div>
    <script>
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

    </script>
    <style>
        .card {
          box-shadow: 0 4px 8px 0 rgb(1 7 12 / 48%);
          width: 25%;
          margin: 1%;
          text-align: center;
          font-family: arial;
          display: inline-block;
        }
        
        .price {
          color: grey;
          font-size: 22px;
        }
        
        .card button {
          border: none;
          outline: 0;
          padding: 12px;
          color: white;
          background-color: black;
          text-align: center;
          cursor: pointer;
          width: 100%;
          font-size: 18px;
        }
        
        .card button:hover {
          opacity: 0.7;
        }
        
        
        .card1 {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 98%;
            padding: 1%;
            margin-left: 13px;
            background-color: white;
            overflow-x: auto;
        }
    </style>
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary ">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box" class="fa fa-plus"></i></button>-->
                </div>
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive" style="text-align: center;">
                <div class="card">
                  <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/pending-3699015-3080258.png?f=webp" style="width: 65px;height: 65px;">
                  <h1>Pending</h1>
                  <p class="price" id="pending"></p>
                  <p style="color: red">Oh! These actions needs your attention.</p>
                  <p><button onclick="change_table('pending_span')" class="pending_span" style="background-color: #429134">Action</button></p>
                </div>
                <div class="card">
                  <img src="https://static.thenounproject.com/png/1276358-200.png" style="width: 65px;height: 65px;">
                  <h1>Done</h1>
                  <p class="price" id="done"></p>
                  <p style="color: green">WoW! You are done with these actions.</p>
                  <p><button onclick="change_table('done_span')" class="done_span">Action</button></p>
                </div>
                
                <div class="card">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQUGA2m0XV_P1NMdmG3NsoQ41m25Hm21KlDOA146XuBw&s" style="width: 65px;height: 65px;">
                  <h1>Total</h1>
                  <p class="price" id="total"></p>
                  <p style="color: #00a65a">These are total actions.</p>
                  <p><button onclick="change_table('total_span')" class="total_span">Action</button></p>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->

    <div class="card1">
        <div style="width: 100%; clear: both; margin-top: 100px; margin-bottom: 100px; display: none;" id="response">
            <center>
                <img src="/AdminLTE/img/ajaxloader.gif" width="80" height="80" alt="Loading...">
            </center>
        </div>
        <div id="data">
            <span id="pending_span">
                <table id="pending_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <TH style="background-color: #7CCBDC;">Sr. No</TH>
                            <TH style="background-color: #7CCBDC;">Warehouse(s)</TH>
                            <TH style="background-color: #7CCBDC;">Module</TH>
                            <TH style="background-color: #7CCBDC;">Period</TH>
                            <TH style="background-color: #7CCBDC;">Proof File</TH>
                            <TH style="background-color: #7CCBDC;">Created by</TH>
                            <TH style="background-color: #7CCBDC;">Created at</TH>
                            <TH style="background-color: #7CCBDC;">Action</TH>
                        </tr>
                    </thead>
                    <tbody>
                        @php $j = 0; @endphp
                        @foreach($actions as $action)
                            <tr>
                                <td>{{++$j}}</td>
                                <td>{{$action->warehouse}}</td>
                                <td>{{$action->module}} for <b>{{$action->total}}</b> SAR</td>
                                <td>{{$action->period}}</td>
                                <td><a target="_blank" href="https://btcdmins.com/storage/paid/saned/{{$action->prof_file}}"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a></td>
                                <td>{{$action->name}}</td>
                                <td>{{$action->created_at}}</td>
                                <td>
                                    <label style="cursor: pointer" class="label label-success" for="accept" onclick="accept_modal({{$action->id}})">Accept</label> | 
                                    <label style="cursor: pointer" class="label label-danger" for="reject" onclick="reject_modal({{$action->id}})">Reject</label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </span>
            <span id="done_span" style="display: none">
                <table id="done_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <TH style="background-color: #7CCBDC;">Sr. No</TH>
                            <TH style="background-color: #7CCBDC;">Warehouse(s)</TH>
                            <TH style="background-color: #7CCBDC;">Module</TH>
                            <TH style="background-color: #7CCBDC;">Period</TH>
                            <TH style="background-color: #7CCBDC;">Proof File</TH>
                            <TH style="background-color: #7CCBDC;">Created by</TH>
                            <TH style="background-color: #7CCBDC;">Created at</TH>
                            <TH style="background-color: #7CCBDC;">Action</TH>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($actions as $action)
                            @if($action->status != 1)
                                @continue;
                            @endif
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$action->warehouse}}</td>
                                <td>{{$action->module}} for <b>{{$action->total}}</b> SAR</td>
                                <td>{{$action->period}}</td>
                                <td><a target="_blank" href="https://btcdmins.com/storage/paid/saned/{{$action->prof_file}}"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a></td>
                                <td>{{$action->name}}</td>
                                <td>{{$action->created_at}}</td>
                                <td>
                                    <label class="label label-success" for="accept">Done</label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </span>
            
            <span id="total_span" style="display: none">
                <table id="total_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <TH style="background-color: #7CCBDC;">Sr. No</TH>
                            <TH style="background-color: #7CCBDC;">Warehouse(s)</TH>
                            <TH style="background-color: #7CCBDC;">Module</TH>
                            <TH style="background-color: #7CCBDC;">Period</TH>
                            <TH style="background-color: #7CCBDC;">Proof File</TH>
                            <TH style="background-color: #7CCBDC;">Created by</TH>
                            <TH style="background-color: #7CCBDC;">Created at</TH>
                            <TH style="background-color: #7CCBDC;">Action</TH>
                        </tr>
                    </thead>
                    <tbody>
                        @php $k = 0; @endphp
                        @foreach($actions as $action)
                            <tr>
                                <td>{{++$k}}</td>
                                <td>{{$action->warehouse}}</td>
                                <td>{{$action->module}} for <b>{{$action->total}}</b> SAR</td>
                                <td>{{$action->period}}</td>
                                <td><a target="_blank" href="https://btcdmins.com/storage/paid/saned/{{$action->prof_file}}"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a></td>
                                <td>{{$action->name}}</td>
                                <td>{{$action->created_at}}</td>
                                <td>
                                    @if($action->status != 1)
                                        <label style="cursor: pointer" class="label label-success" for="accept" onclick="accept_modal({{$action->id}})">Accept</label> | 
                                        <label style="cursor: pointer" class="label label-danger" for="reject" onclick="reject_modal({{$action->id}})">Reject</label>
                                    @else
                                        <label class="label label-success" for="accept">Done</label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </span>
        </div>
    </div>
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>
            <div style="width:100%;clear:both;" id="responsee">

            </div>
            <br>
            <br>
        </div>
    </div>
    <div id="delete_modal" class="w3-modal">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('delete_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>
            <header class="w3-container w3-text-indigo w3-margin-top-64">
                <h1>Reject</h1>
            </header>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="w3-section">
                    <p>Are you sure, you want to Reject?</p>
                    <div class="w3-center">
                        <button type="submit" class="w3-btn w3-indigo"> Reject</button>
                    </div>
                </div>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('delete_modal').style.display='none'" type="button"
                        class="w3-btn w3-red">{{__('contractsQuotation.cancel')}}
                </button>
            </div>
        </div>
    </div>
    <script>
        function accept_modal(id) {
            document.getElementById('responsee').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/automation/get')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {
                        document.getElementById('responsee').innerHTML = data;
                        $('.show_table_data').DataTable({
                        	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                            dom: 'lBfrtip',
                            bAutoWidth: false, 
                            "buttons": [
                                {
                                    extend: 'excel',
                                    text: 'Export to Excel',
                                    exportOptions: {
                                        modifier: {
                                            search: 'applied',
                                            order: 'applied'
                                        }
                                    },
                                    
                                }
                            ],
                            responsive: true,
                            processing: true,
                            "pagingType": "full_numbers",
                            "autoWidth": false,
                        });
                    }
                });
        }
        function reject_modal(id) {
            document.getElementById('delete_form').action = "{{URL('/automation/reject')}}" + "/" + id;
            document.getElementById('delete_modal').style.display = 'block';
        }
        
        function change_table(type) {
            $('#data').hide();
            $('#response').show();
            setTimeout(function() {
                $('#response').hide();
                $('#data').show();
                $('.done_span').css('background-color', 'black');
                $('.pending_span').css('background-color', 'black');
                $('.total_span').css('background-color', 'black');
                $('.'+type).css('background-color', '#429134');
            }, 1000);
            $('#done_span').hide();
            $('#pending_span').hide();
            $('#total_span').hide();
            $('#'+type).show();
        }
         $(document).ready(function() {
            $('#done').html(<?=$i?>);
            $('#pending').html(<?=$j?>);
            $('#total').html(<?=$k?>);
            
    	    $('#done_data').DataTable({
    	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'lBfrtip',
                bAutoWidth: false, 
                
                "buttons": [
                    {
                        extend: 'excel',
                        text: 'Export to Excel',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        },
                        
                    }
                ],
                responsive: true,
                processing: true,
                "pagingType": "full_numbers",
                "autoWidth": false,
    	    });
    	    $('#pending_data').DataTable({
    	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'lBfrtip',
                bAutoWidth: false, 
                
                "buttons": [
                    {
                        extend: 'excel',
                        text: 'Export to Excel',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        },
                        
                    }
                ],
                responsive: true,
                processing: true,
                "pagingType": "full_numbers",
                "autoWidth": false,
    	    });
    	    $('#total_data').DataTable({
    	    	lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'lBfrtip',
                bAutoWidth: false, 
                
                "buttons": [
                    {
                        extend: 'excel',
                        text: 'Export to Excel',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied'
                            }
                        },
                        
                    }
                ],
                responsive: true,
                processing: true,
                "pagingType": "full_numbers",
                "autoWidth": false,
    	    });
         });
    </script>
@endsection

