@extends('layout2')
@section('content')
@section('title', 'System Logs')
<style>
    .daterangepicker {
        top: 0 !important;
    }
</style>
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
                                            <label for="country" class="form-label">Type </label>
                                            <select class="form-control" name="filter_type" id="filter_type">
                                                <option>Select Type</option>
                                                <option value="accountNumber:">STC account update</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Text </label>
                                            <input type="text" class="form-control" name="filter_text" id="filter_text">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <label for="country" class="form-label">Created Between</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar4"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-range" id="filter_done_at" name="filter_done_at">
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
                <div class="card-title">System Logs</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;"> </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>

                                {{-- <button type="button" class="btn btn-success" class="btn btn-info" data-bs-toggle="modal" type="button" onclick="export_excel()" data-bs-target="#ExportExcel"></i>{{__('drivers.ExportExcel')}}</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <th style="">Sr. No</th>
                                <th style="">Process</th>
                                <th style="">Ids</th>
                                <th style="">Done by</th>
                                <th style="">Done At</th>
                                <th style="">Action</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th style="">Sr. No</th>
                                <th style="">Process</th>
                                <th style="">Ids</th>
                                <th style="">Done by</th>
                                <th style="">Done At</th>
                                <th style="">Action</th>
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
        $(document).ready(function () {
            $('#filter_done_at').val('');
            // Clear the input when the cancel button is clicked
            $('#filter_done_at').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            var counter = 0;
            fill_datatable();
            function fill_datatable(filter_type = '', filter_text = '', filter_done_at = '') {
                var dataTable = $('#customer_data').DataTable({
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    dom: 'lBfrtip',
                    "buttons": [
                        {
                            extend: 'excel',
                            text: 'Export to Excel',
                            exportOptions: {
                                modifier: {
                                    search: 'applied',
                                    order: 'applied'
                                }
                            }
                        },
                        // {
                        //     extend: 'pdf', // Add PDF export button
                        //     text: 'Export to PDF',
                        //     exportOptions: {
                        //         modifier: {
                        //             search: 'applied',
                        //             order: 'applied'
                        //         }
                        //     }
                        // }
                    ],
                    order: [[4, 'desc']],
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    ajax: {
                        url: "{{ route('Logs') }}",
                        data: {
                            filter_type: filter_type,
                            filter_text: filter_text,
                            filter_done_at: filter_done_at,
                        }
                    },
                    columns: [
                        {
                            orderable: false,
                            name: 'tbl_events_log.id',
                            data: 'id',
                            "render": function (data, type, row, meta) {
                                counter++
                                return counter
                            }
                        },
                        {
                            data: 'action',
                            name: 'tbl_events_log.action'
                        },
                        {
                            data: 'decoded_loan_ids',
                            name: 'tbl_events_log.loan_ids'
                        },
                        {
                            data: 'name',
                            name: 'users.name'
                        },
                        {
                            data: 'done_at',
                            name: 'tbl_events_log.done_at'
                        },
                        {
                            "render": function (data, type, row, meta) {
                                return ''
                            }
                        }
                    ]
                });
            }
            $('#filter').click(function () {
                if ($('#filter_type').val() != '' || $('#filter_text').val() != '' || $('#filter_done_at').val() != '') {
                    $('#customer_data').DataTable().destroy();
                    fill_datatable($('#filter_type').val(), $('#filter_text').val(), $('#filter_done_at').val());
                    let html = '';
                    if ($('#filter_type').val() != '')
                        html += '<button type="button" class="btn btn-outline-success btn-rounded">'+$('#filter_type option:selected').text()+'</button>';
                    if ($('#filter_text').val() != '')
                        html += '<button type="button" class="btn btn-outline-danger btn-rounded">'+$('#filter_text').val()+'</button>';
                    if ($('#filter_done_at').val() != '')
                        html += '<button type="button" class="btn btn-outline-info btn-rounded">'+$('#filter_done_at').val()+'</button>';
                    if(html != '') {
                        $('#edit_btn').show();
                        $('#selectedCriteria').html(html);
                    } else {
                        $('#edit_btn').hide();
                    }
                } else {
                    alert('Select filter option');
                }
            });
            $('#reset').click(function () {
                $('#filter_type').val('');
                $('#filter_text').val('');
                $('#filter_done_at').val('');
                $('#customer_data').DataTable().destroy();
                fill_datatable();
            });
        });

        function delete_record(id)
        {
            document.getElementById('delete_form').action = "{{URL('/Logs/delete')}}" + "/" + id;
            document.getElementById('delete_modal').style.display = 'block';
        }
    </script>
@stop
@endsection
