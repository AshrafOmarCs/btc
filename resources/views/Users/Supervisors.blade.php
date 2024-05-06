@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Users</h2>
        </div>
        <div style="float:right;">
            <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Users</a>
            </h2>
        </div>
    </div>








    <div class="card card-default" style="width:100%;clear:both;"></div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->



    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
            <TH>Name</TH>
            <TH>Phone</TH>
            <TH>Email</TH>
            <TH>IdentityNo</TH>
            <TH>User Type</TH>
            <TH>Role Name</TH>
            <TH>Warehouses</TH>
            <TH>Active</TH>
            <TH>Created_at</TH>
            <TH>Action</TH>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>

            <div style="width:100%;clear:both;" id="response">

            </div>
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
                <h1>Delete</h1>
            </header>
            <form class="w3-container" action="" method="POST" id="delete_form">
                {{method_field('DELETE')}}
                @csrf
                <div class="w3-section">
                    <p>Are you sure, you want to delete <span id="delete_name"></span> ?</p>
                    <div class="w3-center">
                        <button type="submit" class="w3-btn w3-indigo"> Delete</button>
                    </div>
                </div>
            </form>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('delete_modal').style.display='none'" type="button"
                        class="w3-btn w3-red">Cancel
                </button>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->


    <script>
        $(document).ready(function () {

            fill_datatable();

            function fill_datatable(filter_screenId = '') {
                var dataTable = $('#customer_data').DataTable({
                    //searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    "pagingType": "full_numbers",
                    "autoWidth": false,
                    "drawCallback": function (settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    ajax: {
                        url: "{{ route('Users.index') }}",
                        data: {
                            filter_screenId: 'Supervisors',
                        }

                    },

                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                            //visible:false
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'IdentityNo',
                            name: 'IdentityNo'
                        },
                        {
                            data: 'user_type',
                            name: 'lkp_user_type.user_type'
                        },
                        {
                            data: 'role_name',
                            name: 'users_role.role_name'
                        },
                        {
                            data: 'warehouses',
                            name: 'warehouse.warehouseName'
                        },
                        {
                            data: 'active_id',
                            render: function (data, type, row, meta) {

                                if (data == "1") {
                                    return '<span class="label label-success">' + row.active_status + '</span>';
                                } else if (data == "0") {
                                    return '<span class="label label-danger">' + row.active_status + '</span>';
                                } else if (data == "3") {
                                    return '<span class="label label-warning">' + row.active_status + '</span>';
                                } else if (data == "4") {
                                    return '<span class="label label-default">' + row.active_status + '</span>';
                                } else if (data == "2") {
                                    return '<span class="label label-primary">' + row.active_status + '</span>';
                                }
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            "orderable": false,
                            className: "dt-nowrap",
                            "targets": -1,
                            //"data": 'id',
                            "render": function (data, type, row, meta) {
                                return '<a id=' + row.id + ' data-original-title="edit" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-yellow vd_yellow edit"> <i class="fa fa-pencil"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="delete" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-red vd_red delete"> <i class="fa fa-times"></i> </a>' +
                                    '&nbsp;<a id=' + row.id + ' data-original-title="view" data-toggle="tooltip" data-placement="top" class="btnaction btn menu-icon vd_bd-green vd_green view"> <i class="fa fa-eye"></i> </a>' +
                                    '&nbsp;<button id=' + row.id + ' type="button" class="btn btn-primary btn-xs privilage">Privilege</button>' +
                                    '&nbsp;<button id=' + row.id + ' type="button" class="btn btn-primary btn-xs resetpass">Reset Pass</button>'


                            }
                            //onclick=\"document.getElementById('row_id').value='"+data+"'\"
                        }

                    ]
                });


            }

            $('#customer_data tbody').on('click', '.view', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Users')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.edit', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/Users')}}" + "/" + id + "/edit/2",
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });
            });
            $('#customer_data tbody').on('click', '.privilage', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/UsersPrivilage')}}" + "/" + id ,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;

                    }
                });

            });

            $('#customer_data tbody').on('click', '.resetpass', function (e) {
                e.preventDefault();
                document.getElementById('response').innerHTML = loader;
                document.getElementById('edit_modal').style.display = 'block';
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: "{{URL('/UserResetPass')}}" + "/" + id,
                    contentType: "html",
                    dataType: 'html',
                    success: function (data) {

                        document.getElementById('response').innerHTML = data;


                    }
                });

            });

            $('#customer_data tbody').on('click', '.delete', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                document.getElementById('delete_form').action = "{{URL('/Users')}}" + "/" + id;
                document.getElementById('delete_modal').style.display = 'block';
                //document.getElementById('response').innerHTML=data;


            });


        });

        function add() {
            document.getElementById('response').innerHTML = loader;
            document.getElementById('edit_modal').style.display = 'block';
            $.ajax({
                type: 'GET',
                url: "{{URL("/Users/create/2")}}",
                contentType: "html",
                dataType: 'html',
                success: function (data) {

                    document.getElementById('response').innerHTML = data;
                }
            });
        }

    </script>
    <script>
        function validateForm() {
            //alert($("#contact_form").serializeArray());

            //e.preventDefault();
            //document.getElementById('response').innerHTML = loader;
            //document.getElementById('edit_modal').style.display = 'block';

            var postData = $("#contact_form").serializeArray();
            //alert(postData);
            var formURL = $("#contact_form").attr("action");
            document.getElementById('response').innerHTML = loader;
            $.ajax({
                url: formURL,
                type: "POST",
                cache: false,
                data: postData,
                success: function (data) {
                    document.getElementById('response').innerHTML = data;


                },
                error: function (jqXHR, status, error) {
                    document.getElementById('response').innerHTML ="<br><br><br>"+error+"<br><br><br>";
                    alert(status + ": " + error);
                }
            });


            return false;
        }

    </script>

@endsection




