@extends('layout2')
@section('content')
@section('title', __('documents.documents'))

<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('documents.documents')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;">{{__('documents.docx_description')}}</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                {{-- <button type="button" class="btn btn-light" class="btn btn-light" data-bs-toggle="modal" type="button" data-bs-target="#FillterButton"></i>{{__('drivers.Filter')}}</button>
                                <button type="button" class="btn btn-success" class="btn btn-info" type="button" onclick="export_excel()"></i>{{__('drivers.ExportExcel')}}</button> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <h6>{{__('documents.documents')}}</h6>
                    <div class="mt-3 table-responsive">
                        <table id="docx_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('documents.sr_no')}}</th>
                                    <th>{{__('documents.name')}}</th>
                                    <th>{{__('documents.download')}}</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                                @php $count = 0; @endphp
                                @foreach($contracts as $contract)
                                    <tr>
                                        <td>{{ ++$count }}</td>
                                        <td>{{ $contract->name }}</td>
                                        <td><a target="_blank" title="Download" href="/storage/images/{{ $contract->file_name }}"><i class="bi bi-cloud-download"></i></a></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <h6>Tutorials</h6>
                    <div class="table-responsive mt-3">
                        <table id="tutorial_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('documents.sr_no')}}</th>
                                    <th>{{__('documents.name')}}</th>
                                    <th>{{__('documents.download')}}</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                                @php $count = 0; @endphp
                                @foreach($tutorials as $tutorial)
                                    <tr>
                                        <td>{{ ++$count }}</td>
                                        <td>{{ $tutorial->name }}</td>
                                        <td><a target="_blank" title="Download" href="/storage/images/{{$tutorial->file_name}}"><i class="bi bi-cloud-download"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
        var dataTable = $('#docx_table').DataTable({
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
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
                }
            ],
            responsive: true,
            processing: true,
            // serverSide: true,
            "pagingType": "full_numbers",
            "autoWidth": false,
        });
        var dataTable2 = $('#tutorial_table').DataTable({
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
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
                }
            ],
            responsive: true,
            processing: true,
            // serverSide: true,
            "pagingType": "full_numbers",
            "autoWidth": false,
        });
    </script>
@stop
@endsection

