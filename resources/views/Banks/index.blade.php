@extends('AdminLTE')
@section('content')

    <!-- Content Header (Page header) -->
     <div style="width:100%;margin: 0px; "> 
         <div style="float:left;margin-top: 2px;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Bank</h2> 
         </div>  
         <div style="float:right;">  
             <h2><a href="javascript:add();" class="btn btn-sm btn-info "><i class="fa fa-plus"></i> Add New Company</a>  
             </h2>  
         </div>  
     </div>  
    <div class="card card-default" style="width:100%;clear:both;">

    </div>

    <!--w3-table-all w3-card-4-->
    <!-- table table-bordered table-striped  -->


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


                <div class="card-footer" align="center">
                    <button type="button" name="filter" class="btn btn-sm btn-info" id="filter">Filter</button>

                    <button type="button" name="reset" class="btn btn-sm btn-default" id="reset">Reset</button>
                </div>
            </div>
            <!-- /.box-body -->

            
            <!-- text Goes here  -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
 
    <div class="table-responsive" style="width: 100%;">
        <table class="table m-0 search_table" style="width:10px!important;">
            <tr>
                <TH>Bank ID</TH>
                <TH>Bank Name</TH>
                <TH>Bank Arabic Name</TH>
                <TH>Actions</TH>
            </tr>
            @foreach($banks as $bank)
                <tr>
                    <td>{{$bank->id}}</td>
                    <td>{{$bank->bank_name_en}}</td>
                    <td>{{$bank->bank_name_ar}}</td>

                    <td> ICONs</td>
                </tr>
            @endforeach
        </table>
    </div>
    <!---------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------->
    <div id="edit_modal" class="w3-modal" style="padding-top: 10px !important;">
        <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
            <div class="w3-center"><br>
                <span onclick="document.getElementById('edit_modal').style.display='none'"
                      class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright"
                      title="Close Modal">&times;</span>
            </div>

            <div style="width:100%;clear:both;" id="response">

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
     



@endsection




