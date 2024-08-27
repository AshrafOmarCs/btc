<?php

namespace App\Http\Controllers;
use DB;
use PDF;
use Auth;
use TCPDF;
use App\Loan;
use App\Journal;
use App\Drivers;
use App\Packages_report;
use App\CreditNotes;
use App\Settlements;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Http\Request;

class AshrafController extends Controller
{
    //

    function DA_PANDA_Handling() {
        $data = [
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010051401",
        "Driver_Name"=> "BTC ABU OBAIDAH ADAM"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010051501",
        "Driver_Name"=> "BTC  FAHAD ALI MABROOK"
        ],
        [
        "Station_Name"=> "Buraidah Station",
        "Driver_Code"=> "D21010052",
        "Driver_Name"=> "BTC-Ahmed Ubaid Ahmed DJ"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21010060401",
        "Driver_Name"=> "BTC-Mubarak Awad"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21010148401",
        "Driver_Name"=> "Mohamed Elhaga-BTC"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21010182201",
        "Driver_Name"=> "IBRAHIM HAFIZ IBRAHIM YUSAF"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D21010258101",
        "Driver_Name"=> "BTC  Saleh Hussein"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010266001",
        "Driver_Name"=> "BTC MOHAMMED ELAMEIN"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010284401",
        "Driver_Name"=> "BTC ABDELMAWLA ABDALLA"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010304",
        "Driver_Name"=> "BTC AHMED ELSIR IRRAHIM AHMED P"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010360001",
        "Driver_Name"=> "BTC ALI ORSOD"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21010427801",
        "Driver_Name"=> "ELTAYEB MOHAMED ELTAYEB"
        ],
        [
        "Station_Name"=> "Ar Rass Station",
        "Driver_Code"=> "D21010498001",
        "Driver_Name"=> "SAEED IBRAHIM BTC"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21010747",
        "Driver_Name"=> "Khalid-BTC"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010926701",
        "Driver_Name"=> "BTC MOHAMMED JOFRUL"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D21011883901",
        "Driver_Name"=> "BTC-Hudhaifa Mohammed Ali Yahya Al Samawi"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21012181301",
        "Driver_Name"=> "AHMED ALAMIN-BTC-KHJ"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21012191901",
        "Driver_Name"=> "SADAM SALAUDIN-BTC"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21012218801",
        "Driver_Name"=> "BTC-Javed Taj"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21012257701",
        "Driver_Name"=> "Noureldaeem Mustafa-BTC"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21012380301",
        "Driver_Name"=> "YASIR ISMAIL-BTC-MUN"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21012570401",
        "Driver_Name"=> "Mohamed fais-KHJ-BTC"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21012572801",
        "Driver_Name"=> "ABDALRAHMAN FADOL-KHJ-BTC"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D21012634401",
        "Driver_Name"=> "BTC Omer Khalil Eltayeb"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D21012653101",
        "Driver_Name"=> "BTC Hassanain Hassan"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21012681301",
        "Driver_Name"=> "YASEEN MOHAMED-KHJ-BTC"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21013505001",
        "Driver_Name"=> "BTC-Al Ameen"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21013505401",
        "Driver_Name"=> "BTC-Taha "
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D21015022",
        "Driver_Name"=> "MOHAMMED DAIFALLA"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21018677",
        "Driver_Name"=> "BTC Albadri Tagalsir Mahmoud"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21029033",
        "Driver_Name"=> "BTC-Hof-Amaar Alkamel"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21029597",
        "Driver_Name"=> "BTC-Hof-Abod Jana"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21029814",
        "Driver_Name"=> "Hamid-BTC"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21030633",
        "Driver_Name"=> "Mousa-BTC"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21030960",
        "Driver_Name"=> "BTC-Hof-Bakri awadallah"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21035509",
        "Driver_Name"=> "BTC Abdulrahman Alsiddiq Awadelkarim Alarki"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21035932",
        "Driver_Name"=> "BTC-HOF-Amjad Abdelrahim"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D21037771",
        "Driver_Name"=> "Muhammad DAIM BTC"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D21038239",
        "Driver_Name"=> "BTC-TWFEEG MOHAMMAD SHARAF ALI"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D21044782",
        "Driver_Name"=> "SAEED HASSAN BTC"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D21045279",
        "Driver_Name"=> "HASHIM MAMDOUH BTC"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D21047713",
        "Driver_Name"=> "Abdul Hakam BTC"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D21047864",
        "Driver_Name"=> "Saleh Salem Mubarak Bakhuraysah"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21049254",
        "Driver_Name"=> "BTC-HOF-Kamal Zaidan"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21052549",
        "Driver_Name"=> "Ahmed Abdelrahman-BTC"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21052885",
        "Driver_Name"=> "UBAID -BTC"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21053206",
        "Driver_Name"=> "BTC-HOF-Abdul Qadir"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21053687",
        "Driver_Name"=> "BTC-HOF-Omer Siddig"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21053825",
        "Driver_Name"=> "BTC-HOF-izzeldin"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D21054625",
        "Driver_Name"=> "Abdul Aziz BTC"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D2105745301",
        "Driver_Name"=> "Ayoub Ashraf-BTC"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D2105955601",
        "Driver_Name"=> "AHMAD ISMAIL1"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D2106038301",
        "Driver_Name"=> "Mohamed Ashraf Wasfi"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D2106264201",
        "Driver_Name"=> "Abdelali Abdelau Khaldane-BTC"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D2106623201",
        "Driver_Name"=> "SADIQ-BTC"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D2106931401",
        "Driver_Name"=> "BTC-HOF-Mahmood Mohamed "
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D2107114201",
        "Driver_Name"=> "BTC-HOF-Mohammed Ali Hamid"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D2107387601",
        "Driver_Name"=> "SIDDQ QURASHI YOUSEF MOHAMMED "
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D2107432701",
        "Driver_Name"=> "BTC BAKHTAIR ALI1"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D2107524801",
        "Driver_Name"=> "AHMED FAITAH ABDELLATIF HUSSEIN "
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D2107555501",
        "Driver_Name"=> "BTC-Samir Hassan"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D2107558201",
        "Driver_Name"=> "M Ahmad Idrees"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D2107771801",
        "Driver_Name"=> "Khalid Bala Madwe Elfki"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D2108446501",
        "Driver_Name"=> "Sami Sand Agebseedo Mukhtar"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D2108814501",
        "Driver_Name"=> "BTC-HOF-Tagelsir Bakheet"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D2109489901",
        "Driver_Name"=> "BTC-Anwar Abdulhakim"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D2109963301",
        "Driver_Name"=> "HAMED ABDALLAH IBRAHIM AHMAD"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D2109970501",
        "Driver_Name"=> "BTC ALI AHMED MOHAMMED ALI"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D2109986101",
        "Driver_Name"=> "BTC-Abul Hassan Salah"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21010751701",
        "Driver_Name"=> "MUHAID MOHAMED ISMAIL AJABNA"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D21012634001",
        "Driver_Name"=> "BTC Moneb Saifaleslam"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21013560001",
        "Driver_Name"=> "WAHEEDELDEEN-BTC"
        ],
        [
        "Station_Name"=> "Muhayil Station",
        "Driver_Code"=> "D21016635",
        "Driver_Name"=> "Adel Abdullah Saleh Mohammed"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21029974",
        "Driver_Name"=> "Selm-BTC"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D21044777",
        "Driver_Name"=> "Ali Ahmed BTC1"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D2104925",
        "Driver_Name"=> "BTC-HBT-WAHIB KHALED"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21053209",
        "Driver_Name"=> "Khizer obaid"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D2106484101",
        "Driver_Name"=> "BTC-Ahmed Ali Taha"
        ],
        [
        "Station_Name"=> "Ar Rass Station",
        "Driver_Code"=> "D2106619101",
        "Driver_Name"=> " SAID MOHAMMED UMAR SALEH-BTC"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21010324701",
        "Driver_Name"=> "Faisal Ibrahim-BTC"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21012165601",
        "Driver_Name"=> "Amro Ibrahim-BTC-KHJ"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D21026836",
        "Driver_Name"=> "BTC-Mohamed Ahmed Mohamed Ibrahim"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D21031132",
        "Driver_Name"=> "Mohammed Abduljalil AbdulMajeed"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21048470",
        "Driver_Name"=> "BTC-HOF-Yousif Elemam"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D2107277601",
        "Driver_Name"=> "BTC-Bahaa Abdelrahman"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D2108824001",
        "Driver_Name"=> "MUAZ SULAIMAN MUMARIK SULAIMAN"
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D2109940001",
        "Driver_Name"=> "OMER AWADALLAH SULAIMAN AHMED (BTC)"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21013068801",
        "Driver_Name"=> "BTC-Bashar Mohammed "
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D2106353",
        "Driver_Name"=> "BTC-HBT-AHMED YOUSEF ALMOUSA"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D21010373501",
        "Driver_Name"=> "BTC-Saddam Nouruldeen Abduljabbar Allayth"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21011442",
        "Driver_Name"=> "Sultan-BTC"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21053501",
        "Driver_Name"=> "BTC-HOF-Usman Abdullah"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D2107474601",
        "Driver_Name"=> "BTC-HOSHAM YOUSIF1"
        ],
        [
        "Station_Name"=> "Ar Rass Station",
        "Driver_Code"=> "D2109421001",
        "Driver_Name"=> "AKARAM-BTC"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21012965801",
        "Driver_Name"=> "FAISAL ALI-MUN-BTC"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D2106279201",
        "Driver_Name"=> "Hameed Ahmed Saif Alhumaidi"
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D2107172801",
        "Driver_Name"=> "NAJMADEIN MOHAMMED BANAGA"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010194501",
        "Driver_Name"=> "BTC AHMED ABDALLA "
        ],
        [
        "Station_Name"=> "Arar Station",
        "Driver_Code"=> "D21010755801",
        "Driver_Name"=> "SABREY SOWAR 2 "
        ],
        [
        "Station_Name"=> "Al Kharj Station",
        "Driver_Code"=> "D21013652301",
        "Driver_Name"=> "KHALED REDA-BTC"
        ],
        [
        "Station_Name"=> "Hofuf Station",
        "Driver_Code"=> "D21051584",
        "Driver_Name"=> "BTC-HOF-Mohammed Aljjak"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21012679401",
        "Driver_Name"=> "AHMED FARAH-MUN-BTC"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21010559",
        "Driver_Name"=> "Mohamed Eltayeb"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21012082",
        "Driver_Name"=> "Muhammad Sehar-BTC"
        ],
        [
        "Station_Name"=> "Qurayyat Station",
        "Driver_Code"=> "D21010148",
        "Driver_Name"=> "BTC Mohamed zain fadlalla"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D2107409201",
        "Driver_Name"=> "BTC-Said"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D21012945101",
        "Driver_Name"=> "BTC-Eltayeb Elbasri Sirelkhatim Nourelhadi "
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21028776",
        "Driver_Name"=> "Fahad-BTC"
        ],
        [
        "Station_Name"=> "Tuwaiq Station",
        "Driver_Code"=> "D21010152401",
        "Driver_Name"=> "Abdul Majeed Muntaser-BTC"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D21013901001",
        "Driver_Name"=> "BELAL LUAY MOHAMMED BITAR"
        ],
        [
        "Station_Name"=> "Riyadh Munsiyah Station",
        "Driver_Code"=> "D21012285501",
        "Driver_Name"=> "EMRAHIM-BTC-MUN"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D21013991701",
        "Driver_Name"=> "BTC Mubarak Ali Saleh"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21014033801",
        "Driver_Name"=> "BTC-Hussein"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D21014036001",
        "Driver_Name"=> "BTC Mohamed Osman Ibrahim"
        ],
        [
        "Station_Name"=> "Buraidah Station",
        "Driver_Code"=> "D21030925",
        "Driver_Name"=> "Mohammed Abdulbaqi Mohsen Qaid"
        ],
        [
        "Station_Name"=> "Buraidah Station",
        "Driver_Code"=> "D21012732801",
        "Driver_Name"=> "JAMAL ALI ESHAG "
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D2105879701",
        "Driver_Name"=> "BTC-Nazar Mohamed"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21012758701",
        "Driver_Name"=> "BTC-Magdi"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21014108501",
        "Driver_Name"=> "BTC-Ramesh Manda"
        ],
        [
        "Station_Name"=> "Hafer Al Batin Station",
        "Driver_Code"=> "D21014224401",
        "Driver_Name"=> "BTC Abu Bokkar Siddik"
        ],
        [
        "Station_Name"=> "Tabuk Station",
        "Driver_Code"=> "D21014305601",
        "Driver_Name"=> "BTC-Hisham Ahmed"
        ],
        [
        "Station_Name"=> "Az Zulfi Station",
        "Driver_Code"=> "D2106922001",
        "Driver_Name"=> "BTC-Waleed Abdul Wahid Abdulsalam Qaid Ahmed"
        ],
        ];
        $count = 0;
        foreach($data as $record){
            $job_id = $record['Driver_Code'];
            $Driver_Name = $record['Driver_Name'];
            $chk = DB::update("UPDATE drivers SET fullName = '$Driver_Name' WHERE job_id = '$job_id'");
            if ($chk) {
                echo $job_id . '<br>';
                $count++;
            }
        }
        dd($count);
    }






    function onesignal($user_id,$msg){

    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.onesignal.com/notifications?c=push",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode([
        'contents' => [
            'en' => 'Sharoze b-time'
        ],
        'include_aliases' => [
            'external_id' => [
                '15397'
                ]
            ]
        ,
        'app_id'=>'039a8b34-ae9b-431e-9ebd-3eb533432d2f',
        'target_channel'=>'push',
      ]),
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json",
        "Authorization: Basic OGVjYTY3NGMtOTQyZi00NGY1LWJhN2ItNjE3YzBkZGRhYzYw"
      ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
    }
    public function contract_method($contract_id){

        $drivers = DB::select("SELECT * FROM `drivers_contracts` where reference_no='".$contract_id."'");
         if(count($drivers)>0){
             foreach($drivers as $driver){
                    $driverDB = DB::select("select * from drivers where job_id='NG".$driver->job_id."' ");
                    $driverDB = DB::select("UPDATE `drivers_contracts` SET `driver_signed_date`='".$driverDB[0]->created_at."' WHERE `job_id`='".$driver->job_id."' ");
                }
                return view("Ninga",compact('drivers'));
             }else{
                 echo("رقم عقد العمل غير صحيح");
             }

    }
    public function updateDriver(){
        $payload = "'P_BTC_66_NDD_TIF',
'P_BTC_70_NDD_TIF',
'P_BTC_67_NDD_TIF',
'P_BTC_69_NDD_TIF',
'P_BTC_71_NDD_TIF',
'P_BTC_54_NDD_TIF',
'P_BTC_72_NDD_TIF'
";

        $payload = json_encode($payload);
        dd($payload);
        foreach($payload as $users){

            $db_driver = Drivers::where("job_id",$users[1])->get();
            if(count($db_driver)>0){
                $db_driver = $db_driver[0];
                $db_driver->fullName = $users[2];
                $db_driver->save();
            }else{

            }
        }


    }
    public function apiLandmark(Request $req){
        $LM_drivers = '
  [
    {
      "driver_id": 9730,
      "job_id": "LM0089",
      "jpurnal_item": [
        {
          "id": 42939,
          "driverId": 9730
        }
      ]
    },
    {
      "driver_id": 11176,
      "job_id": "LM0309",
      "jpurnal_item": [
        {
          "id": 47224,
          "driverId": 11176
        }
      ]
    },
    {
      "driver_id": 11173,
      "job_id": "P_BTC_65",
      "jpurnal_item": [
        {
          "id": 47221,
          "driverId": 11173
        },
        {
          "id": 48310,
          "driverId": 11173
        }
      ]
    },
    {
      "driver_id": 8843,
      "job_id": "F_BTC_27_NDD_MED",
      "jpurnal_item": [
        {
          "id": 42932,
          "driverId": 8843
        },
        {
          "id": 44330,
          "driverId": 8843
        },
        {
          "id": 45145,
          "driverId": 8843
        },
        {
          "id": 45899,
          "driverId": 8843
        },
        {
          "id": 47220,
          "driverId": 8843
        },
        {
          "id": 48309,
          "driverId": 8843
        },
        {
          "id": 49219,
          "driverId": 8843
        },
        {
          "id": 50031,
          "driverId": 8843
        },
        {
          "id": 50770,
          "driverId": 8843
        },
        {
          "id": 51508,
          "driverId": 8843
        },
        {
          "id": 52254,
          "driverId": 8843
        },
        {
          "id": 52868,
          "driverId": 8843
        },
        {
          "id": 53425,
          "driverId": 8843
        },
        {
          "id": 54086,
          "driverId": 8843
        },
        {
          "id": 54511,
          "driverId": 8843
        }
      ]
    },
    {
      "driver_id": 9723,
      "job_id": "LM00999",
      "jpurnal_item": [
        {
          "id": 42937,
          "driverId": 9723
        }
      ]
    },
    {
      "driver_id": 9949,
      "job_id": "LM0121",
      "jpurnal_item": [
        {
          "id": 42947,
          "driverId": 9949
        },
        {
          "id": 44339,
          "driverId": 9949
        }
      ]
    },
    {
      "driver_id": 8962,
      "job_id": "LM0031",
      "jpurnal_item": [
        {
          "id": 42933,
          "driverId": 8962
        },
        {
          "id": 44331,
          "driverId": 8962
        },
        {
          "id": 45144,
          "driverId": 8962
        }
      ]
    },
    {
      "driver_id": 9544,
      "job_id": "LM0058",
      "jpurnal_item": [
        {
          "id": 42934,
          "driverId": 9544
        }
      ]
    },
    {
      "driver_id": 9548,
      "job_id": "LM0063",
      "jpurnal_item": [
        {
          "id": 42950,
          "driverId": 9548
        },
        {
          "id": 44325,
          "driverId": 9548
        }
      ]
    },
    {
      "driver_id": 9729,
      "job_id": "LM0088",
      "jpurnal_item": [
        {
          "id": 42938,
          "driverId": 9729
        },
        {
          "id": 44334,
          "driverId": 9729
        }
      ]
    },
    {
      "driver_id": 9720,
      "job_id": "LM00996",
      "jpurnal_item": [
        {
          "id": 42940,
          "driverId": 9720
        }
      ]
    },
    {
      "driver_id": 9725,
      "job_id": "LM0083",
      "jpurnal_item": [
        {
          "id": 42943,
          "driverId": 9725
        },
        {
          "id": 44336,
          "driverId": 9725
        },
        {
          "id": 45143,
          "driverId": 9725
        }
      ]
    },
    {
      "driver_id": 9727,
      "job_id": "LM0085",
      "jpurnal_item": [
        {
          "id": 42944,
          "driverId": 9727
        },
        {
          "id": 44337,
          "driverId": 9727
        }
      ]
    },
    {
      "driver_id": 9728,
      "job_id": "LM0087",
      "jpurnal_item": [
        {
          "id": 42945,
          "driverId": 9728
        },
        {
          "id": 44338,
          "driverId": 9728
        }
      ]
    },
    {
      "driver_id": 9722,
      "job_id": "LM00998",
      "jpurnal_item": [
        {
          "id": 42942,
          "driverId": 9722
        },
        {
          "id": 44335,
          "driverId": 9722
        }
      ]
    },
    {
      "driver_id": 9721,
      "job_id": "LM00997",
      "jpurnal_item": [
        {
          "id": 42941,
          "driverId": 9721
        }
      ]
    },
    {
      "driver_id": 11654,
      "job_id": "P_BTC_85",
      "jpurnal_item": [
        {
          "id": 48315,
          "driverId": 11654
        }
      ]
    },
    {
      "driver_id": 9562,
      "job_id": "LM0074",
      "jpurnal_item": [
        {
          "id": 42936,
          "driverId": 9562
        },
        {
          "id": 44333,
          "driverId": 9562
        }
      ]
    },
    {
      "driver_id": 11657,
      "job_id": "P_BTC_93",
      "jpurnal_item": [
        {
          "id": 48318,
          "driverId": 11657
        }
      ]
    },
    {
      "driver_id": 10181,
      "job_id": "LM0140",
      "jpurnal_item": [
        {
          "id": 44341,
          "driverId": 10181
        },
        {
          "id": 45142,
          "driverId": 10181
        }
      ]
    },
    {
      "driver_id": 9545,
      "job_id": "LM0060",
      "jpurnal_item": [
        {
          "id": 42935,
          "driverId": 9545
        },
        {
          "id": 44332,
          "driverId": 9545
        }
      ]
    },
    {
      "driver_id": 11174,
      "job_id": "P_BTC_66",
      "jpurnal_item": [
        {
          "id": 47222,
          "driverId": 11174
        },
        {
          "id": 48311,
          "driverId": 11174
        }
      ]
    },
    {
      "driver_id": 9967,
      "job_id": "LM0124",
      "jpurnal_item": [
        {
          "id": 42955,
          "driverId": 9967
        },
        {
          "id": 44329,
          "driverId": 9967
        }
      ]
    },
    {
      "driver_id": 11656,
      "job_id": "P_BTC_92",
      "jpurnal_item": [
        {
          "id": 48317,
          "driverId": 11656
        }
      ]
    },
    {
      "driver_id": 9726,
      "job_id": "LM0084",
      "jpurnal_item": [
        {
          "id": 42946,
          "driverId": 9726
        }
      ]
    },
    {
      "driver_id": 9951,
      "job_id": "LM0123",
      "jpurnal_item": [
        {
          "id": 42953,
          "driverId": 9951
        },
        {
          "id": 44327,
          "driverId": 9951
        }
      ]
    },
    {
      "driver_id": 9549,
      "job_id": "LM0064",
      "jpurnal_item": [
        {
          "id": 42952,
          "driverId": 9549
        },
        {
          "id": 44326,
          "driverId": 9549
        }
      ]
    },
    {
      "driver_id": 9948,
      "job_id": "LM0120",
      "jpurnal_item": [
        {
          "id": 42948,
          "driverId": 9948
        },
        {
          "id": 44340,
          "driverId": 9948
        }
      ]
    },
    {
      "driver_id": 9950,
      "job_id": "LM0122",
      "jpurnal_item": [
        {
          "id": 42954,
          "driverId": 9950
        },
        {
          "id": 44328,
          "driverId": 9950
        }
      ]
    },
    {
      "driver_id": 11651,
      "job_id": "P_BTC_82",
      "jpurnal_item": [
        {
          "id": 48312,
          "driverId": 11651
        }
      ]
    },
    {
      "driver_id": 9547,
      "job_id": "LM0062",
      "jpurnal_item": [
        {
          "id": 42949,
          "driverId": 9547
        }
      ]
    },
    {
      "driver_id": 11652,
      "job_id": "P_BTC_83",
      "jpurnal_item": [
        {
          "id": 48313,
          "driverId": 11652
        },
        {
          "id": 49220,
          "driverId": 11652
        }
      ]
    },
    {
      "driver_id": 11655,
      "job_id": "P_BTC_86",
      "jpurnal_item": [
        {
          "id": 48316,
          "driverId": 11655
        }
      ]
    },
    {
      "driver_id": 9550,
      "job_id": "LM0065",
      "jpurnal_item": [
        {
          "id": 42951,
          "driverId": 9550
        }
      ]
    },
    {
      "driver_id": 11653,
      "job_id": "P_BTC_84",
      "jpurnal_item": [
        {
          "id": 48314,
          "driverId": 11653
        },
        {
          "id": 49221,
          "driverId": 11653
        }
      ]
    },
    {
      "driver_id": 8735,
      "job_id": "P_BTC_08_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43196,
          "driverId": 8735
        },
        {
          "id": 44347,
          "driverId": 8735
        },
        {
          "id": 45168,
          "driverId": 8735
        },
        {
          "id": 46145,
          "driverId": 8735
        },
        {
          "id": 47310,
          "driverId": 8735
        },
        {
          "id": 48474,
          "driverId": 8735
        },
        {
          "id": 49183,
          "driverId": 8735
        },
        {
          "id": 50070,
          "driverId": 8735
        },
        {
          "id": 52260,
          "driverId": 8735
        },
        {
          "id": 52857,
          "driverId": 8735
        },
        {
          "id": 53436,
          "driverId": 8735
        },
        {
          "id": 54108,
          "driverId": 8735
        }
      ]
    },
    {
      "driver_id": 8737,
      "job_id": "LM0022",
      "jpurnal_item": [
        {
          "id": 43195,
          "driverId": 8737
        },
        {
          "id": 44346,
          "driverId": 8737
        }
      ]
    },
    {
      "driver_id": 8738,
      "job_id": "P_BTC_04_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 43179,
          "driverId": 8738
        },
        {
          "id": 44368,
          "driverId": 8738
        },
        {
          "id": 45184,
          "driverId": 8738
        },
        {
          "id": 46132,
          "driverId": 8738
        },
        {
          "id": 47328,
          "driverId": 8738
        },
        {
          "id": 49164,
          "driverId": 8738
        },
        {
          "id": 50054,
          "driverId": 8738
        },
        {
          "id": 50756,
          "driverId": 8738
        },
        {
          "id": 51582,
          "driverId": 8738
        },
        {
          "id": 52277,
          "driverId": 8738
        },
        {
          "id": 53448,
          "driverId": 8738
        }
      ]
    },
    {
      "driver_id": 8739,
      "job_id": "P_BTC_04_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43194,
          "driverId": 8739
        },
        {
          "id": 44344,
          "driverId": 8739
        },
        {
          "id": 45167,
          "driverId": 8739
        },
        {
          "id": 46143,
          "driverId": 8739
        },
        {
          "id": 47311,
          "driverId": 8739
        },
        {
          "id": 48473,
          "driverId": 8739
        },
        {
          "id": 49181,
          "driverId": 8739
        },
        {
          "id": 50068,
          "driverId": 8739
        },
        {
          "id": 50738,
          "driverId": 8739
        },
        {
          "id": 51564,
          "driverId": 8739
        },
        {
          "id": 52259,
          "driverId": 8739
        }
      ]
    },
    {
      "driver_id": 8946,
      "job_id": "P_BTC_15_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43200,
          "driverId": 8946
        },
        {
          "id": 44353,
          "driverId": 8946
        },
        {
          "id": 45171,
          "driverId": 8946
        },
        {
          "id": 46148,
          "driverId": 8946
        },
        {
          "id": 47308,
          "driverId": 8946
        },
        {
          "id": 48476,
          "driverId": 8946
        },
        {
          "id": 52263,
          "driverId": 8946
        },
        {
          "id": 52855,
          "driverId": 8946
        },
        {
          "id": 53428,
          "driverId": 8946
        },
        {
          "id": 54109,
          "driverId": 8946
        },
        {
          "id": 54674,
          "driverId": 8946
        }
      ]
    },
    {
      "driver_id": 8947,
      "job_id": "P_BTC_17_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43201,
          "driverId": 8947
        },
        {
          "id": 44355,
          "driverId": 8947
        },
        {
          "id": 46149,
          "driverId": 8947
        },
        {
          "id": 47307,
          "driverId": 8947
        },
        {
          "id": 48477,
          "driverId": 8947
        },
        {
          "id": 52854,
          "driverId": 8947
        },
        {
          "id": 53427,
          "driverId": 8947
        },
        {
          "id": 54110,
          "driverId": 8947
        },
        {
          "id": 54675,
          "driverId": 8947
        }
      ]
    },
    {
      "driver_id": 9209,
      "job_id": "LM0035",
      "jpurnal_item": [
        {
          "id": 43203,
          "driverId": 9209
        },
        {
          "id": 44358,
          "driverId": 9209
        },
        {
          "id": 45173,
          "driverId": 9209
        },
        {
          "id": 47305,
          "driverId": 9209
        },
        {
          "id": 48479,
          "driverId": 9209
        },
        {
          "id": 49187,
          "driverId": 9209
        }
      ]
    },
    {
      "driver_id": 9210,
      "job_id": "P_BTC_23_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43204,
          "driverId": 9210
        },
        {
          "id": 44359,
          "driverId": 9210
        },
        {
          "id": 45174,
          "driverId": 9210
        },
        {
          "id": 46152,
          "driverId": 9210
        },
        {
          "id": 47304,
          "driverId": 9210
        },
        {
          "id": 48480,
          "driverId": 9210
        },
        {
          "id": 49188,
          "driverId": 9210
        },
        {
          "id": 52852,
          "driverId": 9210
        },
        {
          "id": 53429,
          "driverId": 9210
        },
        {
          "id": 54112,
          "driverId": 9210
        }
      ]
    },
    {
      "driver_id": 9211,
      "job_id": "P_BTC_20_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43202,
          "driverId": 9211
        },
        {
          "id": 44357,
          "driverId": 9211
        },
        {
          "id": 45172,
          "driverId": 9211
        },
        {
          "id": 46151,
          "driverId": 9211
        },
        {
          "id": 47306,
          "driverId": 9211
        },
        {
          "id": 48478,
          "driverId": 9211
        },
        {
          "id": 52853,
          "driverId": 9211
        },
        {
          "id": 53435,
          "driverId": 9211
        }
      ]
    },
    {
      "driver_id": 9569,
      "job_id": "LM0076",
      "jpurnal_item": [
        {
          "id": 43183,
          "driverId": 9569
        },
        {
          "id": 44367,
          "driverId": 9569
        },
        {
          "id": 45164,
          "driverId": 9569
        },
        {
          "id": 46133,
          "driverId": 9569
        },
        {
          "id": 47287,
          "driverId": 9569
        },
        {
          "id": 48464,
          "driverId": 9569
        }
      ]
    },
    {
      "driver_id": 9571,
      "job_id": "LM0078",
      "jpurnal_item": [
        {
          "id": 43205,
          "driverId": 9571
        }
      ]
    },
    {
      "driver_id": 9572,
      "job_id": "LM0079",
      "jpurnal_item": [
        {
          "id": 43219,
          "driverId": 9572
        },
        {
          "id": 46154,
          "driverId": 9572
        }
      ]
    },
    {
      "driver_id": 9573,
      "job_id": "P_BTC_27_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43207,
          "driverId": 9573
        },
        {
          "id": 44361,
          "driverId": 9573
        },
        {
          "id": 45176,
          "driverId": 9573
        },
        {
          "id": 46155,
          "driverId": 9573
        },
        {
          "id": 47302,
          "driverId": 9573
        },
        {
          "id": 48482,
          "driverId": 9573
        },
        {
          "id": 50745,
          "driverId": 9573
        },
        {
          "id": 51570,
          "driverId": 9573
        },
        {
          "id": 52267,
          "driverId": 9573
        },
        {
          "id": 52851,
          "driverId": 9573
        },
        {
          "id": 53433,
          "driverId": 9573
        },
        {
          "id": 54113,
          "driverId": 9573
        },
        {
          "id": 54677,
          "driverId": 9573
        }
      ]
    },
    {
      "driver_id": 9748,
      "job_id": "LM00104",
      "jpurnal_item": [
        {
          "id": 43218,
          "driverId": 9748
        }
      ]
    },
    {
      "driver_id": 9752,
      "job_id": "LM00108",
      "jpurnal_item": [
        {
          "id": 43220,
          "driverId": 9752
        },
        {
          "id": 44362,
          "driverId": 9752
        },
        {
          "id": 45163,
          "driverId": 9752
        }
      ]
    },
    {
      "driver_id": 9804,
      "job_id": "P_BTC_36_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43193,
          "driverId": 9804
        },
        {
          "id": 44366,
          "driverId": 9804
        },
        {
          "id": 45181,
          "driverId": 9804
        },
        {
          "id": 46134,
          "driverId": 9804
        },
        {
          "id": 47318,
          "driverId": 9804
        },
        {
          "id": 48499,
          "driverId": 9804
        },
        {
          "id": 49166,
          "driverId": 9804
        },
        {
          "id": 50055,
          "driverId": 9804
        },
        {
          "id": 50746,
          "driverId": 9804
        },
        {
          "id": 51571,
          "driverId": 9804
        },
        {
          "id": 52268,
          "driverId": 9804
        },
        {
          "id": 52863,
          "driverId": 9804
        },
        {
          "id": 53459,
          "driverId": 9804
        }
      ]
    },
    {
      "driver_id": 9813,
      "job_id": "P_BTC_30",
      "jpurnal_item": [
        {
          "id": 43209,
          "driverId": 9813
        },
        {
          "id": 44364,
          "driverId": 9813
        }
      ]
    },
    {
      "driver_id": 9980,
      "job_id": "LM00120",
      "jpurnal_item": [
        {
          "id": 43191,
          "driverId": 9980
        },
        {
          "id": 44371,
          "driverId": 9980
        }
      ]
    },
    {
      "driver_id": 10140,
      "job_id": "P_BTC_18_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 44373,
          "driverId": 10140
        },
        {
          "id": 45182,
          "driverId": 10140
        },
        {
          "id": 46137,
          "driverId": 10140
        },
        {
          "id": 47317,
          "driverId": 10140
        },
        {
          "id": 48504,
          "driverId": 10140
        },
        {
          "id": 49170,
          "driverId": 10140
        },
        {
          "id": 50059,
          "driverId": 10140
        },
        {
          "id": 50760,
          "driverId": 10140
        },
        {
          "id": 51584,
          "driverId": 10140
        },
        {
          "id": 52279,
          "driverId": 10140
        }
      ]
    },
    {
      "driver_id": 10161,
      "job_id": "LM0125",
      "jpurnal_item": [
        {
          "id": 43197,
          "driverId": 10161
        },
        {
          "id": 44349,
          "driverId": 10161
        },
        {
          "id": 45169,
          "driverId": 10161
        }
      ]
    },
    {
      "driver_id": 10162,
      "job_id": "LM0126",
      "jpurnal_item": [
        {
          "id": 43185,
          "driverId": 10162
        },
        {
          "id": 47327,
          "driverId": 10162
        },
        {
          "id": 48500,
          "driverId": 10162
        }
      ]
    },
    {
      "driver_id": 10163,
      "job_id": "P_BTC_11_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 43186,
          "driverId": 10163
        },
        {
          "id": 44369,
          "driverId": 10163
        },
        {
          "id": 46135,
          "driverId": 10163
        },
        {
          "id": 47326,
          "driverId": 10163
        },
        {
          "id": 49167,
          "driverId": 10163
        },
        {
          "id": 50056,
          "driverId": 10163
        },
        {
          "id": 50757,
          "driverId": 10163
        },
        {
          "id": 51583,
          "driverId": 10163
        },
        {
          "id": 52278,
          "driverId": 10163
        }
      ]
    },
    {
      "driver_id": 10164,
      "job_id": "LM0128",
      "jpurnal_item": [
        {
          "id": 43187,
          "driverId": 10164
        },
        {
          "id": 44370,
          "driverId": 10164
        },
        {
          "id": 45185,
          "driverId": 10164
        },
        {
          "id": 47325,
          "driverId": 10164
        },
        {
          "id": 48501,
          "driverId": 10164
        }
      ]
    },
    {
      "driver_id": 10166,
      "job_id": "LM0129",
      "jpurnal_item": [
        {
          "id": 43198,
          "driverId": 10166
        },
        {
          "id": 44351,
          "driverId": 10166
        }
      ]
    },
    {
      "driver_id": 10167,
      "job_id": "LM0130",
      "jpurnal_item": [
        {
          "id": 43189,
          "driverId": 10167
        },
        {
          "id": 47324,
          "driverId": 10167
        },
        {
          "id": 48502,
          "driverId": 10167
        }
      ]
    },
    {
      "driver_id": 10169,
      "job_id": "P_BTC_17_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 43192,
          "driverId": 10169
        },
        {
          "id": 44372,
          "driverId": 10169
        },
        {
          "id": 45186,
          "driverId": 10169
        },
        {
          "id": 46136,
          "driverId": 10169
        },
        {
          "id": 47322,
          "driverId": 10169
        },
        {
          "id": 49169,
          "driverId": 10169
        },
        {
          "id": 50058,
          "driverId": 10169
        },
        {
          "id": 50759,
          "driverId": 10169
        }
      ]
    },
    {
      "driver_id": 10170,
      "job_id": "P_BTC_25_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43206,
          "driverId": 10170
        },
        {
          "id": 44360,
          "driverId": 10170
        },
        {
          "id": 45175,
          "driverId": 10170
        },
        {
          "id": 46153,
          "driverId": 10170
        },
        {
          "id": 47303,
          "driverId": 10170
        },
        {
          "id": 48481,
          "driverId": 10170
        },
        {
          "id": 49189,
          "driverId": 10170
        },
        {
          "id": 50743,
          "driverId": 10170
        },
        {
          "id": 51568,
          "driverId": 10170
        },
        {
          "id": 52265,
          "driverId": 10170
        }
      ]
    },
    {
      "driver_id": 10171,
      "job_id": "LM0134",
      "jpurnal_item": [
        {
          "id": 43208,
          "driverId": 10171
        },
        {
          "id": 44363,
          "driverId": 10171
        },
        {
          "id": 48483,
          "driverId": 10171
        }
      ]
    },
    {
      "driver_id": 10172,
      "job_id": "LM0135",
      "jpurnal_item": [
        {
          "id": 43210,
          "driverId": 10172
        },
        {
          "id": 44365,
          "driverId": 10172
        }
      ]
    },
    {
      "driver_id": 10173,
      "job_id": "LM0136",
      "jpurnal_item": [
        {
          "id": 43211,
          "driverId": 10173
        },
        {
          "id": 45177,
          "driverId": 10173
        },
        {
          "id": 48484,
          "driverId": 10173
        }
      ]
    },
    {
      "driver_id": 10174,
      "job_id": "LM0137",
      "jpurnal_item": [
        {
          "id": 43212,
          "driverId": 10174
        },
        {
          "id": 45178,
          "driverId": 10174
        }
      ]
    },
    {
      "driver_id": 10175,
      "job_id": "LM0138",
      "jpurnal_item": [
        {
          "id": 43213,
          "driverId": 10175
        }
      ]
    },
    {
      "driver_id": 10176,
      "job_id": "LM0139",
      "jpurnal_item": [
        {
          "id": 43214,
          "driverId": 10176
        }
      ]
    },
    {
      "driver_id": 10334,
      "job_id": "P_BTC_15_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 43188,
          "driverId": 10334
        },
        {
          "id": 48503,
          "driverId": 10334
        },
        {
          "id": 49168,
          "driverId": 10334
        },
        {
          "id": 50057,
          "driverId": 10334
        },
        {
          "id": 50758,
          "driverId": 10334
        }
      ]
    },
    {
      "driver_id": 10489,
      "job_id": "LM0204",
      "jpurnal_item": [
        {
          "id": 45179,
          "driverId": 10489
        },
        {
          "id": 46157,
          "driverId": 10489
        },
        {
          "id": 47301,
          "driverId": 10489
        },
        {
          "id": 48485,
          "driverId": 10489
        },
        {
          "id": 49192,
          "driverId": 10489
        }
      ]
    },
    {
      "driver_id": 10545,
      "job_id": "LM0212",
      "jpurnal_item": [
        {
          "id": 45183,
          "driverId": 10545
        },
        {
          "id": 46138,
          "driverId": 10545
        },
        {
          "id": 47316,
          "driverId": 10545
        }
      ]
    },
    {
      "driver_id": 10751,
      "job_id": "P_BTC_42_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 46160,
          "driverId": 10751
        },
        {
          "id": 47285,
          "driverId": 10751
        },
        {
          "id": 48466,
          "driverId": 10751
        },
        {
          "id": 49194,
          "driverId": 10751
        },
        {
          "id": 50076,
          "driverId": 10751
        },
        {
          "id": 50748,
          "driverId": 10751
        },
        {
          "id": 51573,
          "driverId": 10751
        },
        {
          "id": 52270,
          "driverId": 10751
        },
        {
          "id": 52861,
          "driverId": 10751
        },
        {
          "id": 53457,
          "driverId": 10751
        }
      ]
    },
    {
      "driver_id": 10752,
      "job_id": "LM0218",
      "jpurnal_item": [
        {
          "id": 45166,
          "driverId": 10752
        },
        {
          "id": 46158,
          "driverId": 10752
        }
      ]
    },
    {
      "driver_id": 10754,
      "job_id": "LM0220",
      "jpurnal_item": [
        {
          "id": 45180,
          "driverId": 10754
        },
        {
          "id": 46159,
          "driverId": 10754
        },
        {
          "id": 47300,
          "driverId": 10754
        },
        {
          "id": 48486,
          "driverId": 10754
        },
        {
          "id": 49193,
          "driverId": 10754
        }
      ]
    },
    {
      "driver_id": 10755,
      "job_id": "P_BTC_43_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 46161,
          "driverId": 10755
        },
        {
          "id": 47299,
          "driverId": 10755
        },
        {
          "id": 48487,
          "driverId": 10755
        },
        {
          "id": 49195,
          "driverId": 10755
        },
        {
          "id": 51574,
          "driverId": 10755
        },
        {
          "id": 52271,
          "driverId": 10755
        },
        {
          "id": 53440,
          "driverId": 10755
        },
        {
          "id": 54678,
          "driverId": 10755
        }
      ]
    },
    {
      "driver_id": 10768,
      "job_id": "P_BTC_26_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 45162,
          "driverId": 10768
        },
        {
          "id": 48463,
          "driverId": 10768
        },
        {
          "id": 49190,
          "driverId": 10768
        },
        {
          "id": 50074,
          "driverId": 10768
        },
        {
          "id": 50744,
          "driverId": 10768
        },
        {
          "id": 51569,
          "driverId": 10768
        },
        {
          "id": 52266,
          "driverId": 10768
        },
        {
          "id": 54683,
          "driverId": 10768
        }
      ]
    },
    {
      "driver_id": 10783,
      "job_id": "LM0226",
      "jpurnal_item": [
        {
          "id": 46162,
          "driverId": 10783
        },
        {
          "id": 47298,
          "driverId": 10783
        },
        {
          "id": 48488,
          "driverId": 10783
        }
      ]
    },
    {
      "driver_id": 10854,
      "job_id": "LM0227",
      "jpurnal_item": [
        {
          "id": 46164,
          "driverId": 10854
        },
        {
          "id": 47284,
          "driverId": 10854
        }
      ]
    },
    {
      "driver_id": 10855,
      "job_id": "P_BTC_45_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 46163,
          "driverId": 10855
        },
        {
          "id": 47297,
          "driverId": 10855
        },
        {
          "id": 48489,
          "driverId": 10855
        },
        {
          "id": 50077,
          "driverId": 10855
        },
        {
          "id": 50749,
          "driverId": 10855
        },
        {
          "id": 51575,
          "driverId": 10855
        },
        {
          "id": 52272,
          "driverId": 10855
        },
        {
          "id": 52850,
          "driverId": 10855
        },
        {
          "id": 53430,
          "driverId": 10855
        },
        {
          "id": 54115,
          "driverId": 10855
        }
      ]
    },
    {
      "driver_id": 11010,
      "job_id": "LM0239",
      "jpurnal_item": [
        {
          "id": 47313,
          "driverId": 11010
        },
        {
          "id": 48508,
          "driverId": 11010
        },
        {
          "id": 49172,
          "driverId": 11010
        }
      ]
    },
    {
      "driver_id": 11012,
      "job_id": "LM0241",
      "jpurnal_item": [
        {
          "id": 47312,
          "driverId": 11012
        }
      ]
    },
    {
      "driver_id": 11013,
      "job_id": "P_BTC_47_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 47283,
          "driverId": 11013
        },
        {
          "id": 48467,
          "driverId": 11013
        },
        {
          "id": 49196,
          "driverId": 11013
        },
        {
          "id": 50064,
          "driverId": 11013
        },
        {
          "id": 50750,
          "driverId": 11013
        },
        {
          "id": 51576,
          "driverId": 11013
        },
        {
          "id": 52273,
          "driverId": 11013
        },
        {
          "id": 52860,
          "driverId": 11013
        },
        {
          "id": 53455,
          "driverId": 11013
        },
        {
          "id": 54116,
          "driverId": 11013
        },
        {
          "id": 54685,
          "driverId": 11013
        }
      ]
    },
    {
      "driver_id": 11029,
      "job_id": "P_BTC_48_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 47296,
          "driverId": 11029
        },
        {
          "id": 48490,
          "driverId": 11029
        },
        {
          "id": 50751,
          "driverId": 11029
        },
        {
          "id": 53432,
          "driverId": 11029
        },
        {
          "id": 54117,
          "driverId": 11029
        },
        {
          "id": 54679,
          "driverId": 11029
        }
      ]
    },
    {
      "driver_id": 11030,
      "job_id": "LM0244",
      "jpurnal_item": [
        {
          "id": 47295,
          "driverId": 11030
        },
        {
          "id": 48491,
          "driverId": 11030
        }
      ]
    },
    {
      "driver_id": 11031,
      "job_id": "LM0245",
      "jpurnal_item": [
        {
          "id": 47294,
          "driverId": 11031
        },
        {
          "id": 48492,
          "driverId": 11031
        },
        {
          "id": 49197,
          "driverId": 11031
        }
      ]
    },
    {
      "driver_id": 11032,
      "job_id": "LM0246",
      "jpurnal_item": [
        {
          "id": 47293,
          "driverId": 11032
        },
        {
          "id": 48493,
          "driverId": 11032
        }
      ]
    },
    {
      "driver_id": 11033,
      "job_id": "LM0247",
      "jpurnal_item": [
        {
          "id": 47292,
          "driverId": 11033
        },
        {
          "id": 48494,
          "driverId": 11033
        }
      ]
    },
    {
      "driver_id": 11133,
      "job_id": "P_BTC_53_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 48495,
          "driverId": 11133
        },
        {
          "id": 50752,
          "driverId": 11133
        },
        {
          "id": 51577,
          "driverId": 11133
        },
        {
          "id": 53438,
          "driverId": 11133
        }
      ]
    },
    {
      "driver_id": 11135,
      "job_id": "LM0252",
      "jpurnal_item": [
        {
          "id": 48468,
          "driverId": 11135
        }
      ]
    },
    {
      "driver_id": 11424,
      "job_id": "P_BTC_58_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 48470,
          "driverId": 11424
        },
        {
          "id": 49198,
          "driverId": 11424
        },
        {
          "id": 50078,
          "driverId": 11424
        },
        {
          "id": 50753,
          "driverId": 11424
        },
        {
          "id": 51578,
          "driverId": 11424
        },
        {
          "id": 52274,
          "driverId": 11424
        },
        {
          "id": 52859,
          "driverId": 11424
        },
        {
          "id": 53449,
          "driverId": 11424
        },
        {
          "id": 54118,
          "driverId": 11424
        },
        {
          "id": 54686,
          "driverId": 11424
        }
      ]
    },
    {
      "driver_id": 11425,
      "job_id": "LM0311",
      "jpurnal_item": [
        {
          "id": 48496,
          "driverId": 11425
        }
      ]
    },
    {
      "driver_id": 11426,
      "job_id": "LM0312",
      "jpurnal_item": [
        {
          "id": 48469,
          "driverId": 11426
        }
      ]
    },
    {
      "driver_id": 11427,
      "job_id": "LM0313",
      "jpurnal_item": [
        {
          "id": 48497,
          "driverId": 11427
        }
      ]
    },
    {
      "driver_id": 11428,
      "job_id": "LM0314",
      "jpurnal_item": [
        {
          "id": 48472,
          "driverId": 11428
        },
        {
          "id": 49173,
          "driverId": 11428
        }
      ]
    },
    {
      "driver_id": 11675,
      "job_id": "p_btc_61",
      "jpurnal_item": [
        {
          "id": 48471,
          "driverId": 11675
        }
      ]
    },
    {
      "driver_id": 11770,
      "job_id": "P_BTC_65_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 50754,
          "driverId": 11770
        },
        {
          "id": 51579,
          "driverId": 11770
        },
        {
          "id": 52275,
          "driverId": 11770
        }
      ]
    },
    {
      "driver_id": 11771,
      "job_id": "LM0316",
      "jpurnal_item": [
        {
          "id": 50063,
          "driverId": 11771
        }
      ]
    },
    {
      "driver_id": 11867,
      "job_id": "P_BTC_64",
      "jpurnal_item": [
        {
          "id": 49199,
          "driverId": 11867
        }
      ]
    },
    {
      "driver_id": 13279,
      "job_id": "P_BTC_23_NDD_TI",
      "jpurnal_item": [
        {
          "id": 50761,
          "driverId": 13279
        },
        {
          "id": 51585,
          "driverId": 13279
        }
      ]
    },
    {
      "driver_id": 13461,
      "job_id": "P_BTC_68_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 52276,
          "driverId": 13461
        },
        {
          "id": 52858,
          "driverId": 13461
        },
        {
          "id": 53454,
          "driverId": 13461
        },
        {
          "id": 54119,
          "driverId": 13461
        },
        {
          "id": 54688,
          "driverId": 13461
        }
      ]
    },
    {
      "driver_id": 13766,
      "job_id": "P_BTC_19_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 52864,
          "driverId": 13766
        },
        {
          "id": 53451,
          "driverId": 13766
        },
        {
          "id": 54111,
          "driverId": 13766
        },
        {
          "id": 54682,
          "driverId": 13766
        }
      ]
    },
    {
      "driver_id": 13862,
      "job_id": "P_BTC_71_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 52847,
          "driverId": 13862
        },
        {
          "id": 53439,
          "driverId": 13862
        },
        {
          "id": 54680,
          "driverId": 13862
        }
      ]
    },
    {
      "driver_id": 13863,
      "job_id": "P_BTC_70_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 52848,
          "driverId": 13863
        }
      ]
    },
    {
      "driver_id": 13864,
      "job_id": "P_BTC_69_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 52849,
          "driverId": 13864
        },
        {
          "id": 53434,
          "driverId": 13864
        }
      ]
    },
    {
      "driver_id": 13874,
      "job_id": "P_BTC_73_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53452,
          "driverId": 13874
        },
        {
          "id": 54120,
          "driverId": 13874
        },
        {
          "id": 54689,
          "driverId": 13874
        }
      ]
    },
    {
      "driver_id": 13875,
      "job_id": "P_BTC_75_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53453,
          "driverId": 13875
        },
        {
          "id": 54121,
          "driverId": 13875
        },
        {
          "id": 54690,
          "driverId": 13875
        }
      ]
    },
    {
      "driver_id": 13925,
      "job_id": "P_BTC_76_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53456,
          "driverId": 13925
        },
        {
          "id": 54122,
          "driverId": 13925
        },
        {
          "id": 54691,
          "driverId": 13925
        }
      ]
    },
    {
      "driver_id": 13926,
      "job_id": "P_BTC_78_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53467,
          "driverId": 13926
        }
      ]
    },
    {
      "driver_id": 13927,
      "job_id": "P_BTC_79_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53458,
          "driverId": 13927
        },
        {
          "id": 54124,
          "driverId": 13927
        },
        {
          "id": 54692,
          "driverId": 13927
        }
      ]
    },
    {
      "driver_id": 13928,
      "job_id": "P_BTC_74_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53468,
          "driverId": 13928
        }
      ]
    },
    {
      "driver_id": 13929,
      "job_id": "P_BTC_77_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53437,
          "driverId": 13929
        },
        {
          "id": 54123,
          "driverId": 13929
        }
      ]
    },
    {
      "driver_id": 13930,
      "job_id": "P_BTC_80_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53463,
          "driverId": 13930
        },
        {
          "id": 54125,
          "driverId": 13930
        }
      ]
    },
    {
      "driver_id": 13952,
      "job_id": "P_BTC_82_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53464,
          "driverId": 13952
        },
        {
          "id": 54126,
          "driverId": 13952
        }
      ]
    },
    {
      "driver_id": 13983,
      "job_id": "P_BTC_83_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53441,
          "driverId": 13983
        },
        {
          "id": 54127,
          "driverId": 13983
        }
      ]
    },
    {
      "driver_id": 14033,
      "job_id": "P_BTC_81_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53442,
          "driverId": 14033
        }
      ]
    },
    {
      "driver_id": 14040,
      "job_id": "P_BTC_72_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 53460,
          "driverId": 14040
        }
      ]
    },
    {
      "driver_id": 14255,
      "job_id": "P_BTC_89_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54697,
          "driverId": 14255
        }
      ]
    },
    {
      "driver_id": 14319,
      "job_id": "P_BTC_90_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54698,
          "driverId": 14319
        }
      ]
    },
    {
      "driver_id": 8666,
      "job_id": "P_BTC_11_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43180,
          "driverId": 8666
        },
        {
          "id": 44350,
          "driverId": 8666
        },
        {
          "id": 45159,
          "driverId": 8666
        },
        {
          "id": 49165,
          "driverId": 8666
        },
        {
          "id": 53466,
          "driverId": 8666
        }
      ]
    },
    {
      "driver_id": 10490,
      "job_id": "P_BTC_38_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 45165,
          "driverId": 10490
        },
        {
          "id": 46156,
          "driverId": 10490
        },
        {
          "id": 47286,
          "driverId": 10490
        },
        {
          "id": 48465,
          "driverId": 10490
        },
        {
          "id": 49191,
          "driverId": 10490
        },
        {
          "id": 50075,
          "driverId": 10490
        },
        {
          "id": 50747,
          "driverId": 10490
        },
        {
          "id": 51572,
          "driverId": 10490
        },
        {
          "id": 52269,
          "driverId": 10490
        },
        {
          "id": 53450,
          "driverId": 10490
        },
        {
          "id": 54114,
          "driverId": 10490
        },
        {
          "id": 54684,
          "driverId": 10490
        }
      ]
    },
    {
      "driver_id": 9574,
      "job_id": "P_BTC_16",
      "jpurnal_item": [
        {
          "id": 43184,
          "driverId": 9574
        },
        {
          "id": 44354,
          "driverId": 9574
        },
        {
          "id": 45160,
          "driverId": 9574
        }
      ]
    },
    {
      "driver_id": 8948,
      "job_id": "P_BTC_18_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43182,
          "driverId": 8948
        },
        {
          "id": 44356,
          "driverId": 8948
        },
        {
          "id": 45161,
          "driverId": 8948
        },
        {
          "id": 46150,
          "driverId": 8948
        },
        {
          "id": 47288,
          "driverId": 8948
        },
        {
          "id": 48462,
          "driverId": 8948
        },
        {
          "id": 49186,
          "driverId": 8948
        },
        {
          "id": 50073,
          "driverId": 8948
        },
        {
          "id": 50742,
          "driverId": 8948
        },
        {
          "id": 51567,
          "driverId": 8948
        },
        {
          "id": 52264,
          "driverId": 8948
        },
        {
          "id": 52865,
          "driverId": 8948
        },
        {
          "id": 53462,
          "driverId": 8948
        }
      ]
    },
    {
      "driver_id": 8619,
      "job_id": "P_BTC_05_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43177,
          "driverId": 8619
        },
        {
          "id": 44345,
          "driverId": 8619
        },
        {
          "id": 45157,
          "driverId": 8619
        },
        {
          "id": 46144,
          "driverId": 8619
        },
        {
          "id": 47290,
          "driverId": 8619
        },
        {
          "id": 48460,
          "driverId": 8619
        },
        {
          "id": 49182,
          "driverId": 8619
        },
        {
          "id": 50069,
          "driverId": 8619
        },
        {
          "id": 50739,
          "driverId": 8619
        }
      ]
    },
    {
      "driver_id": 8614,
      "job_id": "P_BTC_09_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43217,
          "driverId": 8614
        },
        {
          "id": 44348,
          "driverId": 8614
        },
        {
          "id": 45158,
          "driverId": 8614
        },
        {
          "id": 46146,
          "driverId": 8614
        },
        {
          "id": 47289,
          "driverId": 8614
        },
        {
          "id": 48461,
          "driverId": 8614
        },
        {
          "id": 49184,
          "driverId": 8614
        },
        {
          "id": 50071,
          "driverId": 8614
        },
        {
          "id": 50740,
          "driverId": 8614
        },
        {
          "id": 51565,
          "driverId": 8614
        },
        {
          "id": 52261,
          "driverId": 8614
        },
        {
          "id": 52867,
          "driverId": 8614
        },
        {
          "id": 53461,
          "driverId": 8614
        }
      ]
    },
    {
      "driver_id": 8615,
      "job_id": "LM003",
      "jpurnal_item": [
        {
          "id": 43216,
          "driverId": 8615
        }
      ]
    },
    {
      "driver_id": 8617,
      "job_id": "P_BTC_01_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43215,
          "driverId": 8617
        },
        {
          "id": 44342,
          "driverId": 8617
        },
        {
          "id": 45155,
          "driverId": 8617
        },
        {
          "id": 46142,
          "driverId": 8617
        },
        {
          "id": 47291,
          "driverId": 8617
        },
        {
          "id": 48459,
          "driverId": 8617
        },
        {
          "id": 49180,
          "driverId": 8617
        },
        {
          "id": 50067,
          "driverId": 8617
        },
        {
          "id": 50737,
          "driverId": 8617
        },
        {
          "id": 51563,
          "driverId": 8617
        },
        {
          "id": 52258,
          "driverId": 8617
        },
        {
          "id": 52866,
          "driverId": 8617
        },
        {
          "id": 53465,
          "driverId": 8617
        }
      ]
    },
    {
      "driver_id": 8618,
      "job_id": "LM006",
      "jpurnal_item": [
        {
          "id": 43178,
          "driverId": 8618
        }
      ]
    },
    {
      "driver_id": 13460,
      "job_id": "P_BTC_02_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54107,
          "driverId": 13460
        },
        {
          "id": 54681,
          "driverId": 13460
        }
      ]
    },
    {
      "driver_id": 8669,
      "job_id": "P_BTC_13_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 43199,
          "driverId": 8669
        },
        {
          "id": 44352,
          "driverId": 8669
        },
        {
          "id": 45170,
          "driverId": 8669
        },
        {
          "id": 46147,
          "driverId": 8669
        },
        {
          "id": 47309,
          "driverId": 8669
        },
        {
          "id": 48475,
          "driverId": 8669
        },
        {
          "id": 49185,
          "driverId": 8669
        },
        {
          "id": 50072,
          "driverId": 8669
        },
        {
          "id": 50741,
          "driverId": 8669
        },
        {
          "id": 51566,
          "driverId": 8669
        },
        {
          "id": 52262,
          "driverId": 8669
        },
        {
          "id": 52856,
          "driverId": 8669
        },
        {
          "id": 53431,
          "driverId": 8669
        },
        {
          "id": 54673,
          "driverId": 8669
        }
      ]
    },
    {
      "driver_id": 8731,
      "job_id": "LM0019",
      "jpurnal_item": [
        {
          "id": 43181,
          "driverId": 8731
        }
      ]
    },
    {
      "driver_id": 8621,
      "job_id": "LM008",
      "jpurnal_item": [
        {
          "id": 43176,
          "driverId": 8621
        },
        {
          "id": 44343,
          "driverId": 8621
        },
        {
          "id": 45156,
          "driverId": 8621
        }
      ]
    },
    {
      "driver_id": 10168,
      "job_id": "P_BTC_14_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 43190,
          "driverId": 10168
        },
        {
          "id": 47323,
          "driverId": 10168
        },
        {
          "id": 52840,
          "driverId": 10168
        },
        {
          "id": 53447,
          "driverId": 10168
        }
      ]
    },
    {
      "driver_id": 10753,
      "job_id": "LM0219",
      "jpurnal_item": [
        {
          "id": 46141,
          "driverId": 10753
        },
        {
          "id": 47315,
          "driverId": 10753
        }
      ]
    },
    {
      "driver_id": 10756,
      "job_id": "LM0222",
      "jpurnal_item": [
        {
          "id": 45187,
          "driverId": 10756
        },
        {
          "id": 46139,
          "driverId": 10756
        },
        {
          "id": 47321,
          "driverId": 10756
        },
        {
          "id": 48505,
          "driverId": 10756
        },
        {
          "id": 49171,
          "driverId": 10756
        }
      ]
    },
    {
      "driver_id": 10757,
      "job_id": "LM0223",
      "jpurnal_item": [
        {
          "id": 46140,
          "driverId": 10757
        },
        {
          "id": 47320,
          "driverId": 10757
        },
        {
          "id": 48506,
          "driverId": 10757
        }
      ]
    },
    {
      "driver_id": 11011,
      "job_id": "P_BTC_24_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 47314,
          "driverId": 11011
        },
        {
          "id": 52838,
          "driverId": 11011
        },
        {
          "id": 53445,
          "driverId": 11011
        }
      ]
    },
    {
      "driver_id": 11184,
      "job_id": "P_BTC_23_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 47319,
          "driverId": 11184
        },
        {
          "id": 48507,
          "driverId": 11184
        },
        {
          "id": 52280,
          "driverId": 11184
        },
        {
          "id": 52839,
          "driverId": 11184
        },
        {
          "id": 53444,
          "driverId": 11184
        }
      ]
    },
    {
      "driver_id": 11624,
      "job_id": "P_BTC_27",
      "jpurnal_item": [
        {
          "id": 49174,
          "driverId": 11624
        }
      ]
    },
    {
      "driver_id": 11625,
      "job_id": "P_BTC_28",
      "jpurnal_item": [
        {
          "id": 49175,
          "driverId": 11625
        }
      ]
    },
    {
      "driver_id": 11626,
      "job_id": "P_BTC_29_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 48498,
          "driverId": 11626
        },
        {
          "id": 49176,
          "driverId": 11626
        },
        {
          "id": 50060,
          "driverId": 11626
        },
        {
          "id": 50762,
          "driverId": 11626
        },
        {
          "id": 51586,
          "driverId": 11626
        },
        {
          "id": 52281,
          "driverId": 11626
        }
      ]
    },
    {
      "driver_id": 11629,
      "job_id": "P_BTC_030",
      "jpurnal_item": [
        {
          "id": 49177,
          "driverId": 11629
        }
      ]
    },
    {
      "driver_id": 11630,
      "job_id": "P_BTC_31_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 49178,
          "driverId": 11630
        },
        {
          "id": 50061,
          "driverId": 11630
        },
        {
          "id": 50755,
          "driverId": 11630
        },
        {
          "id": 51580,
          "driverId": 11630
        },
        {
          "id": 52282,
          "driverId": 11630
        },
        {
          "id": 52845,
          "driverId": 11630
        },
        {
          "id": 53470,
          "driverId": 11630
        },
        {
          "id": 54128,
          "driverId": 11630
        },
        {
          "id": 54606,
          "driverId": 11630
        }
      ]
    },
    {
      "driver_id": 11773,
      "job_id": "P_BTC_32_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 49179,
          "driverId": 11773
        },
        {
          "id": 50062,
          "driverId": 11773
        },
        {
          "id": 50763,
          "driverId": 11773
        },
        {
          "id": 51587,
          "driverId": 11773
        },
        {
          "id": 52283,
          "driverId": 11773
        },
        {
          "id": 52844,
          "driverId": 11773
        }
      ]
    },
    {
      "driver_id": 11861,
      "job_id": "P_BTC_35_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 50065,
          "driverId": 11861
        },
        {
          "id": 50764,
          "driverId": 11861
        },
        {
          "id": 51581,
          "driverId": 11861
        },
        {
          "id": 52284,
          "driverId": 11861
        },
        {
          "id": 52843,
          "driverId": 11861
        },
        {
          "id": 53471,
          "driverId": 11861
        }
      ]
    },
    {
      "driver_id": 12191,
      "job_id": "P_BTC_36_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 50066,
          "driverId": 12191
        },
        {
          "id": 50765,
          "driverId": 12191
        },
        {
          "id": 52285,
          "driverId": 12191
        },
        {
          "id": 52837,
          "driverId": 12191
        },
        {
          "id": 53446,
          "driverId": 12191
        }
      ]
    },
    {
      "driver_id": 13223,
      "job_id": "p_btc_37",
      "jpurnal_item": [
        {
          "id": 51588,
          "driverId": 13223
        }
      ]
    },
    {
      "driver_id": 13432,
      "job_id": "D2106311201",
      "jpurnal_item": [
        {
          "id": 51646,
          "driverId": 13432
        },
        {
          "id": 51790,
          "driverId": 13432
        },
        {
          "id": 52559,
          "driverId": 13432
        }
      ]
    },
    {
      "driver_id": 13668,
      "job_id": "P_BTC_37_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 52286,
          "driverId": 13668
        }
      ]
    },
    {
      "driver_id": 13669,
      "job_id": "P_BTC_38_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 52287,
          "driverId": 13669
        },
        {
          "id": 52842,
          "driverId": 13669
        },
        {
          "id": 53469,
          "driverId": 13669
        },
        {
          "id": 54129,
          "driverId": 13669
        },
        {
          "id": 54607,
          "driverId": 13669
        }
      ]
    },
    {
      "driver_id": 13739,
      "job_id": "D2107158001",
      "jpurnal_item": [
        {
          "id": 52535,
          "driverId": 13739
        }
      ]
    },
    {
      "driver_id": 13861,
      "job_id": "P_BTC_09_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 52846,
          "driverId": 13861
        }
      ]
    },
    {
      "driver_id": 13865,
      "job_id": "P_BTC_39_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 52841,
          "driverId": 13865
        },
        {
          "id": 53474,
          "driverId": 13865
        }
      ]
    },
    {
      "driver_id": 13936,
      "job_id": "P_BTC_49_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 53476,
          "driverId": 13936
        },
        {
          "id": 54133,
          "driverId": 13936
        },
        {
          "id": 54610,
          "driverId": 13936
        }
      ]
    },
    {
      "driver_id": 13960,
      "job_id": "P_BTC_47_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 53473,
          "driverId": 13960
        },
        {
          "id": 54132,
          "driverId": 13960
        },
        {
          "id": 54609,
          "driverId": 13960
        }
      ]
    },
    {
      "driver_id": 13961,
      "job_id": "P_BTC_46_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 53472,
          "driverId": 13961
        },
        {
          "id": 54131,
          "driverId": 13961
        }
      ]
    },
    {
      "driver_id": 13973,
      "job_id": "P_BTC_43_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 53475,
          "driverId": 13973
        },
        {
          "id": 54130,
          "driverId": 13973
        },
        {
          "id": 54608,
          "driverId": 13973
        }
      ]
    },
    {
      "driver_id": 13974,
      "job_id": "P_BTC_01_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 53478,
          "driverId": 13974
        }
      ]
    },
    {
      "driver_id": 14032,
      "job_id": "P_BTC_42_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 53443,
          "driverId": 14032
        }
      ]
    },
    {
      "driver_id": 14041,
      "job_id": "P_BTC_40_NDD_TIF",
      "jpurnal_item": [
        {
          "id": 53477,
          "driverId": 14041
        }
      ]
    },
    {
      "driver_id": 14042,
      "job_id": "p_btc_41_ndd_tif",
      "jpurnal_item": [
        {
          "id": 53479,
          "driverId": 14042
        }
      ]
    },
    {
      "driver_id": 9444,
      "job_id": "LM0055",
      "jpurnal_item": [
        {
          "id": 43155,
          "driverId": 9444
        },
        {
          "id": 44279,
          "driverId": 9444
        }
      ]
    },
    {
      "driver_id": 9543,
      "job_id": "LM0057",
      "jpurnal_item": [
        {
          "id": 43156,
          "driverId": 9543
        },
        {
          "id": 44280,
          "driverId": 9543
        },
        {
          "id": 45151,
          "driverId": 9543
        }
      ]
    },
    {
      "driver_id": 9709,
      "job_id": "LM006080",
      "jpurnal_item": [
        {
          "id": 43157,
          "driverId": 9709
        },
        {
          "id": 44281,
          "driverId": 9709
        },
        {
          "id": 45150,
          "driverId": 9709
        }
      ]
    },
    {
      "driver_id": 9711,
      "job_id": "LM0091",
      "jpurnal_item": [
        {
          "id": 43159,
          "driverId": 9711
        },
        {
          "id": 44283,
          "driverId": 9711
        }
      ]
    },
    {
      "driver_id": 9712,
      "job_id": "LM0092",
      "jpurnal_item": [
        {
          "id": 43170,
          "driverId": 9712
        }
      ]
    },
    {
      "driver_id": 9713,
      "job_id": "LM0093",
      "jpurnal_item": [
        {
          "id": 43160,
          "driverId": 9713
        },
        {
          "id": 44284,
          "driverId": 9713
        }
      ]
    },
    {
      "driver_id": 9714,
      "job_id": "LM00994",
      "jpurnal_item": [
        {
          "id": 43161,
          "driverId": 9714
        }
      ]
    },
    {
      "driver_id": 9715,
      "job_id": "LM00995",
      "jpurnal_item": [
        {
          "id": 43171,
          "driverId": 9715
        }
      ]
    },
    {
      "driver_id": 9716,
      "job_id": "F_BTC_75",
      "jpurnal_item": [
        {
          "id": 43162,
          "driverId": 9716
        },
        {
          "id": 44285,
          "driverId": 9716
        },
        {
          "id": 45149,
          "driverId": 9716
        },
        {
          "id": 45896,
          "driverId": 9716
        }
      ]
    },
    {
      "driver_id": 9717,
      "job_id": "LM0097",
      "jpurnal_item": [
        {
          "id": 43163,
          "driverId": 9717
        },
        {
          "id": 44286,
          "driverId": 9717
        }
      ]
    },
    {
      "driver_id": 9831,
      "job_id": "LM00110",
      "jpurnal_item": [
        {
          "id": 43158,
          "driverId": 9831
        },
        {
          "id": 44282,
          "driverId": 9831
        }
      ]
    },
    {
      "driver_id": 9832,
      "job_id": "LM00111",
      "jpurnal_item": [
        {
          "id": 43164,
          "driverId": 9832
        },
        {
          "id": 44272,
          "driverId": 9832
        }
      ]
    },
    {
      "driver_id": 9833,
      "job_id": "LM00112",
      "jpurnal_item": [
        {
          "id": 43168,
          "driverId": 9833
        }
      ]
    },
    {
      "driver_id": 9834,
      "job_id": "LM00113",
      "jpurnal_item": [
        {
          "id": 43165,
          "driverId": 9834
        },
        {
          "id": 44273,
          "driverId": 9834
        },
        {
          "id": 47253,
          "driverId": 9834
        }
      ]
    },
    {
      "driver_id": 9835,
      "job_id": "LM00114",
      "jpurnal_item": [
        {
          "id": 43167,
          "driverId": 9835
        },
        {
          "id": 44274,
          "driverId": 9835
        }
      ]
    },
    {
      "driver_id": 9836,
      "job_id": "F_BTC_99",
      "jpurnal_item": [
        {
          "id": 43175,
          "driverId": 9836
        },
        {
          "id": 45148,
          "driverId": 9836
        },
        {
          "id": 45897,
          "driverId": 9836
        }
      ]
    },
    {
      "driver_id": 9837,
      "job_id": "LM00116",
      "jpurnal_item": [
        {
          "id": 43166,
          "driverId": 9837
        }
      ]
    },
    {
      "driver_id": 9838,
      "job_id": "LM00117",
      "jpurnal_item": [
        {
          "id": 43174,
          "driverId": 9838
        }
      ]
    },
    {
      "driver_id": 9839,
      "job_id": "LM00118",
      "jpurnal_item": [
        {
          "id": 43173,
          "driverId": 9839
        },
        {
          "id": 45892,
          "driverId": 9839
        },
        {
          "id": 47254,
          "driverId": 9839
        }
      ]
    },
    {
      "driver_id": 9840,
      "job_id": "LM00119",
      "jpurnal_item": [
        {
          "id": 43172,
          "driverId": 9840
        }
      ]
    },
    {
      "driver_id": 10194,
      "job_id": "LM00126",
      "jpurnal_item": [
        {
          "id": 43151,
          "driverId": 10194
        },
        {
          "id": 44275,
          "driverId": 10194
        },
        {
          "id": 45153,
          "driverId": 10194
        },
        {
          "id": 45890,
          "driverId": 10194
        }
      ]
    },
    {
      "driver_id": 10327,
      "job_id": "LM0200",
      "jpurnal_item": [
        {
          "id": 43169,
          "driverId": 10327
        }
      ]
    },
    {
      "driver_id": 10860,
      "job_id": "f_btc_135",
      "jpurnal_item": [
        {
          "id": 45893,
          "driverId": 10860
        },
        {
          "id": 47255,
          "driverId": 10860
        },
        {
          "id": 48149,
          "driverId": 10860
        },
        {
          "id": 49157,
          "driverId": 10860
        },
        {
          "id": 49892,
          "driverId": 10860
        }
      ]
    },
    {
      "driver_id": 10861,
      "job_id": "F_BTC_131",
      "jpurnal_item": [
        {
          "id": 45891,
          "driverId": 10861
        }
      ]
    },
    {
      "driver_id": 10864,
      "job_id": "LM00138",
      "jpurnal_item": [
        {
          "id": 47256,
          "driverId": 10864
        },
        {
          "id": 48150,
          "driverId": 10864
        }
      ]
    },
    {
      "driver_id": 10995,
      "job_id": "F_BTC_149",
      "jpurnal_item": [
        {
          "id": 47257,
          "driverId": 10995
        }
      ]
    },
    {
      "driver_id": 10996,
      "job_id": "P_BTC_156",
      "jpurnal_item": [
        {
          "id": 47262,
          "driverId": 10996
        },
        {
          "id": 48156,
          "driverId": 10996
        }
      ]
    },
    {
      "driver_id": 10997,
      "job_id": "F_BTC_157",
      "jpurnal_item": [
        {
          "id": 47258,
          "driverId": 10997
        }
      ]
    },
    {
      "driver_id": 11044,
      "job_id": "F_BTC_162",
      "jpurnal_item": [
        {
          "id": 47259,
          "driverId": 11044
        },
        {
          "id": 48151,
          "driverId": 11044
        },
        {
          "id": 49159,
          "driverId": 11044
        },
        {
          "id": 49894,
          "driverId": 11044
        },
        {
          "id": 50768,
          "driverId": 11044
        },
        {
          "id": 51562,
          "driverId": 11044
        },
        {
          "id": 52257,
          "driverId": 11044
        },
        {
          "id": 52869,
          "driverId": 11044
        },
        {
          "id": 53409,
          "driverId": 11044
        }
      ]
    },
    {
      "driver_id": 11045,
      "job_id": "P_BTC_162",
      "jpurnal_item": [
        {
          "id": 47263,
          "driverId": 11045
        },
        {
          "id": 48157,
          "driverId": 11045
        }
      ]
    },
    {
      "driver_id": 11046,
      "job_id": "F_BTC_163",
      "jpurnal_item": [
        {
          "id": 47260,
          "driverId": 11046
        }
      ]
    },
    {
      "driver_id": 11177,
      "job_id": "P_BTC_170",
      "jpurnal_item": [
        {
          "id": 48160,
          "driverId": 11177
        }
      ]
    },
    {
      "driver_id": 11178,
      "job_id": "F_BTC_174",
      "jpurnal_item": [
        {
          "id": 48154,
          "driverId": 11178
        }
      ]
    },
    {
      "driver_id": 11179,
      "job_id": "P_BTC_167",
      "jpurnal_item": [
        {
          "id": 47264,
          "driverId": 11179
        },
        {
          "id": 48158,
          "driverId": 11179
        }
      ]
    },
    {
      "driver_id": 11180,
      "job_id": "F_BTC_173",
      "jpurnal_item": [
        {
          "id": 48153,
          "driverId": 11180
        },
        {
          "id": 49161,
          "driverId": 11180
        }
      ]
    },
    {
      "driver_id": 11181,
      "job_id": "F_BTC_138_NDD_JED",
      "jpurnal_item": [
        {
          "id": 49158,
          "driverId": 11181
        },
        {
          "id": 49893,
          "driverId": 11181
        },
        {
          "id": 50769,
          "driverId": 11181
        }
      ]
    },
    {
      "driver_id": 11182,
      "job_id": "P_BTC_169",
      "jpurnal_item": [
        {
          "id": 48159,
          "driverId": 11182
        }
      ]
    },
    {
      "driver_id": 11382,
      "job_id": "F_BTC_175",
      "jpurnal_item": [
        {
          "id": 48155,
          "driverId": 11382
        },
        {
          "id": 49162,
          "driverId": 11382
        },
        {
          "id": 49895,
          "driverId": 11382
        }
      ]
    },
    {
      "driver_id": 11383,
      "job_id": "F_BTC_172",
      "jpurnal_item": [
        {
          "id": 48152,
          "driverId": 11383
        },
        {
          "id": 49160,
          "driverId": 11383
        }
      ]
    },
    {
      "driver_id": 11603,
      "job_id": "p_BTC_190",
      "jpurnal_item": [
        {
          "id": 48161,
          "driverId": 11603
        }
      ]
    },
    {
      "driver_id": 11860,
      "job_id": "p_btc_191",
      "jpurnal_item": [
        {
          "id": 49163,
          "driverId": 11860
        },
        {
          "id": 49897,
          "driverId": 11860
        }
      ]
    },
    {
      "driver_id": 13142,
      "job_id": "F_BTC_206",
      "jpurnal_item": [
        {
          "id": 50766,
          "driverId": 13142
        },
        {
          "id": 51560,
          "driverId": 13142
        },
        {
          "id": 52255,
          "driverId": 13142
        },
        {
          "id": 53411,
          "driverId": 13142
        }
      ]
    },
    {
      "driver_id": 14019,
      "job_id": "F_BTC_231_NDD_JED",
      "jpurnal_item": [
        {
          "id": 53413,
          "driverId": 14019
        }
      ]
    },
    {
      "driver_id": 14020,
      "job_id": "F_BTC_248_NDD_JED",
      "jpurnal_item": [
        {
          "id": 53414,
          "driverId": 14020
        }
      ]
    },
    {
      "driver_id": 14021,
      "job_id": "F_BTC_253",
      "jpurnal_item": [
        {
          "id": 53415,
          "driverId": 14021
        }
      ]
    },
    {
      "driver_id": 14022,
      "job_id": "F_BTC_254",
      "jpurnal_item": [
        {
          "id": 53416,
          "driverId": 14022
        }
      ]
    },
    {
      "driver_id": 14023,
      "job_id": "F_BTC_266",
      "jpurnal_item": [
        {
          "id": 53417,
          "driverId": 14023
        }
      ]
    },
    {
      "driver_id": 14024,
      "job_id": "F_BTC_268",
      "jpurnal_item": [
        {
          "id": 53418,
          "driverId": 14024
        }
      ]
    },
    {
      "driver_id": 14025,
      "job_id": "f_BTC_50",
      "jpurnal_item": [
        {
          "id": 53419,
          "driverId": 14025
        }
      ]
    },
    {
      "driver_id": 14144,
      "job_id": "F_BTC_162_NDD_JED",
      "jpurnal_item": [
        {
          "id": 54080,
          "driverId": 14144
        }
      ]
    },
    {
      "driver_id": 14145,
      "job_id": "F_BTC_200_NDD_JED",
      "jpurnal_item": [
        {
          "id": 49896,
          "driverId": 14145
        },
        {
          "id": 50767,
          "driverId": 14145
        },
        {
          "id": 51561,
          "driverId": 14145
        },
        {
          "id": 52256,
          "driverId": 14145
        },
        {
          "id": 52870,
          "driverId": 14145
        },
        {
          "id": 53410,
          "driverId": 14145
        },
        {
          "id": 54082,
          "driverId": 14145
        },
        {
          "id": 54505,
          "driverId": 14145
        }
      ]
    },
    {
      "driver_id": 14146,
      "job_id": "F_BTC_254_NDD_JED",
      "jpurnal_item": [
        {
          "id": 54083,
          "driverId": 14146
        },
        {
          "id": 54506,
          "driverId": 14146
        }
      ]
    },
    {
      "driver_id": 14147,
      "job_id": "F_BTC_266_NDD_JED",
      "jpurnal_item": [
        {
          "id": 54084,
          "driverId": 14147
        }
      ]
    },
    {
      "driver_id": 14148,
      "job_id": "F_BTC_268_NDD_JED",
      "jpurnal_item": [
        {
          "id": 54085,
          "driverId": 14148
        },
        {
          "id": 54507,
          "driverId": 14148
        }
      ]
    },
    {
      "driver_id": 14149,
      "job_id": "F_BTC_271_NDD_JED",
      "jpurnal_item": [
        {
          "id": 54087,
          "driverId": 14149
        }
      ]
    },
    {
      "driver_id": 14150,
      "job_id": "f_BTC_50_ndd_JED",
      "jpurnal_item": [
        {
          "id": 54093,
          "driverId": 14150
        },
        {
          "id": 54510,
          "driverId": 14150
        }
      ]
    },
    {
      "driver_id": 14356,
      "job_id": "F_BTC_282_NDD_JED",
      "jpurnal_item": [
        {
          "id": 54508,
          "driverId": 14356
        }
      ]
    },
    {
      "driver_id": 14357,
      "job_id": "F_BTC_291_NDD_JED",
      "jpurnal_item": [
        {
          "id": 54509,
          "driverId": 14357
        }
      ]
    },
    {
      "driver_id": 14366,
      "job_id": "P_BTC_21_NDD_SAQUR_MAK",
      "jpurnal_item": [
        {
          "id": 54676,
          "driverId": 14366
        }
      ]
    },
    {
      "driver_id": 14367,
      "job_id": "P_BTC_66_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54687,
          "driverId": 14367
        }
      ]
    },
    {
      "driver_id": 14368,
      "job_id": "P_BTC_84_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54693,
          "driverId": 14368
        }
      ]
    },
    {
      "driver_id": 14369,
      "job_id": "P_BTC_85_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54694,
          "driverId": 14369
        }
      ]
    },
    {
      "driver_id": 14370,
      "job_id": "P_BTC_87_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54695,
          "driverId": 14370
        }
      ]
    },
    {
      "driver_id": 14371,
      "job_id": "P_BTC_86_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54696,
          "driverId": 14371
        }
      ]
    },
    {
      "driver_id": 14372,
      "job_id": "P_BTC_88_NDD_MAK",
      "jpurnal_item": [
        {
          "id": 54699,
          "driverId": 14372
        }
      ]
    },
    {
      "driver_id": 13653,
      "job_id": "f_btc_216",
      "jpurnal_item": [
        {
          "id": 52871,
          "driverId": 13653
        },
        {
          "id": 53412,
          "driverId": 13653
        }
      ]
    },
    {
      "driver_id": 9319,
      "job_id": "f_BTC_49",
      "jpurnal_item": [
        {
          "id": 43153,
          "driverId": 9319
        },
        {
          "id": 44277,
          "driverId": 9319
        },
        {
          "id": 45154,
          "driverId": 9319
        },
        {
          "id": 45894,
          "driverId": 9319
        },
        {
          "id": 47261,
          "driverId": 9319
        }
      ]
    },
    {
      "driver_id": 9418,
      "job_id": "f_BTC_50_ndd",
      "jpurnal_item": [
        {
          "id": 43154,
          "driverId": 9418
        },
        {
          "id": 44278,
          "driverId": 9418
        },
        {
          "id": 45152,
          "driverId": 9418
        },
        {
          "id": 45895,
          "driverId": 9418
        },
        {
          "id": 52872,
          "driverId": 9418
        }
      ]
    },
    {
      "driver_id": 9318,
      "job_id": "LM0039",
      "jpurnal_item": [
        {
          "id": 43152,
          "driverId": 9318
        },
        {
          "id": 44276,
          "driverId": 9318
        }
      ]
    },
    {
      "driver_id": 9558,
      "job_id": "LM0070",
      "jpurnal_item": [
        {
          "id": 43111,
          "driverId": 9558
        }
      ]
    },
    {
      "driver_id": 9559,
      "job_id": "F_BTC_163_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 43110,
          "driverId": 9559
        },
        {
          "id": 44313,
          "driverId": 9559
        },
        {
          "id": 50825,
          "driverId": 9559
        }
      ]
    },
    {
      "driver_id": 9760,
      "job_id": "F_BTC_180_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 43106,
          "driverId": 9760
        },
        {
          "id": 44322,
          "driverId": 9760
        },
        {
          "id": 45136,
          "driverId": 9760
        },
        {
          "id": 46074,
          "driverId": 9760
        },
        {
          "id": 47203,
          "driverId": 9760
        },
        {
          "id": 48291,
          "driverId": 9760
        },
        {
          "id": 49203,
          "driverId": 9760
        },
        {
          "id": 49891,
          "driverId": 9760
        },
        {
          "id": 50826,
          "driverId": 9760
        },
        {
          "id": 51592,
          "driverId": 9760
        },
        {
          "id": 52234,
          "driverId": 9760
        },
        {
          "id": 52826,
          "driverId": 9760
        },
        {
          "id": 54081,
          "driverId": 9760
        },
        {
          "id": 54515,
          "driverId": 9760
        }
      ]
    },
    {
      "driver_id": 9761,
      "job_id": "LM0101",
      "jpurnal_item": [
        {
          "id": 43107,
          "driverId": 9761
        }
      ]
    },
    {
      "driver_id": 9762,
      "job_id": "F_BTC_488_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 43112,
          "driverId": 9762
        },
        {
          "id": 47209,
          "driverId": 9762
        },
        {
          "id": 48300,
          "driverId": 9762
        },
        {
          "id": 49217,
          "driverId": 9762
        },
        {
          "id": 49882,
          "driverId": 9762
        },
        {
          "id": 50813,
          "driverId": 9762
        },
        {
          "id": 51596,
          "driverId": 9762
        },
        {
          "id": 52238,
          "driverId": 9762
        },
        {
          "id": 52830,
          "driverId": 9762
        },
        {
          "id": 54091,
          "driverId": 9762
        },
        {
          "id": 54519,
          "driverId": 9762
        }
      ]
    },
    {
      "driver_id": 9763,
      "job_id": "LM0103",
      "jpurnal_item": [
        {
          "id": 43113,
          "driverId": 9763
        },
        {
          "id": 44296,
          "driverId": 9763
        }
      ]
    },
    {
      "driver_id": 9765,
      "job_id": "LM0104",
      "jpurnal_item": [
        {
          "id": 43105,
          "driverId": 9765
        }
      ]
    },
    {
      "driver_id": 9766,
      "job_id": "LM0105",
      "jpurnal_item": [
        {
          "id": 43108,
          "driverId": 9766
        },
        {
          "id": 44324,
          "driverId": 9766
        },
        {
          "id": 47204,
          "driverId": 9766
        }
      ]
    },
    {
      "driver_id": 9767,
      "job_id": "F_BTC_144_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 43104,
          "driverId": 9767
        },
        {
          "id": 44321,
          "driverId": 9767
        },
        {
          "id": 45135,
          "driverId": 9767
        },
        {
          "id": 46073,
          "driverId": 9767
        },
        {
          "id": 47202,
          "driverId": 9767
        },
        {
          "id": 48289,
          "driverId": 9767
        },
        {
          "id": 49202,
          "driverId": 9767
        },
        {
          "id": 49890,
          "driverId": 9767
        },
        {
          "id": 51591,
          "driverId": 9767
        },
        {
          "id": 52233,
          "driverId": 9767
        },
        {
          "id": 52825,
          "driverId": 9767
        },
        {
          "id": 54079,
          "driverId": 9767
        },
        {
          "id": 54514,
          "driverId": 9767
        }
      ]
    },
    {
      "driver_id": 10245,
      "job_id": "LM0149",
      "jpurnal_item": [
        {
          "id": 43121,
          "driverId": 10245
        },
        {
          "id": 47211,
          "driverId": 10245
        }
      ]
    },
    {
      "driver_id": 10285,
      "job_id": "F_BTC_336",
      "jpurnal_item": [
        {
          "id": 43109,
          "driverId": 10285
        },
        {
          "id": 44315,
          "driverId": 10285
        }
      ]
    },
    {
      "driver_id": 10289,
      "job_id": "LM0162",
      "jpurnal_item": [
        {
          "id": 43114,
          "driverId": 10289
        },
        {
          "id": 44293,
          "driverId": 10289
        }
      ]
    },
    {
      "driver_id": 10290,
      "job_id": "LM0163",
      "jpurnal_item": [
        {
          "id": 43142,
          "driverId": 10290
        }
      ]
    },
    {
      "driver_id": 10291,
      "job_id": "LM0164",
      "jpurnal_item": [
        {
          "id": 43115,
          "driverId": 10291
        },
        {
          "id": 44302,
          "driverId": 10291
        }
      ]
    },
    {
      "driver_id": 10294,
      "job_id": "LM0166",
      "jpurnal_item": [
        {
          "id": 43116,
          "driverId": 10294
        }
      ]
    },
    {
      "driver_id": 10295,
      "job_id": "LM0167",
      "jpurnal_item": [
        {
          "id": 43117,
          "driverId": 10295
        }
      ]
    },
    {
      "driver_id": 10296,
      "job_id": "LM0168",
      "jpurnal_item": [
        {
          "id": 43118,
          "driverId": 10296
        }
      ]
    },
    {
      "driver_id": 10297,
      "job_id": "LM0169",
      "jpurnal_item": [
        {
          "id": 43119,
          "driverId": 10297
        }
      ]
    },
    {
      "driver_id": 10299,
      "job_id": "LM0171",
      "jpurnal_item": [
        {
          "id": 43122,
          "driverId": 10299
        },
        {
          "id": 44304,
          "driverId": 10299
        }
      ]
    },
    {
      "driver_id": 10300,
      "job_id": "LM0172",
      "jpurnal_item": [
        {
          "id": 43123,
          "driverId": 10300
        }
      ]
    },
    {
      "driver_id": 10301,
      "job_id": "LM0173",
      "jpurnal_item": [
        {
          "id": 43124,
          "driverId": 10301
        }
      ]
    },
    {
      "driver_id": 10302,
      "job_id": "LM0174",
      "jpurnal_item": [
        {
          "id": 43125,
          "driverId": 10302
        }
      ]
    },
    {
      "driver_id": 10303,
      "job_id": "LM0175",
      "jpurnal_item": [
        {
          "id": 43126,
          "driverId": 10303
        }
      ]
    },
    {
      "driver_id": 10304,
      "job_id": "LM0176",
      "jpurnal_item": [
        {
          "id": 43127,
          "driverId": 10304
        }
      ]
    },
    {
      "driver_id": 10305,
      "job_id": "LM0177",
      "jpurnal_item": [
        {
          "id": 43128,
          "driverId": 10305
        }
      ]
    },
    {
      "driver_id": 10306,
      "job_id": "LM0178",
      "jpurnal_item": [
        {
          "id": 43129,
          "driverId": 10306
        }
      ]
    },
    {
      "driver_id": 10307,
      "job_id": "LM0179",
      "jpurnal_item": [
        {
          "id": 43130,
          "driverId": 10307
        }
      ]
    },
    {
      "driver_id": 10308,
      "job_id": "LM0180",
      "jpurnal_item": [
        {
          "id": 43131,
          "driverId": 10308
        }
      ]
    },
    {
      "driver_id": 10309,
      "job_id": "LM0181",
      "jpurnal_item": [
        {
          "id": 43132,
          "driverId": 10309
        },
        {
          "id": 44301,
          "driverId": 10309
        }
      ]
    },
    {
      "driver_id": 10310,
      "job_id": "LM0182",
      "jpurnal_item": [
        {
          "id": 43133,
          "driverId": 10310
        }
      ]
    },
    {
      "driver_id": 10311,
      "job_id": "LM0183",
      "jpurnal_item": [
        {
          "id": 43134,
          "driverId": 10311
        }
      ]
    },
    {
      "driver_id": 10312,
      "job_id": "LM0184",
      "jpurnal_item": [
        {
          "id": 43135,
          "driverId": 10312
        },
        {
          "id": 44300,
          "driverId": 10312
        }
      ]
    },
    {
      "driver_id": 10313,
      "job_id": "LM0185",
      "jpurnal_item": [
        {
          "id": 43136,
          "driverId": 10313
        }
      ]
    },
    {
      "driver_id": 10314,
      "job_id": "LM0186",
      "jpurnal_item": [
        {
          "id": 43137,
          "driverId": 10314
        }
      ]
    },
    {
      "driver_id": 10315,
      "job_id": "LM0187",
      "jpurnal_item": [
        {
          "id": 43138,
          "driverId": 10315
        }
      ]
    },
    {
      "driver_id": 10316,
      "job_id": "LM0188",
      "jpurnal_item": [
        {
          "id": 43139,
          "driverId": 10316
        }
      ]
    },
    {
      "driver_id": 10317,
      "job_id": "LM0189",
      "jpurnal_item": [
        {
          "id": 43140,
          "driverId": 10317
        },
        {
          "id": 44308,
          "driverId": 10317
        }
      ]
    },
    {
      "driver_id": 10318,
      "job_id": "LM0190",
      "jpurnal_item": [
        {
          "id": 43141,
          "driverId": 10318
        }
      ]
    },
    {
      "driver_id": 10319,
      "job_id": "LM0191",
      "jpurnal_item": [
        {
          "id": 43143,
          "driverId": 10319
        },
        {
          "id": 44307,
          "driverId": 10319
        }
      ]
    },
    {
      "driver_id": 10320,
      "job_id": "LM0192",
      "jpurnal_item": [
        {
          "id": 43144,
          "driverId": 10320
        },
        {
          "id": 44298,
          "driverId": 10320
        }
      ]
    },
    {
      "driver_id": 10321,
      "job_id": "LM0193",
      "jpurnal_item": [
        {
          "id": 43145,
          "driverId": 10321
        },
        {
          "id": 44305,
          "driverId": 10321
        }
      ]
    },
    {
      "driver_id": 10322,
      "job_id": "LM0194",
      "jpurnal_item": [
        {
          "id": 43146,
          "driverId": 10322
        },
        {
          "id": 44297,
          "driverId": 10322
        }
      ]
    },
    {
      "driver_id": 10323,
      "job_id": "LM0195",
      "jpurnal_item": [
        {
          "id": 43147,
          "driverId": 10323
        },
        {
          "id": 44299,
          "driverId": 10323
        }
      ]
    },
    {
      "driver_id": 10324,
      "job_id": "LM0196",
      "jpurnal_item": [
        {
          "id": 43148,
          "driverId": 10324
        },
        {
          "id": 44303,
          "driverId": 10324
        }
      ]
    },
    {
      "driver_id": 10325,
      "job_id": "LM0197",
      "jpurnal_item": [
        {
          "id": 43149,
          "driverId": 10325
        },
        {
          "id": 44306,
          "driverId": 10325
        }
      ]
    },
    {
      "driver_id": 10326,
      "job_id": "LM0198",
      "jpurnal_item": [
        {
          "id": 43150,
          "driverId": 10326
        }
      ]
    },
    {
      "driver_id": 10329,
      "job_id": "LM0201",
      "jpurnal_item": [
        {
          "id": 44314,
          "driverId": 10329
        },
        {
          "id": 45126,
          "driverId": 10329
        }
      ]
    },
    {
      "driver_id": 10330,
      "job_id": "LM0202",
      "jpurnal_item": [
        {
          "id": 44317,
          "driverId": 10330
        }
      ]
    },
    {
      "driver_id": 10332,
      "job_id": "F_BTC_353",
      "jpurnal_item": [
        {
          "id": 44318,
          "driverId": 10332
        },
        {
          "id": 45131,
          "driverId": 10332
        },
        {
          "id": 47200,
          "driverId": 10332
        },
        {
          "id": 48293,
          "driverId": 10332
        },
        {
          "id": 49205,
          "driverId": 10332
        },
        {
          "id": 49885,
          "driverId": 10332
        },
        {
          "id": 50818,
          "driverId": 10332
        }
      ]
    },
    {
      "driver_id": 10526,
      "job_id": "LM0206",
      "jpurnal_item": [
        {
          "id": 44292,
          "driverId": 10526
        }
      ]
    },
    {
      "driver_id": 10527,
      "job_id": "LM0207",
      "jpurnal_item": [
        {
          "id": 44294,
          "driverId": 10527
        }
      ]
    },
    {
      "driver_id": 10528,
      "job_id": "LM0208",
      "jpurnal_item": [
        {
          "id": 44295,
          "driverId": 10528
        }
      ]
    },
    {
      "driver_id": 10529,
      "job_id": "LM208",
      "jpurnal_item": [
        {
          "id": 44316,
          "driverId": 10529
        },
        {
          "id": 45130,
          "driverId": 10529
        }
      ]
    },
    {
      "driver_id": 10531,
      "job_id": "F_BTC_362",
      "jpurnal_item": [
        {
          "id": 44319,
          "driverId": 10531
        },
        {
          "id": 45133,
          "driverId": 10531
        },
        {
          "id": 46072,
          "driverId": 10531
        },
        {
          "id": 47201,
          "driverId": 10531
        },
        {
          "id": 48294,
          "driverId": 10531
        },
        {
          "id": 49206,
          "driverId": 10531
        },
        {
          "id": 49889,
          "driverId": 10531
        },
        {
          "id": 50827,
          "driverId": 10531
        }
      ]
    },
    {
      "driver_id": 10532,
      "job_id": "LM0210",
      "jpurnal_item": [
        {
          "id": 44320,
          "driverId": 10532
        },
        {
          "id": 45134,
          "driverId": 10532
        }
      ]
    },
    {
      "driver_id": 10533,
      "job_id": "LM0211",
      "jpurnal_item": [
        {
          "id": 44323,
          "driverId": 10533
        },
        {
          "id": 45138,
          "driverId": 10533
        }
      ]
    },
    {
      "driver_id": 10701,
      "job_id": "LM0213",
      "jpurnal_item": [
        {
          "id": 45137,
          "driverId": 10701
        }
      ]
    },
    {
      "driver_id": 10702,
      "job_id": "LM0214",
      "jpurnal_item": [
        {
          "id": 45127,
          "driverId": 10702
        }
      ]
    },
    {
      "driver_id": 10703,
      "job_id": "LM0215",
      "jpurnal_item": [
        {
          "id": 45129,
          "driverId": 10703
        }
      ]
    },
    {
      "driver_id": 10704,
      "job_id": "LM0216",
      "jpurnal_item": [
        {
          "id": 45128,
          "driverId": 10704
        }
      ]
    },
    {
      "driver_id": 10758,
      "job_id": "F_BTC_379_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 45124,
          "driverId": 10758
        },
        {
          "id": 46069,
          "driverId": 10758
        },
        {
          "id": 47195,
          "driverId": 10758
        },
        {
          "id": 48296,
          "driverId": 10758
        },
        {
          "id": 49208,
          "driverId": 10758
        },
        {
          "id": 49877,
          "driverId": 10758
        },
        {
          "id": 50828,
          "driverId": 10758
        },
        {
          "id": 51594,
          "driverId": 10758
        },
        {
          "id": 52236,
          "driverId": 10758
        },
        {
          "id": 52828,
          "driverId": 10758
        },
        {
          "id": 54089,
          "driverId": 10758
        },
        {
          "id": 54517,
          "driverId": 10758
        }
      ]
    },
    {
      "driver_id": 10759,
      "job_id": "F_BTC_378_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 45125,
          "driverId": 10759
        },
        {
          "id": 46070,
          "driverId": 10759
        },
        {
          "id": 47196,
          "driverId": 10759
        },
        {
          "id": 48295,
          "driverId": 10759
        },
        {
          "id": 49207,
          "driverId": 10759
        },
        {
          "id": 49878,
          "driverId": 10759
        },
        {
          "id": 50808,
          "driverId": 10759
        },
        {
          "id": 51593,
          "driverId": 10759
        },
        {
          "id": 52235,
          "driverId": 10759
        },
        {
          "id": 52827,
          "driverId": 10759
        },
        {
          "id": 54088,
          "driverId": 10759
        },
        {
          "id": 54516,
          "driverId": 10759
        }
      ]
    },
    {
      "driver_id": 10760,
      "job_id": "LM00202",
      "jpurnal_item": [
        {
          "id": 45132,
          "driverId": 10760
        }
      ]
    },
    {
      "driver_id": 10761,
      "job_id": "LM00203",
      "jpurnal_item": [
        {
          "id": 45123,
          "driverId": 10761
        }
      ]
    },
    {
      "driver_id": 10859,
      "job_id": "LM0229",
      "jpurnal_item": [
        {
          "id": 46071,
          "driverId": 10859
        }
      ]
    },
    {
      "driver_id": 10912,
      "job_id": "P_BTC_404",
      "jpurnal_item": [
        {
          "id": 47214,
          "driverId": 10912
        },
        {
          "id": 48305,
          "driverId": 10912
        },
        {
          "id": 49214,
          "driverId": 10912
        },
        {
          "id": 49886,
          "driverId": 10912
        },
        {
          "id": 50820,
          "driverId": 10912
        }
      ]
    },
    {
      "driver_id": 10982,
      "job_id": "LM0233",
      "jpurnal_item": [
        {
          "id": 47210,
          "driverId": 10982
        }
      ]
    },
    {
      "driver_id": 10983,
      "job_id": "P_BTC_408",
      "jpurnal_item": [
        {
          "id": 47218,
          "driverId": 10983
        },
        {
          "id": 48307,
          "driverId": 10983
        }
      ]
    },
    {
      "driver_id": 10984,
      "job_id": "P_BTC_394",
      "jpurnal_item": [
        {
          "id": 47213,
          "driverId": 10984
        },
        {
          "id": 48303,
          "driverId": 10984
        },
        {
          "id": 49215,
          "driverId": 10984
        },
        {
          "id": 49884,
          "driverId": 10984
        },
        {
          "id": 50831,
          "driverId": 10984
        },
        {
          "id": 51607,
          "driverId": 10984
        },
        {
          "id": 53404,
          "driverId": 10984
        }
      ]
    },
    {
      "driver_id": 10985,
      "job_id": "P_BTC_407",
      "jpurnal_item": [
        {
          "id": 47216,
          "driverId": 10985
        },
        {
          "id": 48306,
          "driverId": 10985
        },
        {
          "id": 49210,
          "driverId": 10985
        },
        {
          "id": 49887,
          "driverId": 10985
        }
      ]
    },
    {
      "driver_id": 10986,
      "job_id": "P_BTC_393",
      "jpurnal_item": [
        {
          "id": 47212,
          "driverId": 10986
        },
        {
          "id": 48302,
          "driverId": 10986
        },
        {
          "id": 49218,
          "driverId": 10986
        },
        {
          "id": 49883,
          "driverId": 10986
        },
        {
          "id": 50816,
          "driverId": 10986
        },
        {
          "id": 51605,
          "driverId": 10986
        },
        {
          "id": 52249,
          "driverId": 10986
        }
      ]
    },
    {
      "driver_id": 11007,
      "job_id": "LM0237",
      "jpurnal_item": [
        {
          "id": 47208,
          "driverId": 11007
        }
      ]
    },
    {
      "driver_id": 11008,
      "job_id": "LM0238",
      "jpurnal_item": [
        {
          "id": 47197,
          "driverId": 11008
        }
      ]
    },
    {
      "driver_id": 11037,
      "job_id": "F_BTC_114_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 48287,
          "driverId": 11037
        },
        {
          "id": 49200,
          "driverId": 11037
        },
        {
          "id": 49880,
          "driverId": 11037
        },
        {
          "id": 50811,
          "driverId": 11037
        },
        {
          "id": 51589,
          "driverId": 11037
        },
        {
          "id": 52231,
          "driverId": 11037
        },
        {
          "id": 52823,
          "driverId": 11037
        },
        {
          "id": 54077,
          "driverId": 11037
        },
        {
          "id": 54512,
          "driverId": 11037
        }
      ]
    },
    {
      "driver_id": 11038,
      "job_id": "F_BTC_418",
      "jpurnal_item": [
        {
          "id": 47205,
          "driverId": 11038
        },
        {
          "id": 48297,
          "driverId": 11038
        }
      ]
    },
    {
      "driver_id": 11042,
      "job_id": "F_BTC_223_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 47206,
          "driverId": 11042
        },
        {
          "id": 48301,
          "driverId": 11042
        },
        {
          "id": 49216,
          "driverId": 11042
        },
        {
          "id": 49879,
          "driverId": 11042
        },
        {
          "id": 50809,
          "driverId": 11042
        },
        {
          "id": 51606,
          "driverId": 11042
        },
        {
          "id": 52248,
          "driverId": 11042
        },
        {
          "id": 52835,
          "driverId": 11042
        }
      ]
    },
    {
      "driver_id": 11167,
      "job_id": "LM0300",
      "jpurnal_item": [
        {
          "id": 47198,
          "driverId": 11167
        }
      ]
    },
    {
      "driver_id": 11168,
      "job_id": "LM0301",
      "jpurnal_item": [
        {
          "id": 47199,
          "driverId": 11168
        }
      ]
    },
    {
      "driver_id": 11169,
      "job_id": "P_BTC_436",
      "jpurnal_item": [
        {
          "id": 47215,
          "driverId": 11169
        },
        {
          "id": 48308,
          "driverId": 11169
        },
        {
          "id": 49213,
          "driverId": 11169
        }
      ]
    },
    {
      "driver_id": 11170,
      "job_id": "LM0303",
      "jpurnal_item": [
        {
          "id": 47217,
          "driverId": 11170
        }
      ]
    },
    {
      "driver_id": 11171,
      "job_id": "P_BTC_401",
      "jpurnal_item": [
        {
          "id": 47219,
          "driverId": 11171
        },
        {
          "id": 48304,
          "driverId": 11171
        }
      ]
    },
    {
      "driver_id": 11172,
      "job_id": "LM0305",
      "jpurnal_item": [
        {
          "id": 47207,
          "driverId": 11172
        }
      ]
    },
    {
      "driver_id": 11632,
      "job_id": "F_BTC_154",
      "jpurnal_item": [
        {
          "id": 48290,
          "driverId": 11632
        }
      ]
    },
    {
      "driver_id": 11634,
      "job_id": "F_BTC_443",
      "jpurnal_item": [
        {
          "id": 48298,
          "driverId": 11634
        }
      ]
    },
    {
      "driver_id": 11635,
      "job_id": "F_BTC_199",
      "jpurnal_item": [
        {
          "id": 48292,
          "driverId": 11635
        },
        {
          "id": 49204,
          "driverId": 11635
        }
      ]
    },
    {
      "driver_id": 11761,
      "job_id": "F_BTC_468_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 49211,
          "driverId": 11761
        },
        {
          "id": 49881,
          "driverId": 11761
        },
        {
          "id": 50812,
          "driverId": 11761
        },
        {
          "id": 51595,
          "driverId": 11761
        },
        {
          "id": 52237,
          "driverId": 11761
        },
        {
          "id": 52829,
          "driverId": 11761
        },
        {
          "id": 54090,
          "driverId": 11761
        },
        {
          "id": 54518,
          "driverId": 11761
        }
      ]
    },
    {
      "driver_id": 11868,
      "job_id": "P_BTC_460",
      "jpurnal_item": [
        {
          "id": 49212,
          "driverId": 11868
        }
      ]
    },
    {
      "driver_id": 12080,
      "job_id": "F_BTC_477",
      "jpurnal_item": [
        {
          "id": 49888,
          "driverId": 12080
        },
        {
          "id": 50830,
          "driverId": 12080
        }
      ]
    },
    {
      "driver_id": 13289,
      "job_id": "F_BTC_491_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 50810,
          "driverId": 13289
        },
        {
          "id": 51597,
          "driverId": 13289
        }
      ]
    },
    {
      "driver_id": 13290,
      "job_id": "LM0304",
      "jpurnal_item": [
        {
          "id": 50815,
          "driverId": 13290
        }
      ]
    },
    {
      "driver_id": 13291,
      "job_id": "LM00305",
      "jpurnal_item": [
        {
          "id": 50819,
          "driverId": 13291
        }
      ]
    },
    {
      "driver_id": 13292,
      "job_id": "LM0306",
      "jpurnal_item": [
        {
          "id": 50821,
          "driverId": 13292
        }
      ]
    },
    {
      "driver_id": 13293,
      "job_id": "LM0307",
      "jpurnal_item": [
        {
          "id": 50822,
          "driverId": 13293
        }
      ]
    },
    {
      "driver_id": 13295,
      "job_id": "LM0410",
      "jpurnal_item": [
        {
          "id": 50824,
          "driverId": 13295
        }
      ]
    },
    {
      "driver_id": 13296,
      "job_id": "LM0411",
      "jpurnal_item": [
        {
          "id": 50832,
          "driverId": 13296
        }
      ]
    },
    {
      "driver_id": 13297,
      "job_id": "LM0412",
      "jpurnal_item": [
        {
          "id": 50833,
          "driverId": 13297
        }
      ]
    },
    {
      "driver_id": 13342,
      "job_id": "F_BTC_495_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 51600,
          "driverId": 13342
        },
        {
          "id": 52239,
          "driverId": 13342
        },
        {
          "id": 52831,
          "driverId": 13342
        },
        {
          "id": 54092,
          "driverId": 13342
        },
        {
          "id": 54520,
          "driverId": 13342
        }
      ]
    },
    {
      "driver_id": 13344,
      "job_id": "F_BTC_547_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 51603,
          "driverId": 13344
        },
        {
          "id": 52240,
          "driverId": 13344
        },
        {
          "id": 52832,
          "driverId": 13344
        }
      ]
    },
    {
      "driver_id": 13516,
      "job_id": "F_BTC_494",
      "jpurnal_item": [
        {
          "id": 51599,
          "driverId": 13516
        }
      ]
    },
    {
      "driver_id": 13517,
      "job_id": "F_BTC_520",
      "jpurnal_item": [
        {
          "id": 51601,
          "driverId": 13517
        }
      ]
    },
    {
      "driver_id": 13518,
      "job_id": "F_BTC_522",
      "jpurnal_item": [
        {
          "id": 51602,
          "driverId": 13518
        },
        {
          "id": 52250,
          "driverId": 13518
        }
      ]
    },
    {
      "driver_id": 13519,
      "job_id": "F_BTC_550",
      "jpurnal_item": [
        {
          "id": 51604,
          "driverId": 13519
        }
      ]
    },
    {
      "driver_id": 13520,
      "job_id": "P_BTC_545",
      "jpurnal_item": [
        {
          "id": 51608,
          "driverId": 13520
        }
      ]
    },
    {
      "driver_id": 13521,
      "job_id": "P_BTC_558",
      "jpurnal_item": [
        {
          "id": 51609,
          "driverId": 13521
        }
      ]
    },
    {
      "driver_id": 13522,
      "job_id": "P_BTC_559",
      "jpurnal_item": [
        {
          "id": 51610,
          "driverId": 13522
        }
      ]
    },
    {
      "driver_id": 13598,
      "job_id": "F_BTC_583_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 52245,
          "driverId": 13598
        },
        {
          "id": 52833,
          "driverId": 13598
        },
        {
          "id": 54094,
          "driverId": 13598
        },
        {
          "id": 54521,
          "driverId": 13598
        }
      ]
    },
    {
      "driver_id": 13658,
      "job_id": "F_BTC_576",
      "jpurnal_item": [
        {
          "id": 52241,
          "driverId": 13658
        }
      ]
    },
    {
      "driver_id": 13659,
      "job_id": "F_BTC_577",
      "jpurnal_item": [
        {
          "id": 52242,
          "driverId": 13659
        }
      ]
    },
    {
      "driver_id": 13660,
      "job_id": "F_BTC_578",
      "jpurnal_item": [
        {
          "id": 52243,
          "driverId": 13660
        }
      ]
    },
    {
      "driver_id": 13661,
      "job_id": "F_BTC_579",
      "jpurnal_item": [
        {
          "id": 52244,
          "driverId": 13661
        }
      ]
    },
    {
      "driver_id": 13662,
      "job_id": "F_BTC_584",
      "jpurnal_item": [
        {
          "id": 52246,
          "driverId": 13662
        }
      ]
    },
    {
      "driver_id": 13663,
      "job_id": "F_BTC_585",
      "jpurnal_item": [
        {
          "id": 52247,
          "driverId": 13663
        }
      ]
    },
    {
      "driver_id": 13664,
      "job_id": "P_BTC_524",
      "jpurnal_item": [
        {
          "id": 52251,
          "driverId": 13664
        }
      ]
    },
    {
      "driver_id": 13665,
      "job_id": "P_BTC_525",
      "jpurnal_item": [
        {
          "id": 52252,
          "driverId": 13665
        }
      ]
    },
    {
      "driver_id": 13666,
      "job_id": "P_BTC_534",
      "jpurnal_item": [
        {
          "id": 52253,
          "driverId": 13666
        }
      ]
    },
    {
      "driver_id": 13859,
      "job_id": "F_BTC_647_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 54098,
          "driverId": 13859
        }
      ]
    },
    {
      "driver_id": 13866,
      "job_id": "F_BTC_602_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 52834,
          "driverId": 13866
        }
      ]
    },
    {
      "driver_id": 13867,
      "job_id": "F_BTC_620_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 52836,
          "driverId": 13867
        },
        {
          "id": 54096,
          "driverId": 13867
        },
        {
          "id": 54523,
          "driverId": 13867
        }
      ]
    },
    {
      "driver_id": 13871,
      "job_id": "F_BTC_702",
      "jpurnal_item": [
        {
          "id": 53396,
          "driverId": 13871
        }
      ]
    },
    {
      "driver_id": 13881,
      "job_id": "F_BTC_669",
      "jpurnal_item": [
        {
          "id": 53395,
          "driverId": 13881
        }
      ]
    },
    {
      "driver_id": 13949,
      "job_id": "F_BTC_625_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 54097,
          "driverId": 13949
        },
        {
          "id": 54524,
          "driverId": 13949
        }
      ]
    },
    {
      "driver_id": 13950,
      "job_id": "F_BTC_720_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 54099,
          "driverId": 13950
        }
      ]
    },
    {
      "driver_id": 13951,
      "job_id": "F_BTC_598_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 54095,
          "driverId": 13951
        },
        {
          "id": 54522,
          "driverId": 13951
        }
      ]
    },
    {
      "driver_id": 13993,
      "job_id": "F_BTC_114",
      "jpurnal_item": [
        {
          "id": 53380,
          "driverId": 13993
        }
      ]
    },
    {
      "driver_id": 13994,
      "job_id": "F_BTC_134_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 53381,
          "driverId": 13994
        },
        {
          "id": 54078,
          "driverId": 13994
        },
        {
          "id": 54513,
          "driverId": 13994
        }
      ]
    },
    {
      "driver_id": 13995,
      "job_id": "F_BTC_144",
      "jpurnal_item": [
        {
          "id": 53382,
          "driverId": 13995
        }
      ]
    },
    {
      "driver_id": 13996,
      "job_id": "F_BTC_180",
      "jpurnal_item": [
        {
          "id": 53383,
          "driverId": 13996
        }
      ]
    },
    {
      "driver_id": 13997,
      "job_id": "F_BTC_378",
      "jpurnal_item": [
        {
          "id": 53384,
          "driverId": 13997
        }
      ]
    },
    {
      "driver_id": 13998,
      "job_id": "F_BTC_379",
      "jpurnal_item": [
        {
          "id": 53385,
          "driverId": 13998
        }
      ]
    },
    {
      "driver_id": 13999,
      "job_id": "F_BTC_468",
      "jpurnal_item": [
        {
          "id": 53386,
          "driverId": 13999
        }
      ]
    },
    {
      "driver_id": 14000,
      "job_id": "F_BTC_488",
      "jpurnal_item": [
        {
          "id": 53387,
          "driverId": 14000
        }
      ]
    },
    {
      "driver_id": 14001,
      "job_id": "F_BTC_495",
      "jpurnal_item": [
        {
          "id": 53388,
          "driverId": 14001
        }
      ]
    },
    {
      "driver_id": 14002,
      "job_id": "F_BTC_547",
      "jpurnal_item": [
        {
          "id": 53389,
          "driverId": 14002
        }
      ]
    },
    {
      "driver_id": 14003,
      "job_id": "F_BTC_583",
      "jpurnal_item": [
        {
          "id": 53390,
          "driverId": 14003
        }
      ]
    },
    {
      "driver_id": 14004,
      "job_id": "F_BTC_620",
      "jpurnal_item": [
        {
          "id": 53391,
          "driverId": 14004
        }
      ]
    },
    {
      "driver_id": 14005,
      "job_id": "F_BTC_647",
      "jpurnal_item": [
        {
          "id": 53392,
          "driverId": 14005
        }
      ]
    },
    {
      "driver_id": 14006,
      "job_id": "F_BTC_662",
      "jpurnal_item": [
        {
          "id": 53393,
          "driverId": 14006
        }
      ]
    },
    {
      "driver_id": 14007,
      "job_id": "F_BTC_668",
      "jpurnal_item": [
        {
          "id": 53394,
          "driverId": 14007
        }
      ]
    },
    {
      "driver_id": 14008,
      "job_id": "F_BTC_720",
      "jpurnal_item": [
        {
          "id": 53397,
          "driverId": 14008
        }
      ]
    },
    {
      "driver_id": 14009,
      "job_id": "F_BTC_727",
      "jpurnal_item": [
        {
          "id": 53398,
          "driverId": 14009
        }
      ]
    },
    {
      "driver_id": 14010,
      "job_id": "F_BTC_728",
      "jpurnal_item": [
        {
          "id": 53399,
          "driverId": 14010
        }
      ]
    },
    {
      "driver_id": 14011,
      "job_id": "F_BTC_729",
      "jpurnal_item": [
        {
          "id": 53400,
          "driverId": 14011
        }
      ]
    },
    {
      "driver_id": 14012,
      "job_id": "F_BTC_731",
      "jpurnal_item": [
        {
          "id": 53401,
          "driverId": 14012
        }
      ]
    },
    {
      "driver_id": 14013,
      "job_id": "F_BTC_732",
      "jpurnal_item": [
        {
          "id": 53402,
          "driverId": 14013
        }
      ]
    },
    {
      "driver_id": 14014,
      "job_id": "P_BTC_223",
      "jpurnal_item": [
        {
          "id": 53403,
          "driverId": 14014
        }
      ]
    },
    {
      "driver_id": 14015,
      "job_id": "P_BTC_620",
      "jpurnal_item": [
        {
          "id": 53405,
          "driverId": 14015
        }
      ]
    },
    {
      "driver_id": 14016,
      "job_id": "P_BTC_677",
      "jpurnal_item": [
        {
          "id": 53406,
          "driverId": 14016
        }
      ]
    },
    {
      "driver_id": 14017,
      "job_id": "P_BTC_709",
      "jpurnal_item": [
        {
          "id": 53407,
          "driverId": 14017
        }
      ]
    },
    {
      "driver_id": 14018,
      "job_id": "P_BTC_718",
      "jpurnal_item": [
        {
          "id": 53408,
          "driverId": 14018
        }
      ]
    },
    {
      "driver_id": 14029,
      "job_id": "F_BTC_598",
      "jpurnal_item": [
        {
          "id": 53424,
          "driverId": 14029
        }
      ]
    },
    {
      "driver_id": 14031,
      "job_id": "F_BTC_7321",
      "jpurnal_item": [
        {
          "id": 53426,
          "driverId": 14031
        }
      ]
    },
    {
      "driver_id": 14151,
      "job_id": "F_BTC_727_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 54100,
          "driverId": 14151
        }
      ]
    },
    {
      "driver_id": 14152,
      "job_id": "F_BTC_729_NDD_RYD_",
      "jpurnal_item": [
        {
          "id": 54101,
          "driverId": 14152
        }
      ]
    },
    {
      "driver_id": 14153,
      "job_id": "F_BTC_731_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 54102,
          "driverId": 14153
        }
      ]
    },
    {
      "driver_id": 14154,
      "job_id": "F_BTC_732_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 54103,
          "driverId": 14154
        }
      ]
    },
    {
      "driver_id": 14155,
      "job_id": "P_BTC_223_NDD_RYD",
      "jpurnal_item": [
        {
          "id": 54104,
          "driverId": 14155
        }
      ]
    },
    {
      "driver_id": 11175,
      "job_id": "LM0308",
      "jpurnal_item": [
        {
          "id": 47223,
          "driverId": 11175
        },
        {
          "id": 50823,
          "driverId": 11175
        }
      ]
    },
    {
      "driver_id": 9404,
      "job_id": "LM0048",
      "jpurnal_item": [
        {
          "id": 43100,
          "driverId": 9404
        },
        {
          "id": 44312,
          "driverId": 9404
        }
      ]
    },
    {
      "driver_id": 9335,
      "job_id": "F_BTC_452",
      "jpurnal_item": [
        {
          "id": 43098,
          "driverId": 9335
        },
        {
          "id": 44311,
          "driverId": 9335
        },
        {
          "id": 45122,
          "driverId": 9335
        },
        {
          "id": 46068,
          "driverId": 9335
        },
        {
          "id": 47194,
          "driverId": 9335
        },
        {
          "id": 48299,
          "driverId": 9335
        },
        {
          "id": 49209,
          "driverId": 9335
        },
        {
          "id": 49876,
          "driverId": 9335
        },
        {
          "id": 50829,
          "driverId": 9335
        },
        {
          "id": 51746,
          "driverId": 9335
        }
      ]
    },
    {
      "driver_id": 9402,
      "job_id": "F_BTC_134",
      "jpurnal_item": [
        {
          "id": 43103,
          "driverId": 9402
        },
        {
          "id": 44309,
          "driverId": 9402
        },
        {
          "id": 45120,
          "driverId": 9402
        },
        {
          "id": 46067,
          "driverId": 9402
        },
        {
          "id": 47193,
          "driverId": 9402
        },
        {
          "id": 48288,
          "driverId": 9402
        },
        {
          "id": 49201,
          "driverId": 9402
        },
        {
          "id": 49875,
          "driverId": 9402
        },
        {
          "id": 50814,
          "driverId": 9402
        },
        {
          "id": 51590,
          "driverId": 9402
        },
        {
          "id": 52232,
          "driverId": 9402
        },
        {
          "id": 52824,
          "driverId": 9402
        }
      ]
    },
    {
      "driver_id": 9403,
      "job_id": "LM0047",
      "jpurnal_item": [
        {
          "id": 43101,
          "driverId": 9403
        },
        {
          "id": 44310,
          "driverId": 9403
        },
        {
          "id": 45121,
          "driverId": 9403
        },
        {
          "id": 50817,
          "driverId": 9403
        },
        {
          "id": 51598,
          "driverId": 9403
        }
      ]
    },
    {
      "driver_id": 9405,
      "job_id": "LM0049",
      "jpurnal_item": [
        {
          "id": 43102,
          "driverId": 9405
        }
      ]
    },
    {
      "driver_id": 9334,
      "job_id": "LM0042",
      "jpurnal_item": [
        {
          "id": 43099,
          "driverId": 9334
        }
      ]
    },
    {
      "driver_id": 9741,
      "job_id": "LM0098",
      "jpurnal_item": [
        {
          "id": 42958,
          "driverId": 9741
        },
        {
          "id": 44288,
          "driverId": 9741
        },
        {
          "id": 45140,
          "driverId": 9741
        }
      ]
    },
    {
      "driver_id": 9742,
      "job_id": "LM0099",
      "jpurnal_item": [
        {
          "id": 42957,
          "driverId": 9742
        },
        {
          "id": 44290,
          "driverId": 9742
        }
      ]
    },
    {
      "driver_id": 9743,
      "job_id": "LM00100",
      "jpurnal_item": [
        {
          "id": 42961,
          "driverId": 9743
        }
      ]
    },
    {
      "driver_id": 9744,
      "job_id": "LM00101",
      "jpurnal_item": [
        {
          "id": 42959,
          "driverId": 9744
        },
        {
          "id": 44291,
          "driverId": 9744
        },
        {
          "id": 45139,
          "driverId": 9744
        }
      ]
    },
    {
      "driver_id": 9745,
      "job_id": "LM00102",
      "jpurnal_item": [
        {
          "id": 42956,
          "driverId": 9745
        },
        {
          "id": 44287,
          "driverId": 9745
        },
        {
          "id": 45141,
          "driverId": 9745
        },
        {
          "id": 45898,
          "driverId": 9745
        }
      ]
    },
    {
      "driver_id": 9746,
      "job_id": "LM00103",
      "jpurnal_item": [
        {
          "id": 42960,
          "driverId": 9746
        },
        {
          "id": 44289,
          "driverId": 9746
        }
      ]
    },
    {
      "driver_id": 10204,
      "job_id": "LM0144",
      "jpurnal_item": [
        {
          "id": 42962,
          "driverId": 10204
        }
      ]
    },
    {
      "driver_id": 10205,
      "job_id": "LM0145",
      "jpurnal_item": [
        {
          "id": 42963,
          "driverId": 10205
        }
      ]
    },
    {
      "driver_id": 10206,
      "job_id": "LM0146",
      "jpurnal_item": [
        {
          "id": 42964,
          "driverId": 10206
        }
      ]
    },
    {
      "driver_id": 10208,
      "job_id": "LM0147",
      "jpurnal_item": [
        {
          "id": 42965,
          "driverId": 10208
        }
      ]
    },
    {
      "driver_id": 9865,
      "job_id": "LM010",
      "jpurnal_item": [
        {
          "id": 42919,
          "driverId": 9865
        },
        {
          "id": 44268,
          "driverId": 9865
        }
      ]
    },
    {
      "driver_id": 9866,
      "job_id": "LM011",
      "jpurnal_item": [
        {
          "id": 42920,
          "driverId": 9866
        },
        {
          "id": 44267,
          "driverId": 9866
        },
        {
          "id": 45146,
          "driverId": 9866
        }
      ]
    },
    {
      "driver_id": 9867,
      "job_id": "LM0112",
      "jpurnal_item": [
        {
          "id": 42922,
          "driverId": 9867
        },
        {
          "id": 44270,
          "driverId": 9867
        },
        {
          "id": 45147,
          "driverId": 9867
        }
      ]
    },
    {
      "driver_id": 9868,
      "job_id": "LM0113",
      "jpurnal_item": [
        {
          "id": 42923,
          "driverId": 9868
        }
      ]
    },
    {
      "driver_id": 9869,
      "job_id": "LM0114",
      "jpurnal_item": [
        {
          "id": 42924,
          "driverId": 9869
        }
      ]
    },
    {
      "driver_id": 9870,
      "job_id": "LM0115",
      "jpurnal_item": [
        {
          "id": 42925,
          "driverId": 9870
        }
      ]
    },
    {
      "driver_id": 9872,
      "job_id": "LM0117",
      "jpurnal_item": [
        {
          "id": 42931,
          "driverId": 9872
        }
      ]
    },
    {
      "driver_id": 9873,
      "job_id": "LM0118",
      "jpurnal_item": [
        {
          "id": 42921,
          "driverId": 9873
        },
        {
          "id": 44266,
          "driverId": 9873
        }
      ]
    },
    {
      "driver_id": 9875,
      "job_id": "LM0119",
      "jpurnal_item": [
        {
          "id": 42928,
          "driverId": 9875
        },
        {
          "id": 44269,
          "driverId": 9875
        }
      ]
    },
    {
      "driver_id": 10191,
      "job_id": "LM0",
      "jpurnal_item": [
        {
          "id": 42926,
          "driverId": 10191
        }
      ]
    },
    {
      "driver_id": 10201,
      "job_id": "LM0141",
      "jpurnal_item": [
        {
          "id": 42927,
          "driverId": 10201
        }
      ]
    },
    {
      "driver_id": 10202,
      "job_id": "LM0142",
      "jpurnal_item": [
        {
          "id": 42929,
          "driverId": 10202
        },
        {
          "id": 44271,
          "driverId": 10202
        }
      ]
    },
    {
      "driver_id": 10203,
      "job_id": "LM0143",
      "jpurnal_item": [
        {
          "id": 42930,
          "driverId": 10203
        }
      ]
    }
  ]';
         $LM_drivers = json_decode($LM_drivers, true);
         $returned_value ;
         $not_muched_note;
         foreach($LM_drivers as $driver){
            //  dd($driver);
             $jpurnal_item =$driver['jpurnal_item'];
             $driver_id = $driver['driver_id'];
              foreach($jpurnal_item as $item){
                  $loans = Packages_report::find($item['id']);
                  $loans->driverId = $driver_id;
                  $loans->save();

                  if($loans->driverId == $driver_id){
                      $returned_value[] = [
                          'loan_id'=>$item['id'],
                          'da_id'=>$driver_id,
                          'da_vps_id'=>$loans->driverId,
                          'da_job_id'=>$driver['job_id']
                          ];
                  }else{
                      dd('Not found DA: '.$driver_id);
                  }
              }
         }
        dd($returned_value);


    }
     public function CheckingLandmarkDAs(){
        // dd("CheckingLandmarkDAs");
        $name = '';
        $or_from = "PANDA-DMM-012";
        $or_to = 'OMER MAHMOUD';
        $from = $or_from;
        $to = $or_to;
        // dd($or_to);

        if($name != ''){
            $driver = Drivers::where('job_id',$or_to)->get();

            $action_2 = "".Auth::user()->name." Change the DA(".$driver[0]->job_id.") Name from (".$driver[0]->fullName.") to (".$name.")";
            $res = DB::insert("INSERT INTO `tbl_events_log`(`action`, `done_at`, `done_by`) VALUES ('".$action_2."',CURRENT_TIMESTAMP(),2)");
            // dd($action_2);
            $driver[0]->fullName =$name;
            $driver[0]->save();
        }

        $from = DB::select("select id,job_id from drivers where job_id='".$from."'");

        $from = $from[0]->id;

        $to = DB::select("select id,job_id from drivers where job_id='".$to."'");
        $to = $to[0]->id;
        // dd($to);
        // Balance
        $settelment = Settlements::where('driverId',$from)->get();
        foreach($settelment as $settelment_item){
            $settelment_item->driverId = $to;
            $settelment_item->note = $settelment_item->note." مٌرحلة من حساب (".$or_from.")";
            // dd($settelment_item->note);
            $settelment_item->save();
        }
        $crediteNote = CreditNotes::where('driverId',$from)->get();
        foreach($crediteNote as $crediteNote_item){
            $crediteNote_item->driverId = $to;
            $crediteNote_item->note = $crediteNote_item->note." مٌرحلة من حساب (".$or_from.")";
            $crediteNote_item->save();
        }
        $loans = Loan::where('driverId',$from)->get();
        foreach($loans as $loans_item){
            $loans_item->driverId = $to;
            $loans_item->note = $loans_item->note." مٌرحلة من حساب (".$or_from.")";
            $loans_item->save();
        }
        $dayload = Journal::where('driverId',$from)->get();
        foreach($dayload as $dayload_item){
            $dayload_item->driverId = $to;
            $dayload_item->save();
        }
        $packages_report = Packages_report::where('driverId',$from)->get();
        foreach($packages_report as $packages_report_item){
            $packages_report_item->driverId = $to;
            $packages_report_item->save();
        }
        //End Blance
        try {
            $driver = DB::select("DELETE from drivers where id=".$from."");
        } catch (\Throwable $th) {
            //throw $th;
            dd("CAN NOT DELETE DA: ".$from);
        }



        $actio_des = "".Auth::user()->name." Has transferred all DA(".$or_from.") recoredes to DA(".$or_to.")";
        // dd($actio_des);
        $res = DB::insert("INSERT INTO `tbl_events_log`(`action`, `done_at`, `done_by`) VALUES ('".$actio_des."',CURRENT_TIMESTAMP(),2)");
        dd("Done");
    }
    public function propertiesConfirm($token){
        dd($token);
        // sleep(2);
        // dd(Auth::user());
        // $sql = "UPDATE `properties_assignment` SET `delivery_timestamp`=NOW()  WHERE `reference_no`='".$token."'";
        $payload = DB::update("UPDATE `properties_assignment` SET `delivery_timestamp`=NOW() WHERE `reference_no`='".$token."'");
        //  dd($payload);
        // send a confirmation email to created by or/and HR
        return "propertiesConfirm";
    }
    function CompanyProprtiesIssuanceForm($user_id){

        // $filename = 'hello_world.pdf';
        $sql = "SELECT users.name as 'user_name',users.department,users.IdentityNo,btc_properties.*,lkp_properties_category.name_ar as 'category_name_ar',lkp_properties_status.status_ar,`properties_assignment`.reference_no,`properties_assignment`.delivery_timestamp FROM `properties_assignment` JOIN users ON users.id = properties_assignment.user_id JOIN btc_properties ON btc_properties.id = properties_assignment.property_id JOIN lkp_properties_category ON lkp_properties_category.id = btc_properties.property_id JOIN lkp_properties_status ON lkp_properties_status.id = btc_properties.status_id WHERE properties_assignment.reference_no = '".$user_id."';"; //2
        $payload = DB::select($sql);
        // dd($payload[0]->category_name_ar);
        $table ;
        foreach($payload as $getuniq){
            // dd($getuniq->category_name_ar);
            $uniq_array[] = $getuniq->name.' ('.$getuniq->category_name_ar.') - '.$getuniq->description ;
        }
        $uniq_arrayssss = array_unique($uniq_array);
        $uniq_array = array_count_values($uniq_array);
        foreach($uniq_arrayssss as $item){
            $table[] = [
                "description"=>$item,
                "status"=>$getuniq->status_ar,
                "qty"=>$uniq_array[$item]
            ];
        }
        // dd($payload);
        return view('CompanyProprtiesIssuanceForm',compact('payload','table'));
        return response()->download(public_path($filename));

        // return view('CompanyProprtiesIssuanceForm');
    }
    function index(){
        $json_data = '
        [
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2482,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8230,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8235,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2471,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2446,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2484,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2478,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8248,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8255,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2479,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2474,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8243,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 3192,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "فان بضاعه",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8271,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2483,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8245,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8267,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8229,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8261,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8246,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8268,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2450,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2435,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8262,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8274,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8244,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2448,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8225,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2473,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8266,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8242,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2486,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8238,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8247,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8257,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ك",
                    "number": 4876,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "فان بضاعه",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8253,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2477,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ص",
                    "number": 1913,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2489,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8232,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ص",
                    "number": 1905,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8258,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8256,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8273,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8228,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2488,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2481,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2475,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8234,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2480,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8249,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8240,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2472,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8270,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8239,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8259,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8227,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8263,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8241,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8251,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8264,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2449,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8254,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8233,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2487,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8236,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8237,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4966,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4973,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4984,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4981,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4969,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4968,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4970,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4982,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4967,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4971,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4978,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4983,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4965,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4974,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4975,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4976,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6497,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7455,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5437,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8320,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7457,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6510,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5438,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6538,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5432,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6459,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5448,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5156,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5078,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5443,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8469,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6509,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6511,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8323,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6492,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6534,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6493,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5430,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6430,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4357,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6569,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5079,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6491,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6517,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8302,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6574,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5434,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6431,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4551,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7453,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6530,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8310,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6536,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5450,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8472,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6540,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5433,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6513,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6489,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7499,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6462,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6516,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6496,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4591,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8467,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8308,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7454,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8321,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7452,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8301,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6546,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6514,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5158,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8470,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6531,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8322,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6533,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6461,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4356,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8306,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5153,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6535,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },        {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7500,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5440,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6532,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7460,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6460,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6487,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6572,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6220,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6515,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6495,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8307,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6570,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6490,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5439,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8471,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5441,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6512,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5442,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6543,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7458,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            }
            ,
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5447,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6573,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8305,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7472,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6571,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8466,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5152,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8468,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8309,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6537,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7456,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4355,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5431,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8304,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5157,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6432,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5154,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5446,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7498,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5436,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8311,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5449,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6539,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8303,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "س",
                    "text3": "ي",
                    "number": 8000,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "لاندروفر",
                    "model": "رانج روفر",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6494,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5435,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            }


        ]';

        $jsonArray = json_decode($json_data, true);
        $html = "<table style='text-align: center;'>
            <tr>
                <th>#</th>
                <th>الوحة </th>
                <th>الشركة المصنعة </th>
                <th>الموديل </th>
                <th>تاريخ الصنع </th>
                <th>  اسم المالك </th>
                <th>رقم الهيكل </th>
                <th>الرقم التسلسلي </th>
                <th>اللون   </th>
            </tr> ";
        foreach($jsonArray as $k=>$item){
            $html = $html . "<tr>";

            $makerAndModel= $item['makerAndModel'];
            // dd($makerAndModel['maker']);
            $plate = $item;
            $ownerName = $plate['ownerName'];
            // dd($ownerName['ar']);
            $plate2 = $plate['plate'];
            $vehicles_plate = $plate2['text1'].' '.$plate2['text2'].' '.$plate2['text3'].' '.$plate2['number'];
            // dd($vehicles_plate);
            $html = $html . "<td>".++$k."</td>
                            <td>".$vehicles_plate."</td>
                            <td>".$makerAndModel['maker']."</td>
                            <td>".$makerAndModel['model']."</td>
                            <td>".$makerAndModel['year']."</td>
                            <td>".$ownerName['ar']."</td>
            ";
            $select = "select * from vehicles where plate like '%".$vehicles_plate."%'";
            $select = DB::select($select);
            // dd($select);
            if(count($select)>0){
                // dd($select[0]->body_number);
                $html = $html . "<td>".$select[0]->body_number."</td>
                                    <td>".$select[0]->SNno."</td>
                                    <td>".$select[0]->color."</td>";
            }else{
                $html = $html . "<td>لم يتم العثور على المركبة       </td>
                <td>لم يتم العثور على المركبة   </td>
                <td>لم يتم العثور على المركبة       </td>";
            }
            $html = $html . "</tr>";
        }
         echo $html. "</table>";
         exit;
         // true for associative arrays, false for objects
        // var_dump($jsonArray);

        $vehicle = array("vehicles_plate"=>$vehicles_plate,"vehicle_man_year"=>$makerAndModel['maker'],"model"=>$makerAndModel['model']);
        // $makerAndModel = $plate ;

        dd($vehicle);
        dd($plate2['text1'].' '.$plate2['text2'].' '.$plate2['text3'].' '.$plate2['number']);
    }

}
