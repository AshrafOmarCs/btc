<?php

namespace App\Http\Controllers;

use App\Drivers;
use DB;
use App\User;
use App\Company;
use App\Exports\LMMultiSheetExport;
use App\Exports\LandmarkExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Packages_report;
use App\Journal;
use App\Warehouse; 
use App\Driver_state;
use App\Driver_type;
use App\City; 
use App\Temporary;
use Auth;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LandmarkController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('landmark.index');
        # code...
    }
    public function HandleLandmarkFile(Request $request)
    {
        # code...
        
        if($request->hasfile('myFile')){
         
            // read file before storing 
            $file = $request->myFile; 
            $safeName = 'uploaded_Dailload_File_at_by_EmpID_'.Auth::user()->id.'_'.date("Y-m-d").'.csv';
            $fileSaved = \Storage::put('public/Landmark/'.$safeName,\File::get($file)); 

            $checkTemFile = Temporary::where([
                ['path','storage/Landmark/'.$safeName],
                ['journal_date',date("Y-m-d")]
            ])->get();
            
            if(count($checkTemFile)>0){
                $tep= $checkTemFile->first(); 
            }else{ 
                $tep = new Temporary(); 
            } 
            // $safeName = 'imile_'.date("Y-m-d").'.csv';

             
            if($fileSaved == true){
                $tep->path = 'storage/Landmark/'.$safeName;
                $tep->journal_date = date("Y-m-d"); 
                $tep->save(); 
                $res = $this->convertCsvToArray($tep->path,$tep->id); 
                // dd($request->all());
                // dd($res);
                // $extra = array(''=>'',''=>'');
                return Excel::download(new LMMultiSheetExport($res,$request->all()), 'PRODUCTIVITY REPORT '.$tep->journal_date.'.xlsx');
                return (new LandmarkExport(2018))->download('invoices.xlsx');
                // return (new LandmarkExport(2022))->download('invoices.xlsx');
                // return Excel::download(new LMMultiSheetExport($res), 'I-Mile_PRODUCTIVITY REPORT.xlsx');
                // return Excel::download(new LandmarkReportExport, 'مطالبات المشاريع ما عدا جاهز.xlsx');
                // return $res; 
            }else{
            }
            // dd($fileSaved);
            // return redirect()->back()->withSuccess('File has been imported successfully ');
        }else{
            dd('noon');
        }
        dd($request->all());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function convertCsvToArray($path,$file_id)
    {
        # code...
         
        $CSVfp = fopen($path, "r");
        $count = 0;
        $recoreds = array();
        if($CSVfp !== FALSE) {
        fgetcsv($CSVfp); 
        while (($data = fgetcsv($CSVfp, 1000, ",")) !== FALSE) {
                // dd($data);
                if($data[0] == '' || $data[1] == '' || $data[2] == '' || $data[3] == '' || $data[4] == '' || $data[5] == ''){
                    continue; 
                }
                $recoreds[] =[
                    'Date'=>$data[0],
                    'Hub'=>$data[1], 
                    'Field_Executive'=>$data[2],
                    'Vehicle_type'=>$data[4],
                    'Vehicle_Model'=>$data[5],
                    'Driver_Type'=>$data[5],                    
                    'CID'=>$data[6],
                    'OFD'=>$data[7],
                    'Dlvd'=>$data[8],
                    'percentage'=>$data[9],
                    'NA'=>$data[10],
                    'FD'=>$data[11],
                    'CL'=>$data[12],
                    'WN'=>$data[13], 
                    'IA'=>$data[14],
                    'NSS'=>$data[15],
                    'Others'=>$data[16],
                    'RVP_OFP'=>$data[17],
                    'RVP_Picked'=>$data[18],
                    'bounce'=>null,
                    'Total'=>$data[19],
                ]; 
            }
            // $unique = array_unique($recoreds); .
            $new_recoreds = array();
            $res = array_unique(array_column($recoreds, 'Field_Executive'));
            foreach ($res as $counter => $re) { 
                $new_recoreds[] = $this->search($recoreds, 'Field_Executive',$re);
            }
            $payload = array('DA_QTY'=>count($res),'payload'=>$new_recoreds);
            // $dupes = array_diff_key( $recoreds, 'Field_Executive' ); 
            // dd($recoreds);
            // $key = array_search("P_BTC_01_NDD_ABDUL BASHIR_MAK_LMG", $recoreds[2]);
            
            return $new_recoreds;
            
            fclose($CSVfp);
        }

        
    }
    function search($array, $key, $value)
    {    
        $results = array();  
        $monthly =[
            'days'=>null,
            'Hub'=>null, 
            'Field_Executive'=>null,
            'Vehicle_type'=>null,
            'Vehicle_Model'=>null,
            'Driver_Type'=>null,
            'CID'=>null,
            'OFD'=>null,
            'Dlvd'=>null,
            'percentage'=>null,
            'NA'=>null,
            'FD'=>null,
            'CL'=>null,
            'WN'=>null, 
            'IA'=>null,
            'NSS'=>null,
            'Others'=>null,
            'RVP_OFP'=>null,
            'RVP_Picked'=>null,
            'bounce'=>null,
            'Total'=>null
        ]; 
        $days = 0;
        foreach($array as $k=>$item){
            if ($item['Field_Executive'] == $value) {   
                $days = $days + 1;
                $results[] = $item;  
                if($item['percentage'] == '#DIV/0!'){
                    // dd($item);
                    $item['percentage'] = 0;
                }

                if($item['FD'] == ''){
                    // dd($item);
                    $item['FD'] = 0;
                    // $item['percentage'] = 0;
                }
                if($item['CL'] == ''){
                    // dd($item);
                    $item['CL'] = 0;
                    // $item['percentage'] = 0;
                }
                if($item['NA'] == ''){
                    // dd($item);
                    $item['NA'] = 0;
                    // $item['percentage'] = 0;
                }
 
                $monthly['Hub'] = $item['Hub']; 
                $monthly['Field_Executive'] = $item['Field_Executive'];
                $monthly['Vehicle_type'] = $item['Vehicle_type'];
                $monthly['Vehicle_Model'] = $item['Vehicle_Model'];
                $monthly['Driver_Type'] = $item['Driver_Type']; 
                $monthly['CID'] = $monthly['CID']+$item['CID']; 
                $monthly['OFD'] = $monthly['OFD']+$item['OFD']; 
                $monthly['Dlvd'] = $monthly['Dlvd']+$item['Dlvd']; 
                $monthly['percentage'] = $monthly['percentage'] + str_replace('%', '', $item['percentage']); 
                $monthly['FD'] = $monthly['FD']+$item['FD']; 
                $monthly['CL'] = $monthly['CL']+$item['CL']; 
                $monthly['NA'] = $monthly['NA']+$item['NA'];  
                $monthly['WN'] = (int)$monthly['WN']+(int)$item['WN'];  
                $monthly['IA'] = (int)$monthly['IA']+(int)$item['CID']; 
                $monthly['NSS'] = (int)$monthly['NSS']+(int)$item['NSS']; 
                $monthly['Others'] = (int)$monthly['Others']+(int)$item['Others']; 

                $monthly['RVP_OFP'] = $monthly['RVP_OFP']+$item['RVP_OFP']; 
                $monthly['RVP_Picked'] = $monthly['RVP_Picked']+$item['RVP_Picked']; 
                $monthly['Total'] = $monthly['Total']+$item['Total']; 
            } 
            // $returedData = array('daily'=>$results,'summary'=>'');
            
            // foreach ($array as $subarray) {
            //     $results = array_merge($results, search($subarray, $key, $value));
            // }  
        }
        $monthly['days'] = $days;
        $monthly['percentage'] = round(($monthly['percentage']/$days),2); 
        $summary = array('Days'=>$results,'monthly'=>$monthly);
        return $summary;
         

    } 


}