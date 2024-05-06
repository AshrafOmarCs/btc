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
            $response = array('Vehicle_Model'=>$payload['monthly']['Vehicle_Model'],'requestPara'=>$this->requestArray);
            $sheets[] = new LandmarkExport($payload,$response);
        }
        // dd($sheets[0]);
        return $sheets;
    }

}
