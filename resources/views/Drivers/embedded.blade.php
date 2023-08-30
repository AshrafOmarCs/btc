<?php
foreach ($drivers as $driver) {
            $p = $a = '';
            if ($driver->status == 'present') {
                $p = 'checked';
            } else if ($driver->status == 'absent') {
                $a = 'checked';
            }
            $response .= '<tr>
            <td>'.$driver->companyName.'</td>
            <td>'.$driver->warehouseName.'</td>
            <td>'.$driver->job_id.'</td>
            <td>'.$driver->plate.'</td>
            <td>'.$driver->fullName.'</td>
            <td>'.$driver->name_en.'</td>
            <td>
                <label class="radio-inline" style="padding-left: 0px !important"><input '.$p.' type="radio" name="status'.$driver->attendance_id.'" onclick=update("'.$driver->attendance_id.'","'.$driver->job_id.'","present")>Present</label>
                <label class="radio-inline"><input '.$a.' type="radio" name="status'.$driver->attendance_id.'" onclick=update("'.$driver->attendance_id.'","'.$driver->job_id.'","absent")>Absent</label>
                
            </td>
            </tr>';
        }