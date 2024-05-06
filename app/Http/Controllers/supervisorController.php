<?php

namespace App\Http\Controllers;
use App\Warehouse;
use App\Drivers;
use DB;
use Illuminate\Http\Request;

class supervisorController extends Controller
{
    public function index()
    {
        # code...
        $cities = Warehouse::where('companyId',6)->get();
        // dd($cities);
        return view('syinc.index',compact('cities'));
    }
    public function store(Request $request)
    {
        # code...
        // dd($request->all());
        $url = $request->URL;
        $Cookie = $request->Cookie;
        $warehouse_id = $request->warehouse_id;
        $this->retive($url,$Cookie,$warehouse_id);

    }
    public function retive($url,$Cookie,$warehouse_id){
        // dd($Cookie);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL =>  $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'cookie: JSESSIONID=bonYZxQXpTNB7R77pVBIfFmhCY2150cZDk0CG3Y-.ip-172-31-26-48; AWSALB=Ngu+DdXG0BVIdsVOgRTLjHVxxLQJvqDyoNzHVOlqXOYUZZj7Mlg4T/lxKNbWnkdhyDVS6FUVaVWQX4omICEJM8uARoJF9PD3DkOPKxOn4IAuHi1zKkDMu38Af+uns93keXO/udr4zsjzrTzr+06nrvRrpamySQ5gY/H4OjTHSWsgPrmXczYvqoXhZggUhw==; AWSALBCORS=Ngu+DdXG0BVIdsVOgRTLjHVxxLQJvqDyoNzHVOlqXOYUZZj7Mlg4T/lxKNbWnkdhyDVS6FUVaVWQX4omICEJM8uARoJF9PD3DkOPKxOn4IAuHi1zKkDMu38Af+uns93keXO/udr4zsjzrTzr+06nrvRrpamySQ5gY/H4OjTHSWsgPrmXczYvqoXhZggUhw=='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        $payload = $response['aaData'];
         dd($payload);
        foreach($payload as $driver){
            
            // $drivers = DB::table('drivers')->where('job_id',$driver['id'])->get();
            
            $drivers = Drivers::where('job_id',$driver['id'])->get();
            // dd($drivers);
            if(count($drivers)>0){
                $drivers[0]->warehouseId = $warehouse_id;
                $drivers[0]->save();
                // echo $driver['name'].' is Exsist <br>';
            }else{
                // dd($driver);
                // the driver is not registered in Bander Database
                $status;
                if($driver['status'] == true){
                    $status = 1;
                }else{
                    $status = 5;
                }
                $iqamaNo = (int) filter_var($driver['username'], FILTER_SANITIZE_NUMBER_INT);
                
                if($driver['mobile'] == 'deactivated'){
                    $newDriver = Drivers::create([
                    'warehouseId'=>$warehouse_id,
                    'fullName'=>$driver['name'],
                    // 'mobileNumber'=>'000000000',
                    'iqama'=>$iqamaNo,
                    'job_id'=>$driver['id'],
                    'status_id'=>$status,
                    'under_sopnsorship_id'=>2
                    ]);
                }else{
                    $newDriver = Drivers::create([
                    'warehouseId'=>$warehouse_id,
                    'fullName'=>$driver['name'],
                    'mobileNumber'=>$driver['mobile'],
                    'iqama'=>$iqamaNo,
                    'job_id'=>$driver['id'],
                    'status_id'=>$status,
                     'under_sopnsorship_id'=>2
                    ]);
                }
                echo ('Driver '.$driver['name'].', AMP_ID : '.$driver['id'].'  inserted <br><br>');
            }
            
        }
        
    }
}
