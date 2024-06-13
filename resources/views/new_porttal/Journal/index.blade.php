@extends('layout2')
@section('content')
@section('title', __('journal.journal'))

<!-- Modal ExportExcel 3 -->
<div class="modal fade" id="FillterButton" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.Filter')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Card start -->
                        <div class="card">
                            <div class="card-body">
                                <!-- Row start -->
                                <div class="row">
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('journal.CompanyName')}} </label>
                                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                                class="form-control" required>
                                                <option value=""></option>
                                                @foreach($lkp_company as $lkpcompany)
                                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('journal.WarehouseName')}} </label>
                                            <select  id="filter_warehouseId" name="filter_warehouseId"   class="form-control">
                                                <option value=""></option>
                                                @foreach($warehouse as $warehousee)
                                                    <option value="{{$warehousee->id}}" >{{$warehousee->warehouseName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('journal.EMPID')}} </label>
                                            <input type="text" class="form-control" name="filter_job_id" id="filter_job_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('journal.Driver')}} </label>
                                            <input name="filter_driverId" id="filter_driverId" type="hidden"  >
                                            <table style="padding: 0px 0px; !important;"><tr><td>
                                            <input  class="form-control" name="filter_driverId_input" id="filter_driverId_input" type="text"     data-readonly>
                                            </td><td><button onclick="driver_window();" type="button" class="btn btn-primary btn-xs" >{{__('journal.Select')}}</button>
                                            </td></tr></table>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('journal.Debit')}} </label>
                                            <input  type="text" class="form-control" name="filter_debit" id="filter_debit"   >
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('journal.Credit')}} </label>
                                            <input  type="text" class="form-control" name="filter_credit" id="filter_credit">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('journal.JournalDate')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_journal_date" name="filter_journal_date">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">{{__('journal.Note')}} </label>
                                            <input  type="text" class="form-control" name="filter_note" id="filter_note">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Type </label>
                                            <select id="filter_journal_type_id" name="filter_journal_type_id" class="form-control" >
                                                <option ></option>
                                                @foreach($lkp_journal_type as $lkp_journal_typee)
                                                    <option value="{{$lkp_journal_typee->id}}" >{{$lkp_journal_typee->journal_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Created_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_created_at" name="filter_created_at">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">{{__('drivers.Updated_At')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_updated_at" name="filter_updated_at">
                                        </div>
                                    </div>


                                </div>
                                <!-- Row end -->

                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="reset" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                <button type="button" class="btn btn-success"
                    data-bs-dismiss="modal" id="filter">{{__('drivers.Search')}}</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <span id="response">
            </span>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('drivers.driver')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="modal-body">
                    <p>{{__('drivers.Delete_msg')}} <span id="delete_name"></span> ?</p>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('drivers.Close')}}</button>
                      <button class="btn btn-danger" type="submit">{{__('drivers.Delete')}}</button>
                  </div>
              </form>
        </div>
    </div>
</div>
<!--End Modal ExportExcel 3 -->

 <!-- Row start -->
 <div class="row">
    @include('new_porttal.partials.edit_btn')
</div>

<div class="row">
    <div class="col-sm-12 col-12">
        <div id="message"></div>
        <!-- Card start -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('journal.journal')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;"> </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                {{-- <button type="button" class="btn btn-primary" type="button" onclick="apply();"></i>Apply for Settlement</button> --}}

                                {{-- <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div id="loader" style="display:none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <TH>{{__('journal.Company')}}</TH>
                                <TH>{{__('journal.Warehouse')}}</TH>
                                <TH>{{__('journal.EMPID')}}</TH>
                                <TH>{{__('journal.Driver')}}</TH>
                                <TH>{{__('journal.JournalDate')}}</TH>
                                <TH>{{__('journal.Debit')}}</TH>
                                <TH>{{__('journal.Credit')}}</TH>
                                <TH>{{__('journal.Note')}}</TH>
                                <TH>{{__('journal.Type')}}</TH>
                                <TH>{{__('journal.CreatedAt')}}</TH>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <TH colspan='5'>{{__('journal.Total')}}</TH>
                                    <TH></TH>
                                    <TH></TH>
                                    <TH colspan='3'></TH>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Card end -->
            </div>
        <!-- Card end -->
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <script>
        $(document).ready(function(){
            $(document).ajaxStart(function() {
                $("#loader").show();
            });
            $(document).ajaxStop(function() {
                $("#loader").hide();
            });

            $('#filter_updated_at').val('');
            $('#filter_created_at').val('');
            $('#filter_journal_date').val('');

            // Clear the input when the cancel button is clicked
            $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_updated_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#filter_journal_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            fill_datatable();
            function fill_datatable(filter_companyId='',filter_warehouseId='',filter_job_id='',filter_driverId='',filter_journal_date='',filter_debit='',filter_credit='',filter_note='',filter_journal_type_id='',filter_created_at='',filter_updated_at='')
            {
                var dataTable = $('#customer_data').DataTable({
                   //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "order": [[ 4, "desc" ]],
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "drawCallback": function( settings ) {
                    $('[data-toggle="tooltip"]').tooltip();
                        var api = this.api()
                        var json = api.ajax.json();

                        $(api.column(5).footer()).html(json.debit);
                        $(api.column(6).footer()).html(json.credit);

                    },
                    ajax:{
                        url: "{{ route('Journal.index') }}",
                        data:{
                            filter_companyId:filter_companyId,
                            filter_warehouseId:filter_warehouseId,
                            filter_job_id:filter_job_id,
                            filter_driverId:filter_driverId,
                            filter_journal_date:filter_journal_date,
                            filter_debit:filter_debit,
                            filter_credit:filter_credit,
                            filter_note:filter_note,
                            filter_journal_type_id:filter_journal_type_id,
                            filter_created_at:filter_created_at,
                            filter_updated_at:filter_updated_at,
                        }
                    },
                    columns: [

                          {
                            data:'companyName',
                            name:'lkp_company.companyName',
                            //visible:false
                        },
                         {
                            data:'warehouseName',
                            name:'warehouse.warehouseName',
                            //visible:false
                        },
                        {
                            data:'job_id',
                            name:'drivers.job_id'
                        },
                        {
                            data:'fullName',
                            name:'drivers.fullName',
                            render: function(data, type, row, meta) {
                              return '<a href="javascript:driver('+row.driverId+')">'+data+'</a>';
                            }

                        },
                        {
                            data:'journal_date',
                            name:'journal_date'
                        },
                        {
                            data:'debit',
                            name:'debit'
                        },
                        {
                            data:'credit',
                            name:'credit'
                        },
                        {
                            data:'note',
                            name:'note'
                        },
                        {
                            data:'journal_type',
                            name:'lkp_journal_type.journal_type'
                        },
                        {
                            data:'created_at',
                            name:'journal.created_at'
                        },

                    ]
                });
            }
        $('#customer_data tbody').on( 'click', '.view', function (e) {
            e.preventDefault();
            // document.getElementById('response').innerHTML=loader;
            document.getElementById('edit_modal').style.display='block';
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                 url: "{{URL('/Journal')}}"+"/"+id,
                 contentType: "html",
                 dataType : 'html',
                 success: function (data) {

                 document.getElementById('response').innerHTML=data;

                }
            });
        });

        $('#filter').click(function(){
              if($('#filter_companyId').val() !=''||$('#filter_warehouseId').val() !=''||$('#filter_job_id').val() !=''||$('#filter_driverId').val() !=''||$('#filter_journal_date').val() !=''||$('#filter_debit').val() !=''||$('#filter_credit').val() !=''||$('#filter_note').val() !=''||$('#filter_journal_type_id').val() !=''||$('#filter_created_at').val() !=''||$('#filter_updated_at').val() !='')
                {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_companyId').val(),$('#filter_warehouseId').val(),$('#filter_job_id').val(),$('#filter_driverId').val(),$('#filter_journal_date').val(),$('#filter_debit').val(),$('#filter_credit').val(),$('#filter_note').val(),$('#filter_journal_type_id').val(),$('#filter_created_at').val(),$('#filter_updated_at').val());
                    let html = '';
                    if ($('#filter_companyId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_companyId option:selected').text()+'</button>';
                    if ($('#filter_warehouseId').val() > 0)
                        html += '<button type="button" class="btn btn-outline-secondary btn-rounded">'+$('#filter_warehouseId option:selected').text()+'</button>';
                    if ($('#filter_job_id').val() != '')
                        html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_job_id').val()+'</button>';
                    if ($('#filter_driverId').val() != '')
                        html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_driverId').val()+'</button>';
                    if ($('#filter_debit').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Debit: '+$('#filter_debit').val()+'</button>';
                    if ($('#filter_credit').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Credit: '+$('#filter_credit').val()+'</button>';
                    if ($('#filter_journal_date').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Journal Date: '+$('#filter_journal_date').val()+'</button>';
                    if ($('#filter_note').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_note').val()+'</button>';
                    if ($('#filter_journal_type_id').val() > 0)
                        html += '<button type="button" class="btn btn-outline-primary btn-rounded">'+$('#filter_journal_type_id option:selected').text()+'</button>';

                    if ($('#filter_created_at').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Created at: '+$('#filter_created_at').val()+'</button>';
                    if ($('#filter_updated_at').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">Updated at: '+$('#filter_updated_at').val()+'</button>';
                    if(html != '') {
                        $('#edit_btn').show();
                        $('#selectedCriteria').html(html);
                    } else {
                        $('#edit_btn').hide();
                    }
                }
                else
                {
                    alert('Select filter option');
                }
            });

            $('#reset').click(function(){

               $('#filter_companyId').val('');
                $('#filter_warehouseId').val('');
                $('#filter_job_id').val('');
                $('#filter_driverId').val('');
                $('#filter_driverId_input').val('');
                $('#filter_journal_date').val('');
                $('#filter_debit').val('');
                $('#filter_credit').val('');
                $('#filter_note').val('');
                $('#filter_journal_type_id').val('');
                $('#filter_created_at').val('');
                $('#filter_updated_at').val('');
                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });
        });

        function status()
        {
          var status_id=document.getElementById('status_id').value;
          if (status_id=="3")
          document.getElementById("Termination_Reason").style.display = '';
          else
          document.getElementById("Termination_Reason").style.display = 'none';
        }

        function driver_window(){
          $('#filter_vehichleId').val('');
          $('#filter_vehichleId_input').val('');
         myWindow1 = window.open( "{{URL("/DriverWindow")}}", "",
                                  "height=650,width=1000,scrollbars=yes,top=1,left=1,status,resizable" );
        }
        function driver(id){
        //   document.getElementById('response').innerHTML=loader;
        //   document.getElementById('edit_modal').style.display='block';
          $('#edit_modal').modal('toggle');
          $.ajax({
                type: 'GET',
                 url: "{{URL("/Drivers")}}"+"/"+id,
                 contentType: "html",
                 dataType : 'html',
                 success: function (data) {

                 document.getElementById('response').innerHTML=data;

                }
            });
        }
        function WarehouseName() {

          var filter_companyId = document.getElementById('filter_companyId').value;
          if (filter_companyId == "")
              $('#filter_warehouseId').empty();
          else {
              $.getJSON("{{URL("/getWarehouseName")}}" + "/" + filter_companyId, function (json) {
                  $('#filter_warehouseId').empty();
                  $('#filter_warehouseId').append($('<option>').text("Select ....").attr('value', ''));
                  $.each(json, function (i, obj) {
                      $('#filter_warehouseId').append($('<option>').text(obj.name).attr('value', obj.id));
                  });
              });
          }
        }
    </script>
@stop
@endsection
