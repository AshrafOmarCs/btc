<?php

namespace App\Exports;

use App\User;
Use Carbon;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {   
        // dd(User::where('user_type_id',1)->get());
        $users = DB::select('SELECT drivers.*,warehouse.warehouseName,lkp_company.companyName,lkp_driver_status.driver_status_en,lkp_city.name_en as "cityName" FROM `drivers` JOIN warehouse ON warehouse.id = drivers.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId JOIN lkp_driver_status on lkp_driver_status.id = drivers.status_id JOIN lkp_city ON lkp_city.id = warehouse.cityId WHERE lkp_company.id !=6');
        
        // $lastPaidReport = DB::select('SELECT drivers.*,warehouse.warehouseName,lkp_company.companyName,lkp_driver_status.driver_status_en FROM `drivers` JOIN warehouse ON warehouse.id = drivers.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId JOIN lkp_driver_status on lkp_driver_status.id = drivers.status_id WHERE lkp_company.id = 6 LIMIT 0, 200');
        // $balance = DB::select('SELECT drivers.*,warehouse.warehouseName,lkp_company.companyName,lkp_driver_status.driver_status_en FROM `drivers` JOIN warehouse ON warehouse.id = drivers.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId JOIN lkp_driver_status on lkp_driver_status.id = drivers.status_id WHERE lkp_company.id = 6 LIMIT 0, 200');

        // dd($users);
        $payload = array();
        foreach($users as $user){
            $totalDebit = DB::select('SELECT SUM(debit) as "totalDebit" FROM `journal` WHERE `driverId`='.$user->id.' and journal_date BETWEEN "2022-01-01" and "2022-11-26"');
            $totalCredit = DB::select('SELECT SUM(credit) as "totalCredit" FROM `journal` WHERE `driverId`='.$user->id.'');
            $lastPayloadDays = DB::select('SELECT * FROM journal WHERE journal_type_id=6 and journal.driverId='.$user->id.' ORDER BY journal.created_at DESC');
            if(count($lastPayloadDays)>0){ 
                if($lastPayloadDays[0]->journal_date == '' || $lastPayloadDays[0]->journal_date == NULL){

                    
                }else{
                    // dd($lastPayloadDays);
                    $lastPayloadDays = $lastPayloadDays[0]->journal_date;
                    $lastPayloadDate = $lastPayloadDays;
                    $current_date = Carbon\Carbon::now();
                    $lastPayloadDays = $current_date->diff($lastPayloadDays);
                    $lastPayloadDays = $lastPayloadDays->days;
                }
                
            }else{
                $lastPayloadDays = '';
                $lastPayloadDate='';
            }
            

            $payload[] = [
                'project_name'=>$user->companyName,
                'warehouse_name'=>$user->warehouseName,
                'city'=>$user->cityName,
                'driver_id'=>$user->id,
                'job_id'=>$user->job_id,
                'daName'=>$user->fullName,
                'status'=>$user->driver_status_en,
                'TotalDebit'=>$totalDebit[0]->totalDebit,
                'totalCredit'=>$totalCredit[0]->totalCredit,
                'balance'=>$totalCredit[0]->totalCredit-$totalDebit[0]->totalDebit,
                'lastPayloadDays'=>$lastPayloadDays,
                'lastPayloadDate'=>$lastPayloadDate,  
            ];
            

        }
        // dd($payload);
        // return User::where('user_type_id',1)->get();
        // $results = array();
        //     $payload = [
        //         'Reference Number'=>"",
        //         'Telephone Number'=>'',
        //         'Amount'=>""
        //     ];
        //     $results[] = $payload;
            $excelSheet = array();
            $excelSheet[] = [
                '#',
                'Project name',
                'Warehouse',
                'City',
                'DA Name',
                'DA ID',
                'DA Status',
                'Balance',
                'Last clearnace Date'
            ];
            foreach($payload as $k=>$item){
                if($item['balance']<0){
                    $excelSheet[] = [
                        $k+1,
                        $item['project_name'],
                        $item['warehouse_name'],
                        $item['city'],
                        $item['daName'],
                        $item['job_id'],
                        $item['status'],
                        $item['balance'],
                        $item['lastPayloadDate']
                    ];
                }
                
            }
            
        return collect([
            $excelSheet,
        ]);
        // return $users; 
            
    }
}
