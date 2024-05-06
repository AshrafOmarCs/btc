@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
    <div style="width:100%;margin: 0px; ">
        <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Project Claims</h2>
        </div>
        <div style="float:right;">
            {{-- <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Users</a> </h2> --}}
        </div>
    </div>








    <div class="card card-default" style="width:100%;clear:both;"></div>
    <div class="col-md-3" style="width:100%;clear:both;">
        <div id="card_box" class="box box-primary ">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <button class="button_search"><i class="fa fa-search"></i></button>
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
                            <select name="filter_companyId" id="filter_companyId" onchange="CityName()"
                                    class="form-control" required>

                                
                            </select>
                        </td>
                        <TH>Under Noon</TH>
                        <td>
                            <select name="filter_under_noon_id" id="filter_under_noon_id"
                                    class="form-control" style="width: 200px">
                                <option value=""></option>
                                
                            </select>
                        </td>
                    </tr>
                    
                  
                    <tr>
                        <TH>PacKages Date</TH>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" style="width:200px" class="form-control pull-right"
                                       name="pakage_date" id="pakage_date" placeholder="dd/mm/yyyy"
                                       value="<?php echo date('d/m/Y');?>" required>
                            </div>

                        </td>
                    </tr>

                </table>

                <div class="card-footer" align="center">
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Dialy Load</button>


                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->



    <div class="table-responsive" style="width: 100%;">
        <table id="customer_data" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Hub name</th>
                    <th rowspan="2">City</th>
                    <th rowspan="2">Driver</th>
                    <th colspan="3">Documents</th>
                    <th rowspan="2">Claim amount</th>
                    <th rowspan="2">Last dayload</th>
                    <th rowspan="2">feeds</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                    <th>Identity/Iqama</th>
                    <th>Job Contract</th>
                    <th>Promissory Note</th> 
                </tr>
            </thead>
            
            <tbody>
                 <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                 </tr>
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
 
@endsection




