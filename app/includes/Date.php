<table><tr><td style="padding-right: 5px !important;">
 <select  name="<?php echo$name;?>_d"  class="form-control" style="width:50px" >
 <option value="">dd</option>

 <?php
 if (!isset($Date[0]))$Date[0]="";
 if (!isset($Date[1]))$Date[1]="";
 if (!isset($Date[2]))$Date[2]="";
for ($i = 1; $i <= 31; $i++)
 {
echo  "<option value='".sprintf("%02d", $i)."'";
if ($Date[2]==$i) echo " selected ";
echo">".sprintf("%02d", $i)."</option>";
 }
?>
 </select>
 </td>
 <td style="padding-right: 5px !important;">
 <select  name="<?php echo$name;?>_m"   class="form-control" style="width:50px" >
 <option value="">mm</option>
 <?php
 for ($i = 1; $i <= 12; $i++)
 {
   echo  "<option value='".sprintf("%02d", $i)."'";
   if ($Date[1]==$i) echo " selected ";
   echo">".sprintf("%02d", $i)."</option>";
}
?>
 </select>
 </td>
 <td>
 <select  name="<?php echo$name;?>_y"    class="form-control" style="width:60px" >
 <option value="">yyyy</option>
 <?php
 for ($i = (int)date('Y')-$from; $i < $to+ (int)date('Y'); $i++)
 {
   echo  "<option value='".$i."'";
   if ($Date[0]==$i) echo " selected ";
   echo">".$i."</option>";
}
?>
 </select>
 </td></tr></table>
