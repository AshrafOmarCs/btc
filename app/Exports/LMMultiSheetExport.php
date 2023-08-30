<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LMMultiSheetExport implements WithMultipleSheets
{
    use Exportable;

    protected $year,$requestArray;
    
    public function __construct(array $payload,array $requestArray)
    {
        $this->payload = $payload;
        $this->requestArray = $requestArray;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        
        foreach($this->payload as $payload){
            // dd($payload['monthly']['Vehicle_Model'][0].$payload['monthly']['Vehicle_Model'][1].$payload['monthly']['Vehicle_Model'][2]);
            if(!isset($payload['monthly']['Vehicle_Model'][2])){
                $response = array('Vehicle_Model'=>$payload['monthly']['Vehicle_Model'][0].$payload['monthly']['Vehicle_Model'][1],'requestPara'=>$this->requestArray);
            }else{
                $response = array('Vehicle_Model'=>$payload['monthly']['Vehicle_Model'][0].$payload['monthly']['Vehicle_Model'][1].$payload['monthly']['Vehicle_Model'][2],'requestPara'=>$this->requestArray);
            }
            
            // dd($response);
            $sheets[] = new LandmarkExport($payload,$response);
        }
        // dd($sheets);
        return $sheets;
    }

}
