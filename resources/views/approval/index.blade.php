@extends('AdminLTE')
@section('content')

<div style="width:100%;margin: 0px; ">
    <div style="float:left;margin-top: 2px;">
        <h2 style="width:100%;font-size: 14px;font-weight: bold;"> Approval & Export Role</h2>
    </div>
    <div style="float:right;margin-top: 2px;">
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">Assign permission</button>
    </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form action="{{url('Approval-Pages/create')}}" method="POST">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Assign Permission to User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
                <div class="form-group">
                    <label for="exampleFormControlSelect1">User :</label>
                    <select required class="form-control" id="exampleFormControlSelect1" name="user_id">
                        <option disabled>Select User from list</option>
                        @foreach($allusers as $alluser)
                            <option value="{{$alluser->id}}">{{$alluser->name}}</option>
                        @endforeach
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Company :</label>
                    <select required class="form-control" id="exampleFormControlSelect1" name="company_id">
                        <option disabled>Select company from list</option>
                        @foreach($lkp_company as $lkp_item)
                            <option value="{{$lkp_item->id}}">{{$lkp_item->companyName}}</option>
                        @endforeach
                        
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="approveStatus" id="approveStatus">
                    <label class="form-check-label" for="defaultCheck2">
                    Approve
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="exportStatus" id="exportStatus">
                    <label class="form-check-label" for="exampleCheck1">Export</label>
                </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
        </div>
    </div>
    </div>
<!-- end modal -->

<!-- SELECT2 EXAMPLE -->
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search" onclick="card_change()"><i class="fa fa-search"></i></button>
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i id="i_box"
                                                                                                class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="box-body" class="box-body table-responsive">
                <table class="table m-0 search_table" style="width:10px!important;">
                    <tr>
                        <TH>CompanyName</TH>
                        <td>
                            <select name="filter_companyId" id="filter_companyId" onchange="WarehouseName()"
                                    class="form-control" style="width:200px;" required>
                                    <option value="0" disabled selected>Select Company (optional)</option>
                                @foreach($lkp_company as $lkpcompany)
                                    <option value="{{$lkpcompany->id}}"> {{$lkpcompany->companyName}}</option>
                                @endforeach
                            </select>
                        </td>
                        <TH>Employee</TH>
                        <td>
                            <select id="filter_warehouseId" name="filter_warehouseId" class="form-control"
                                    style="width:180px;">
                                <option value="0" disabled selected>Select Employee (optional)</option>
                                @foreach($users as $user)
                                <option value="">{{strtoupper($user->user->name)}}</option>
                                @endforeach
                                
                            </select>
                        </td>   
                    </tr>
                    
                </table>
                <div class="card-footer" align="center">
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Filter</button>
                    <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
<!-- /.col -->


<div class="card card-default" style="width:100%;clear:both;"></div>

<div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped" style="width: 98% !important; margin: 0 auto; !important">
        
            <thead>
                <TH>Emp Name</TH>
                <TH>Company </TH>
                <TH>Granted privileges</TH>
                <TH>Actions</TH>
            </thead>
            
            <tbody>
                @foreach($companies as $k=>$payload)
                <!-- action="{{url('Approval-Pages/Update')}}" method="post" -->
                     
                       
                        <input type="hidden" name="user_id" id="user_id{{$k+1}}" value="{{$payload['user_id']}}">
                        <input type="hidden" name="company_id" id="company{{$k+1}}" value="{{$payload['company_id']}}">
                        <tr>
                            <td>{{$payload['userName']}}</td>
                            <td>{{$payload['company_name']}}</td>
                            <td>
                                <table style="width: 100%;">
                                @php
                                    $tem = $payload['privilages'][0];
                                @endphp
                                        
                                        <tr>
                                        @if(count($payload['privilages']) == 2 )
                                        <td>
                                                Approve  <input type="checkbox" name="approve" checked id="approve{{$k+1}}">  |
                                                Export   <input type="checkbox"  checked name="export" id="export{{$k+1}}"  > <br>
                                             </td>
                                        @endif
                                        @if(count($payload['privilages']) == 1 )
                                        <td>
                                                @if($tem['privilege_description'] == 'Approve') 
                                                    Approve  <input type="checkbox" name="approve"  checked  id="approve{{$k+1}}"> |
                                                    Export   <input type="checkbox" name="export"  id="export{{$k+1}}" >
                                                    
                                                @endif 
                                                @if($tem['privilege_description'] == 'Export') 
                                                    Approve  <input type="checkbox" name="approve"  id="approve{{$k+1}}"> |
                                                    Export   <input type="checkbox" name="export" checked  id="export{{$k+1}}" >
                                                @endif
                                                <br>
                                              
                                            </td>
                                        @endif

                                        </tr>
                                        
                                </table>
                                                           
                            </td>
                            <td>
                                
                                <button class="btn btn-primary btn-sm" onclick="UpdateCheckBoxs('{{$k+1}}')">Update</button>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
              
                @endforeach
            </tbody>
        </table>
    </div>

<script>
    function UpdateCheckBoxs(args){

        // BTNS 
        var ExportStatus = 'export'+args
        ExportStatus = $('#'+ExportStatus+'').is(':checked');
        var ApproveStatus = 'approve'+args
        
        ApproveStatus = $('#'+ApproveStatus+'').is(':checked');
        console.log(ApproveStatus);
        // btns 

        var user_id = 'user_id'+args;
        var user_id =  document.getElementById(user_id).value
        var company_id = 'company'+args;
        var company_id =  document.getElementById(company_id).value

        var payload = {
            "user_id":user_id,
            "company_id":company_id,
            "approveStatus":ApproveStatus,
            "exportStatus":ExportStatus
        }
        $.ajax({
            type: 'POST',
            url: "{{URL('/Approval-Pages/Update')}}",
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data:{"_token": "{{ csrf_token() }}",payload}, 
            success: function (data) {
                console.log(data);
            }
        });
        console.log(payload)         
        // alert(checkBoxIDEport);
    }
</script>
@endsection