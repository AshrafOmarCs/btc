<?php

namespace App\Exports;
use App\Drivers;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
class LandmarkExport implements FromCollection,WithTitle 
{
    protected $payload,$Vehicle_Model;
    protected $DA_name = 'asas';
    
    public function __construct(array $payload,array $requestArray)
    {
        $this->payload = $payload;  
        $this->Vehicle_Model = $requestArray['Vehicle_Model'];
        $this->requestArray = $requestArray['requestPara'];   
        $this->DA_name = $this->payload['monthly']['Field_Executive'];
    }
    public function collection()
    {
        $collection = new Collection();
        // dd($this->Vehicle_Model);
        if($this->Vehicle_Model == 'PD' || $this->Vehicle_Model == 'pd'){
            $collection->push((object)
            [
                'SN' => 'S/N',
                'date'=>'DATE',
                'Day'=>'Day',
                'DAname'=>'Driver Name',   
                'Vehicle_No'=>'Vehicle No',                 
                'OFD'=>'OFD',
                'DELIVERED'=>'Delivered',
                'RVP_OFP'=>'RVP OFP',
                'RVP_Picked'=>'RVP Picked',
                'Total_Dlvd_plus_Picked'=>'Total Dlvd + Picked',
                'Per_Day_Charges'=>'Per Day Charges',
                'Driver_Bonus'=>'Driver Bonus',
                'Vehicle_Bonus'=>'Vehicle Bonus',
                'Total_Amount'=>'Total Amount'
            ]);
        }
        if($this->Vehicle_Model == 'Per' || $this->Vehicle_Model == 'Per'){
            $collection->push((object)
            [
                'SN' => 'S/N',
                'date'=>'DATE',
                'DAname'=>'Driver Name',                    
                'OFD'=>'OFD',
                'DELIVERED'=>'Delivered',
                'RVP_OFP'=>'RVP OFP',
                'RVP_Picked'=>'RVP Picked',
                'Total_Dlvd_plus_Picked'=>'Total Dlvd + Picked',
                'Per_Day_Charges'=>'Per Day Charges',
                'Driver_Bonus'=>'Driver Bonus',
                'Total_Amount'=>'Total Amount'
            ]);
        }
        
        $totalDivPlusPicked = 0.00;
        $PerDayChanrge = 0.00; 
        $totalNetAmount= 0.00;
        foreach ($this->payload['Days'] as $key => $value) { 
             
            
            # code...  
            if($value['Vehicle_Model'] == 'Permanent' || $value['Vehicle_Model'] == 'Permanent'){
                $totalNetAmount = $totalNetAmount+ $this->requestArray['permanent'];
                $totalDivPlusPicked = $totalDivPlusPicked + ($value['Dlvd'] + $value['RVP_Picked'])*$this->requestArray['pd'];
                $collection->push((object)
                [
                    'SN' => $key+1,
                    'date'=>$value['Date'],
                    'DAname'=>$value['Field_Executive'],
                    'OFD'=>$value['OFD'],
                    'DELIVERED'=>$value['Dlvd'],
                    'RVP_OFP'=>$value['RVP_OFP'],
                    'RVP_Picked'=>$value['RVP_Picked'],
                    'Total_Dlvd_plus_Picked'=>$value['Dlvd'] + $value['RVP_Picked'],
                    'Per_Day_Charges'=>$this->requestArray['permanent'],
                    'Driver_Bonus'=>'N/A',
                    'Total_Amount'=>$this->requestArray['permanent']
                ]);
                dd($totalDivPlusPicked);
                $totalDivPlusPicked = $totalDivPlusPicked + ($value['Dlvd'] + $value['RVP_Picked'])*$this->requestArray['pd'];
                $PerDayChanrge = $PerDayChanrge + $this->requestArray['permanent'];
            }
            if($value['Vehicle_Model'] == 'PD' || $value['Vehicle_Model'] == 'pd'){
                // $this->DA_name = $value['Field_Executive'];
                $collection->push((object)
                    [
                        'SN' => $key+1,
                        'date'=>$value['Date'],
                        'Day'=>'',
                        'DAname'=>$value['Field_Executive'],
                        'Vehicle_No'=>'N/A', 
                        'OFD'=>$value['OFD'], 
                        'DELIVERED'=>$value['Dlvd'],
                        'RVP_OFP'=>$value['RVP_OFP'],
                        'RVP_Picked'=>$value['RVP_Picked'],
                        'Total_Dlvd_plus_Picked'=>$value['Dlvd'] + $value['RVP_Picked'],
                        'Per_Day_Charges'=>$this->requestArray['pd'],
                        'Driver_Bonus'=>'N/A',
                        'Vehicle_Bonus'=>'N/A',
                        'Total_Amount'=>$this->requestArray['pd']*($value['Dlvd'] + $value['RVP_Picked'])
                    ]
                );
                $totalNetAmount = $totalNetAmount + $this->requestArray['pd']*($value['Dlvd'] + $value['RVP_Picked']);
                $totalDivPlusPicked = $totalDivPlusPicked+ ($value['Dlvd'] + $value['RVP_Picked']);
            }

            // Permanent
             
            }
            $monthly = $this->payload['monthly'];
            // dd($monthly['Total']);
            if($value['Vehicle_Model'] == 'PD' || $value['Vehicle_Model'] == 'pd'){
                $collection->push((object)
                [
                    'SN' => '#',
                    'date'=>'N/A',
                    'day'=>'',
                    'DAname'=>'',      
                    'Vehicle_No'=>'N/A',              
                    'OFD'=>$monthly['OFD'],
                    'DELIVERED'=>$monthly['Dlvd'],
                    'RVP_OFP'=>$monthly['RVP_OFP'],
                    'RVP_Picked'=>$monthly['RVP_Picked'],
                    'Total_Dlvd_plus_Picked'=>$totalDivPlusPicked,
                    'Per_Day_Charges'=>'     -     ',
                    'Driver_Bonus'=>'N/A',
                    'Vehicle_Bonus'=>'Ns/A',
                    'Total_Amount'=>$totalNetAmount
                ]);
            }
            if($value['Vehicle_Model'] == 'Permanent' || $value['Vehicle_Model'] == 'Permanent'){
                
                $PerDayChanrge = $PerDayChanrge + $this->requestArray['permanent'];
                
                
                $collection->push((object)
                [
                    'SN' => '#',
                    'date'=>'N/A', 
                    'DAname'=>'',                   
                    'OFD'=>$monthly['OFD'],
                    'DELIVERED'=>$monthly['Dlvd'],
                    'RVP_OFP'=>$monthly['RVP_OFP'],
                    'RVP_Picked'=>$monthly['RVP_Picked'],
                    'Total_Dlvd_plus_Picked'=>$totalDivPlusPicked,
                    'Per_Day_Charges'=>'     -     ',
                    'Driver_Bonus'=>'N/A',
                    'Total_Amount'=>$totalNetAmount
                ]);
            }

        return $collection;
        // return collect([
        //     (object) [
        //         'website' => 'twitter',
        //         'url' => 'twitter.com'
        //     ],
        //     (object) [
        //         'website' => 'google',
        //         'url' => 'google.com'
        //     ]
        // ]);
        return Drivers::limit(25)->get();
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }
    public function title(): string
    {
        // dd($this->DA_name);
        return $this->Vehicle_Model.' - '.$this->DA_name;
    }
}