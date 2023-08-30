<style>
  .show_table th{
   padding-left: 20px !important;
   white-space: nowrap;
   border:none !important;
  margin:0!important;
  }
  .show_table td{
   padding: 0.0rem 0.0rem !important;
   border:none !important;
   vertical-align: middle !important;
  }
  </style>

 <div style="float:left;margin-top: 5px;margin-left: 20px;width:100%;"><h2 style="width:100%;font-size: 14px;font-weight: bold;">Gaps</h2>
</div>
    
<form method="POST" action="{{ route('Gaps.store')}}"    >   
                       @csrf

 <table >
 <tr>
 <td style="vertical-align: top !important;">                       
<table class="table m-0 show_table" style="width:10px!important;" >
<tr><TH>Driver <font color="red">*</font></TH>  
<td  style="white-space: nowrap;">
          <input name="driverId" id="driverId" type="hidden" value="" >
           <table style="padding: 0px 0px; !important;"><tr><td>
          <input  class="form-control" name="driverId_input" id="driverId_input"  style="width:200px"  type="text" value="" required   data-readonly> 
          </td><td><button onclick="driver_window();" type="button" class="btn btn-primary btn-sm" >Select</button>
          </td></tr></table>
</td>
 </tr>
   
 <Tr>
 <TH colspan=2 id="balance"></TH>
 </tr>  
<tr><TH>Journal Date <font color="red">*</font></TH>  
 <td>
 <select name="journal_period" id="journal_period"
                                        class="form-control" style="width:300px;" required>
                                    <option value=""></option>
                                    </select>
 <!--<div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="journal_date" placeholder="dd/mm/yyyy" id="journal_date" value="" required>
                </div>-->
 </td>
 </tr>
 <tr><TH>Packages Count <font color="red">*</font></TH>  
 <td><input  type="text" class="form-control"    name="package_count" value="" required ></td>
 </tr>
 <tr><TH>Amount <font color="red">*</font></TH>  
 <td><input  type="text" class="form-control"    name="amount" value="" required ></td>
 </tr>
 <tr><TH>Note</TH>  
 <td><textarea name="note"  class="form-control" rows=5 ></textarea></td>
 </tr></td>
 </tr>
 
  </table>
</td>
</tr></table>
           <div class="w3-row">
                 <button class="w3-btn-block w3-indigo w3-section w3-padding" type="submit">Add</button>
              </div>
</form>
           <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
              <button onclick="document.getElementById('response').innerHTML='';document.getElementById('edit_modal').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>
           </div>
