@extends('layout2')
@section('content')
@section('title', __('union.union_module'))

<div class="modal fade" id="edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{__('union.union')}} </h5>
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
                <h5 class="modal-title" id="staticBackdropLabel">{{__('union.union')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="modal-body">
                    <p>{{__('union.Delete_msg')}} <span id="delete_name"></span> ?</p>
                </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{__('union.cancel')}}</button>
                      <button class="btn btn-danger" type="submit">{{__('union.Delete')}}</button>
                  </div>
              </form>
        </div>
    </div>
</div>
<!--End Modal ExportExcel 3 -->


<div class="row">
    <div class="col-sm-12 col-12">
        <!-- Card start -->
        <div id="message"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{__('union.union_module')}}</div>
            </div>
            <!-- Card start -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 16px;"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-btn-group">
                                <button type="button" class="btn btn-info" class="btn btn-info" type="button" onclick="add()"></i>{{__('union.add_new')}}</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered">
                            <thead>
                                <tr>
                                    <TH>{{__('union.sr_no')}}</TH>
                                    <TH>{{__('union.name')}}</TH>
                                    <TH>{{__('union.description')}}</TH>
                                    <TH>{{__('union.link')}}</TH>
                                    <TH>{{__('union.action')}}</TH>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach($unions as $union)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>@php echo $union->name; @endphp</td>
                                        <td>@php echo $union->description; @endphp</td>
                                        <td>
                                            <a href="{{$union->link}}" data-original-title="open link" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                        <td>
                                           <a href="javascript:edit({{$union->id}});" data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow"> <i class="bi bi-pencil-square"></i> </a>
                                            &nbsp;<a href="javascript:delete_rocord({{$union->id}});" data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="bi bi-trash-fill"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <TH>{{__('union.sr_no')}}</TH>
                                    <TH>{{__('union.name')}}</TH>
                                    <TH>{{__('union.description')}}</TH>
                                    <TH>{{__('union.link')}}</TH>
                                    <TH>{{__('union.action')}}</TH>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Card end -->
        </div>
        <!-- Card end -->

    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
<input type="hidden" id="check" value="0">


@section('javascript')
    <!-- Main Js Required -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="https://btcdmins.com/AdminLTE/plugins/iCheck/icheck.min.js"></script>
    <script>
        $('#customer_data').DataTable({
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        });
        function add() {
            // document.getElementById('response').innerHTML = loader;
            $('#edit_modal').modal('toggle');
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Union/create")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                }
            });
        }
        function edit(id) {
            // document.getElementById('response').innerHTML = loader;
            // document.getElementById('edit_modal').style.display = 'block';
            $('#edit_modal').modal('toggle');
            $.ajax({
                type: 'GET',
                url: "{{URL("/Union/get")}}" + "/" + id,
                contentType: "html",
                dataType: 'html',
                success: function (data) {
                    document.getElementById('response').innerHTML = data;
                    $('#id').val(id);
                }
            });
        }
        function delete_rocord(id) {
            var result = confirm("Are you sure Want to delete?");
            if (result) {
                $.ajax({
                    type: 'POST',
                    url: "{{url('Union/delete')}}",
                    cache: false,
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            }
        }
    </script>
@stop
@endsection

