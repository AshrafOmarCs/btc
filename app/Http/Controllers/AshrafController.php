<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;

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
    function sync_fuel() {

        $json = '[
    {
        "job_id": "1728629202088877",
        "Name": "FISSAL KHALIFA",
        "iqama": "2486716430",
        "mobile": "562932717"
    },
    {
        "job_id": "1728791242088126",
        "Name": "HOSAM IBRAHIM",
        "iqama": "2556960546",
        "mobile": "565782850"
    },
    {
        "job_id": "1726514103206337",
        "Name": "ABDULHAFITH MANSOUR",
        "iqama": "2193426661",
        "mobile": "559914437"
    },
    {
        "job_id": "1727844574202675",
        "Name": "ABDULWAHAB ALBUJALI",
        "iqama": "2448132262",
        "mobile": "506533653"
    },
    {
        "job_id": "1727761640202116",
        "Name": "Maged Alsbri",
        "iqama": "2525537565",
        "mobile": "572000365"
    },
    {
        "job_id": "1727348275237016",
        "Name": "PETER MBUIYA",
        "iqama": "2505954145",
        "mobile": "578790184"
    },
    {
        "job_id": "1727610328060549",
        "Name": "Delor Ali",
        "iqama": "2507057764",
        "mobile": "577158127"
    },
    {
        "job_id": "1727589833206783",
        "Name": "Osamah Alansi",
        "iqama": "2519453928",
        "mobile": "532195156"
    },
    {
        "job_id": "1726260156237550",
        "Name": "AMMAR OMER",
        "iqama": "2520831823",
        "mobile": "568599351"
    },
    {
        "job_id": "1727591032060704",
        "Name": "Mian Abdul Majeed",
        "iqama": "2543621268",
        "mobile": "567225017"
    },
    {
        "job_id": "1727894531237311",
        "Name": "Husameldeen Ahmed",
        "iqama": "2523556922",
        "mobile": "564352711"
    },
    {
        "job_id": "1727243225202592",
        "Name": "ALI ALI",
        "iqama": "2525008393",
        "mobile": "570180055"
    },
    {
        "job_id": "1727596007257857",
        "Name": "AIMAN AL WADEAI\n",
        "iqama": "2538296340",
        "mobile": "531104510"
    },
    {
        "job_id": "1730014962480460",
        "Name": "Tamim Abul",
        "iqama": "2545674265",
        "mobile": "597610051"
    },
    {
        "job_id": "1726919062088763",
        "Name": "MOHAMMED ALGUMAEI",
        "iqama": "2546104171",
        "mobile": "556619264"
    },
    {
        "job_id": "1726512677088806",
        "Name": "MOHAMMED AL QADHI",
        "iqama": "2553725991",
        "mobile": "537613453"
    },
    {
        "job_id": "1726511383257069",
        "Name": "ALI ALI",
        "iqama": "2562751624",
        "mobile": "536011859"
    },
    {
        "job_id": "1728129305088127",
        "Name": "MUHAMMAD ARIF",
        "iqama": "2565339039",
        "mobile": "593388497"
    },
    {
        "job_id": "1726081357202160",
        "Name": "ABDALLA MOHAMMED",
        "iqama": "2488718657",
        "mobile": "505775721"
    },
    {
        "job_id": "1726336085419131",
        "Name": "ELQHOURSHI ADAM",
        "iqama": "2517482101",
        "mobile": "506115868"
    },
    {
        "job_id": "1726088276480708",
        "Name": "SHEROZE ALI",
        "iqama": "2512846326",
        "mobile": "574698088"
    },
    {
        "job_id": "1726075464257320",
        "Name": "RAED ALGABRI",
        "iqama": "2540638901",
        "mobile": "550659527"
    },
    {
        "job_id": "1727847253257405",
        "Name": "Ouais Mohamednour",
        "iqama": "2581882046",
        "mobile": "580335658"
    },
    {
        "job_id": "1727186782088578",
        "Name": "Shamel Alhaig",
        "iqama": "2542959172",
        "mobile": "547109098"
    },
    {
        "job_id": "1726917491419647",
        "Name": "Sohaib Khalifa",
        "iqama": "2567232927",
        "mobile": "531584229"
    },
    {
        "job_id": "1726401994237795",
        "Name": "ahmed mohammed",
        "iqama": "2579917820",
        "mobile": "536246558"
    },
    {
        "job_id": "1728300201088684",
        "Name": "Ohayed Mohamed",
        "iqama": "2581895279",
        "mobile": "538712237"
    },
    {
        "job_id": "1727757507237677",
        "Name": "HUSHAM MOHAMED",
        "iqama": "2391954357",
        "mobile": "544570072"
    },
    {
        "job_id": "1729109403202544",
        "Name": "Ahmed Saeed",
        "iqama": "2504205846",
        "mobile": "507399270"
    },
    {
        "job_id": "1726074418257189",
        "Name": "Ahmed Omer",
        "iqama": "2502943828",
        "mobile": "507218994"
    },
    {
        "job_id": "1727253171237630",
        "Name": "ALI AL SHAHERI",
        "iqama": "2579081122",
        "mobile": "539653898"
    },
    {
        "job_id": "1726074952419948",
        "Name": "Adeb Abdo",
        "iqama": "2538674215",
        "mobile": "559586202"
    },
    {
        "job_id": "1726080312257136",
        "Name": "Ali Mousa",
        "iqama": "2542622671",
        "mobile": "578391890"
    },
    {
        "job_id": "1727893958257868",
        "Name": "Elamin Salim",
        "iqama": "2547278768",
        "mobile": "532097481"
    },
    {
        "job_id": "1727340140237512",
        "Name": "NIAZ BAKHT",
        "iqama": "2583188392",
        "mobile": "548513253"
    },
    {
        "job_id": "1726080959088913",
        "Name": "MOHAMMED ALKHALI",
        "iqama": "2544283993",
        "mobile": "504973419"
    },
    {
        "job_id": "1726916744202758",
        "Name": "FOUAD ABDELFATAH",
        "iqama": "2494940022",
        "mobile": "551101579"
    },
    {
        "job_id": "1728385414202998",
        "Name": "GAMAL OSMAN MAHGOUB ELHASSAN",
        "iqama": "2311129163",
        "mobile": "568712941"
    },
    {
        "job_id": "1729773821206109",
        "Name": "Amar Elemam",
        "iqama": "2324685847",
        "mobile": "534366849"
    },
    {
        "job_id": "1728790650206931",
        "Name": "SULTAN SALEH",
        "iqama": "2371717774",
        "mobile": "530768351"
    },
    {
        "job_id": "1729162822480710",
        "Name": "ELDISAWY NOUR",
        "iqama": "2398123733",
        "mobile": "543234071"
    },
    {
        "job_id": "1729411587237638",
        "Name": "Osama Eldaw",
        "iqama": "2420033736",
        "mobile": "532647228"
    },
    {
        "job_id": "1729328841480264",
        "Name": "AHMED ALHAAJJAJI",
        "iqama": "2318541154",
        "mobile": "550610341"
    },
    {
        "job_id": "1726084600257287",
        "Name": "ABDULLAH ALHAJJAJI",
        "iqama": "2500999483",
        "mobile": "548816306"
    },
    {
        "job_id": "1727420353060217",
        "Name": "NASR AL GALAL",
        "iqama": "2498006176",
        "mobile": "556188076"
    },
    {
        "job_id": "1727377972060382",
        "Name": "EMADALDEEN ABU SHIHAH",
        "iqama": "2517695819",
        "mobile": "581557235"
    },
    {
        "job_id": "1727585309206581",
        "Name": "ABDULRAHMAN QAMHAN",
        "iqama": "2552062743",
        "mobile": "567746857"
    },
    {
        "job_id": "1729702071237309",
        "Name": "OMIR ALSIRS",
        "iqama": "2564836746",
        "mobile": "534721853"
    },
    {
        "job_id": "1730108070088748",
        "Name": "Ahmat Abdelkerim",
        "iqama": "2197120518",
        "mobile": "541134713"
    },
    {
        "job_id": "1728571694480251",
        "Name": "ASHRAF ALI",
        "iqama": "2483487498",
        "mobile": "502601084"
    },
    {
        "job_id": "1729685750060889",
        "Name": "MUHAMMAD ALI",
        "iqama": "2519294728",
        "mobile": "566485360"
    },
    {
        "job_id": "1727344565237495",
        "Name": "MAHMOUD SOLIMAN",
        "iqama": "2534275504",
        "mobile": "540562616"
    },
    {
        "job_id": "1727251407088881",
        "Name": "Mofreh Mohamed",
        "iqama": "2560320414",
        "mobile": "550262849"
    },
    {
        "job_id": "1728485224237087",
        "Name": "OMER ALEMAM",
        "iqama": "2413277522",
        "mobile": "553147539"
    },
    {
        "job_id": "1726834395088449",
        "Name": "Eshaq Farhan",
        "iqama": "2254661347",
        "mobile": "510535961"
    },
    {
        "job_id": "1729608550206592",
        "Name": "Omer ALmagmar",
        "iqama": "2531367544",
        "mobile": "511019432"
    },
    {
        "job_id": "1728385926206396",
        "Name": "Alneel Hamed",
        "iqama": "2564594832",
        "mobile": "510152519"
    },
    {
        "job_id": "1729339690480548",
        "Name": "Ahmed Jahshan",
        "iqama": "2519612457",
        "mobile": "580179887"
    },
    {
        "job_id": "1729717526257545",
        "Name": "Mohamed Ibrahim",
        "iqama": "2519294728",
        "mobile": "544284674"
    },
    {
        "job_id": "1729002670480463",
        "Name": "Lutfi Salem",
        "iqama": "2363183191",
        "mobile": "575807763"
    },
    {
        "job_id": "1730018285088915",
        "Name": "Alberto Soria",
        "iqama": "2451161430",
        "mobile": "572208034"
    },
    {
        "job_id": "1729510019257288",
        "Name": "TARIG ALIM",
        "iqama": "2336548041",
        "mobile": "502551813"
    },
    {
        "job_id": "1729080213480752",
        "Name": "Mohamed Ahmed",
        "iqama": "2400748014",
        "mobile": "535657936"
    },
    {
        "job_id": "1729409166206057",
        "Name": "Alwaled Mashgari",
        "iqama": "2574898991",
        "mobile": "556417759"
    },
    {
        "job_id": "1729294301257580",
        "Name": "HIDAYAT ULLAH",
        "iqama": "2276458961",
        "mobile": "565949392"
    },
    {
        "job_id": "1729452948206126",
        "Name": "Mohammed Alwan",
        "iqama": "2501230888",
        "mobile": "556189517"
    },
    {
        "job_id": "1729948722480462",
        "Name": "Salem Alsurayri",
        "iqama": "2122545359",
        "mobile": "503128660"
    },
    {
        "job_id": "1728975073088169",
        "Name": "AHMED MOHAMED",
        "iqama": "2436170738",
        "mobile": "505989578"
    },
    {
        "job_id": "1728809021237425",
        "Name": "RABEA AHMED",
        "iqama": "2542213273",
        "mobile": "546519330"
    },
    {
        "job_id": "1728974633257623",
        "Name": "NABIL BAGGASH",
        "iqama": "2504074788",
        "mobile": "546691707"
    },
    {
        "job_id": "1727790707060987",
        "Name": "DEIAELDIN MOHAMED",
        "iqama": "2483753543",
        "mobile": "545624203"
    },
    {
        "job_id": "1727845987206754",
        "Name": "MAHMOOD ALFAAZI",
        "iqama": "2557525264",
        "mobile": "569722634"
    },
    {
        "job_id": "1727585935206408",
        "Name": "AHMED OFAN",
        "iqama": "2501255828",
        "mobile": "510558969"
    },
    {
        "job_id": "1727760826237144",
        "Name": "ADEB AL GARADI",
        "iqama": "2553990280",
        "mobile": "553398840"
    }
]';
        $json = json_decode($json);


        // dd($json);
        $new_drivers = array();
        foreach($json as $ittem){
            // dd($ittem->BANK);
             $driver = Drivers::where('job_id',$ittem->job_id)->get();

             if(count($driver)>0){
                 $driver= $driver[0];

                 $driver->iqama  = $ittem->iqama;
                 $driver->mobileNumber  = $ittem->mobile;
                //  $driver->benIBAN  = $ittem->IBAN;
                //  $driver->benIqama  = $ittem->BENIFICIARY_ID;
                //  $driver->iqama  = 'bank_id ';
                $driver->save();
                // dd($driver);

             }else{
                 $new_drivers[]= $ittem;
             }




        }
       dd($new_drivers);


        exit;
        $success_recored = array();
        $unsuccess_recored = array();
        $fuel_expenses = DB::select("SELECT vehicles_fuel.id, vehicles_fuel.vehicle_id, year, month, day FROM `vehicles_fuel` JOIN vehicles ON vehicles.id = vehicles_fuel.vehicle_id WHERE vehicles_fuel.driver_id ='' and month = 10");


        foreach ($fuel_expenses as $fuel_expense) {
            $vehicle_id = $fuel_expense->vehicle_id;

            if($fuel_expense->month<10){
                $fuel_expense->month = '0'.$fuel_expense->month;
            }



            if($fuel_expense->day<10){
                $fuel_expense->day = '0'.$fuel_expense->day;
            }


            $date = $fuel_expense->year.'-'.$fuel_expense->month.'-'.$fuel_expense->day;



            $delegation = DB::select("SELECT * FROM `drivers_attendance` WHERE `vehicle_id` = ".$vehicle_id." and date ='".$date."' ORDER BY `drivers_attendance`.`id` DESC;");
            // $delegation = DB::select("SELECT drivers.job_id FROM delegations INNER JOIN drivers ON delegations.driverId=drivers.id WHERE delegations.vehicle_id = '$vehicle_id' AND starting_date <= '$date' AND ending_date >= '$date' AND return_otometer_read_timesamp is NULL");
            // $delegation = DB::select("SELECT drivers.job_id FROM delegations INNER JOIN drivers ON delegations.driverId=drivers.id WHERE delegations.vehicle_id = '$vehicle_id' AND starting_date <= '$date' AND return_otometer_read_timesamp >= '$date'");

           if(count($delegation)>0){
               $delegation = $delegation[0];
               echo $delegation->job_id . ":::<br>";
                $job_id = $delegation->job_id;
                $id = $fuel_expense->id;
                DB::update("UPDATE vehicles_fuel set driver_id = '$job_id' WHERE id = '$id'");
           }
          dd($delegation);

        //     if (count($delegation) > 0) {
        //         echo $delegation[0]->job_id . ":::<br>";
        //         $job_id = $delegation[0]->job_id;
        //         $id = $fuel_expense->id;
        //         // DB::update("UPDATE vehicles_fuel set driver_id = '$job_id' WHERE id = '$id'");
        //     }
        }

        exit();



        // foreach($fuel_expenses as $fuel_expense){
        //     if($fuel_expense->month<10){
        //         $fuel_expense->month = '0'.$fuel_expense->month;
        //     }
        //     if($fuel_expense->day<10){
        //         $fuel_expense->day = '0'.$fuel_expense->day;
        //     }
        //     $date = $fuel_expense->year.'-'.$fuel_expense->month.'-'.$fuel_expense->day;
        //     $sql ="SELECT drivers_attendance.id,drivers_attendance.vehicle_id,drivers_attendance.job_id,drivers_attendance.date,vehicles.plate,vehicles.current_status,vehicles.fuel_tag FROM `drivers_attendance`
        //     JOIN vehicles ON vehicles.id = drivers_attendance.vehicle_id where drivers_attendance.date like '%".$date."%' and drivers_attendance.vehicle_id=".$fuel_expense->vehicle_id.";";
        //     $response = DB::select($sql);
        //     foreach($response as $respo){
        //         $ddate= $respo->date;
        //         // day
        //         $ddate = $ddate[8].$ddate[9];
        //         if($respo->job_id == ''){
        //             // check tamm then check drivers
        //             $delegation = "SELECT delegations.*,vehicles.plate,drivers.job_id,drivers.id as 'drivers_id',drivers.fullName FROM `delegations` join vehicles ON vehicles.id = delegations.vehicle_id JOIN drivers on drivers.id = delegations.driverId WHERE vehicles.fuel_tag LIKE '".$respo->fuel_tag."';";
        //             $delegation = DB::select($delegation);
        //             if(count($delegation)>0){
        //                 if(empty($delegation[0]->return_otometer_read_timesamp)){
        //                     // completed delegation
        //                     $started_at =$delegation[0]->starting_date;
        //                     $expires_at =$delegation[0]->ending_date;
        //                     $paymentDate = date($date);
        //                     $paymentDate=date('Y-m-d', strtotime($paymentDate));
        //                     //echo $paymentDate; // echos today!
        //                     $contractDateBegin = date('Y-m-d', strtotime($started_at));

        //                     $contractDateEnd = date('Y-m-d', strtotime($expires_at));

        //                     if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
        //                         // dd($delegation);
        //                         $respo->job_id =$delegation[0]->job_id;
        //                         $respo->fuel_expense =$fuel_expense->fuel_price;
        //                         $respo->status = true;
        //                         $respo->linked_by = 'LINKED BY DELEGATION ';
        //                         $success_recored[] = $respo;
        //                         $sql = "SELECT * FROM `vehicles_fuel` WHERE `fuel_price`='".$respo->fuel_expense."' and `day`=".$ddate." and vehicle_id=".$respo->vehicle_id." ";
        //                         $vehicles_fuel_to_update = DB::select($sql);
        //                         if(count($vehicles_fuel_to_update)>0){
        //                             DB::select("UPDATE `vehicles_fuel` SET `driver_id`='".$respo->job_id."' where id =".$vehicles_fuel_to_update[0]->id." ");
        //                         }
        //                         // dd($sql);
        //                     }else{

        //                         $respo->fuel_expense =$fuel_expense->fuel_price;
        //                         $respo->status = false;
        //                         $respo->linked_by = 'A Not LINKED';
        //                         $success_recored[] = $respo;
        //                     }
        //                 }else{
        //                     $started_at =$delegation[0]->starting_date;
        //                     $expires_at =$delegation[0]->return_otometer_read_timesamp;
        //                     $paymentDate = date($date);
        //                     $paymentDate=date('Y-m-d', strtotime($paymentDate));
        //                     //echo $paymentDate; // echos today!
        //                     $contractDateBegin = date('Y-m-d', strtotime($started_at));

        //                     $contractDateEnd = date('Y-m-d', strtotime($expires_at));

        //                     if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
        //                         // dd($delegation);
        //                         // dd($respo);
        //                         // $sql = "SELECT * FROM `vehicles_fuel` WHERE `fuel_price`='".$respo->fuel_expense."' and `day`='".$ddate."'";
        //                         // dd($sql);

        //                         $sql = "SELECT * FROM `vehicles_fuel` WHERE `fuel_price`='".$fuel_expense->fuel_price."' and `day`=".$ddate." and vehicle_id=".$respo->vehicle_id." ";
        //                         $vehicles_fuel_to_update = DB::select($sql);
        //                         if(count($vehicles_fuel_to_update)>0){
        //                             DB::select("UPDATE `vehicles_fuel` SET `driver_id`='".$delegation[0]->job_id."' where id =".$vehicles_fuel_to_update[0]->id." ");
        //                         }

        //                         $respo->job_id =$delegation[0]->job_id;
        //                         $respo->fuel_expense =$fuel_expense->fuel_price;
        //                         $respo->status = true;
        //                         $respo->linked_by = 'LINKED BY DELEGATION ';
        //                         $success_recored[] = $respo;
        //                     }else{

        //                         $respo->fuel_expense =$fuel_expense->fuel_price;
        //                         $respo->status = false;
        //                         $respo->linked_by = 'B Not LINKED';
        //                         $success_recored[] = $respo;
        //                     }
        //                 }
        //             }else{
        //                     // if($respo->fuel_tag == '0C8C436DD47542NS'){
        //                     //     dd($respo);
        //                     // }
        //                     $respo->fuel_expense =$fuel_expense->fuel_price;
        //                     $respo->status = false;
        //                     $respo->linked_by = 'C Not LINKED';
        //                     $success_recored[] = $respo;
        //                 }
        //             // $respo->fuel_expense =$fuel_expense->fuel_price;
        //             // $respo->status = false;
        //             // $respo->linked_by = 'NOT LINKED ';
        //             // $success_recored[] = $respo;
        //         }else{
        //             // dd($respo);
        //             $respo->fuel_expense =$fuel_expense->fuel_price;
        //             $respo->status = true;
        //             $respo->linked_by = 'LINKED BY FUEL TAG & BTC DELEGATION ';
        //             $success_recored[] = $respo;
        //             $sql = "SELECT * FROM `vehicles_fuel` WHERE `fuel_price`='".$respo->fuel_expense."' and `day`=".$ddate." and vehicle_id=".$respo->vehicle_id." ";
        //             $vehicles_fuel_to_update = DB::select($sql);
        //             if(count($vehicles_fuel_to_update)>0){
        //                 DB::select("UPDATE `vehicles_fuel` SET `driver_id`='".$respo->job_id."' where id =".$vehicles_fuel_to_update[0]->id." ");
        //             }
        //         }
        //     }

        //     // dd($fuel_expense);
        // }

        // foreach($success_recored as $success_rec){
        //     // dd($success_rec->job_id);
        //     // dd($success_rec);
        // }
        // // dd($success_recored);
        // return view('showFuelBlade',compact('success_recored'));






        // INSERT INTO `vehicles_fuel` (`id`, `vehicle_id`, `fuel_price`, `year`, `month`, `day`, `added_at`) VALUES (NULL, '338', '20.12', '2024', '8', '1', '2024-08-27 16:58:47');
        $data = '[
    {
        "1": "53.28",
        "2": "0",
        "3": "63.36",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "78.84",
        "8": "0",
        "9": "0",
        "10": "72.36",
        "11": "0",
        "12": "0",
        "13": "76.44",
        "14": "0",
        "15": "49.25",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "59.14",
        "20": "0",
        "21": "0",
        "22": "60",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "60.01",
        "27": "0",
        "28": "0",
        "29": "68.86",
        "30": "0",
        "31": "0",
        "tag_reference": "330126DCD10A45NS",
        "Total": "641.54"
    },
    {
        "1": "84.15",
        "2": "0",
        "3": "0",
        "4": "80.04",
        "5": "0",
        "6": "63.89",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "81.75",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "82.13",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "84.17",
        "24": "0",
        "25": "76.51",
        "26": "0",
        "27": "62.41",
        "28": "0",
        "29": "78.23",
        "30": "56.72",
        "31": "0",
        "tag_reference": "93CDA62B04E94ANS",
        "Total": "750"
    },
    {
        "1": "0",
        "2": "0",
        "3": "79.05",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "63.76",
        "8": "0",
        "9": "39.4",
        "10": "16.7",
        "11": "0",
        "12": "0",
        "13": "49.81",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "60.28",
        "18": "0",
        "19": "22.97",
        "20": "0",
        "21": "0",
        "22": "57.55",
        "23": "0",
        "24": "0",
        "25": "58.58",
        "26": "0",
        "27": "46.25",
        "28": "0",
        "29": "66.46",
        "30": "0",
        "31": "31.77",
        "tag_reference": "A9158486B86D48NS",
        "Total": "592.58"
    },
    {
        "1": "0",
        "2": "0",
        "3": "76.67",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "67.36",
        "8": "0",
        "9": "0",
        "10": "70.51",
        "11": "0",
        "12": "0",
        "13": "60.33",
        "14": "0",
        "15": "37.06",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "84.41",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "85.22",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "68.01",
        "29": "0",
        "30": "82.02",
        "31": "0",
        "tag_reference": "F5C25E3A5BD24BNS",
        "Total": "631.59"
    },
    {
        "1": "61.21",
        "2": "0",
        "3": "73.46",
        "4": "0",
        "5": "0",
        "6": "59.58",
        "7": "0",
        "8": "53.67",
        "9": "0",
        "10": "0",
        "11": "69.15",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "71.55",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "73.23",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "66.32",
        "25": "0",
        "26": "0",
        "27": "69.72",
        "28": "0",
        "29": "0",
        "30": "69.25",
        "31": "0",
        "tag_reference": "496FC63587DF43NS",
        "Total": "667.14"
    },
    {
        "1": "49.53",
        "2": "0",
        "3": "73.94",
        "4": "0",
        "5": "0",
        "6": "56.12",
        "7": "0",
        "8": "0",
        "9": "37.03",
        "10": "0",
        "11": "0",
        "12": "74.12",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "72.61",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "77",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "69.97",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "6CC2A62842EF47NS",
        "Total": "510.32"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "04A1B180799344NS",
        "Total": "120"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "35.42",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "37.76",
        "17": "40",
        "18": "40",
        "19": "38.48",
        "20": "0",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "38.59",
        "27": "0",
        "28": "40",
        "29": "35.73",
        "30": "40",
        "31": "40",
        "tag_reference": "023F6815602945NS",
        "Total": "1065.98"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "0",
        "9": "38.67",
        "10": "37.84",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "27.01",
        "17": "40",
        "18": "0",
        "19": "40",
        "20": "40",
        "21": "38.59",
        "22": "35",
        "23": "30.89",
        "24": "25.7",
        "25": "34.83",
        "26": "28.94",
        "27": "40",
        "28": "40",
        "29": "35",
        "30": "40",
        "31": "40",
        "tag_reference": "0D4FFD70F0DA48NS",
        "Total": "1012.47"
    },
    {
        "1": "36.34",
        "2": "0",
        "3": "40",
        "4": "31.09",
        "5": "34.86",
        "6": "28.32",
        "7": "40",
        "8": "40",
        "9": "0",
        "10": "40",
        "11": "33.03",
        "12": "33.16",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "39.78",
        "21": "33.92",
        "22": "35.99",
        "23": "0",
        "24": "40",
        "25": "37.1",
        "26": "28.62",
        "27": "27.16",
        "28": "32.48",
        "29": "33.64",
        "30": "0",
        "31": "40",
        "tag_reference": "0C8C436DD47542NS",
        "Total": "905.49"
    },
    {
        "1": "0",
        "2": "0",
        "3": "40",
        "4": "0",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "40",
        "11": "0",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "0",
        "22": "40",
        "23": "0",
        "24": "35",
        "25": "0",
        "26": "40",
        "27": "0",
        "28": "35",
        "29": "35",
        "30": "0",
        "31": "0",
        "tag_reference": "128A2A487C0649NS",
        "Total": "545"
    },
    {
        "1": "40",
        "2": "34.42",
        "3": "26.62",
        "4": "40",
        "5": "29.98",
        "6": "0",
        "7": "40",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "37.89",
        "18": "36.56",
        "19": "22.5",
        "20": "30.89",
        "21": "22.02",
        "22": "28.78",
        "23": "27.38",
        "24": "31.44",
        "25": "36.69",
        "26": "30.45",
        "27": "35",
        "28": "24.42",
        "29": "30",
        "30": "21.06",
        "31": "31.07",
        "tag_reference": "0DEB3B7AAADE42NS",
        "Total": "857.17"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "0",
        "5": "40",
        "6": "55.79",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "38.43",
        "11": "0",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "0",
        "18": "38.67",
        "19": "34.71",
        "20": "0",
        "21": "40",
        "22": "33.86",
        "23": "0",
        "24": "40",
        "25": "40",
        "26": "29.28",
        "27": "40",
        "28": "35.95",
        "29": "0",
        "30": "40",
        "31": "0",
        "tag_reference": "18A3901BC87541NS",
        "Total": "786.69"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "39",
        "10": "35",
        "11": "40",
        "12": "40",
        "13": "32.68",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "13754B1137D54BNS",
        "Total": "906.68"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "38.22",
        "13": "33.96",
        "14": "34.88",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "28.69",
        "20": "37.74",
        "21": "38.91",
        "22": "0",
        "23": "40",
        "24": "35.21",
        "25": "26.36",
        "26": "29.63",
        "27": "25.11",
        "28": "21.52",
        "29": "28.38",
        "30": "23.85",
        "31": "26.88",
        "tag_reference": "1C6EF386CB3040NS",
        "Total": "1029.34"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "36.8",
        "8": "29.78",
        "9": "0",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "40",
        "18": "40",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1C57613587E84CNS",
        "Total": "586.58"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "34.01",
        "31": "0",
        "tag_reference": "4B70964A9A6541NS",
        "Total": "1154.01"
    },
    {
        "1": "36.65",
        "2": "34.2",
        "3": "0",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "37.34",
        "8": "32.37",
        "9": "28.25",
        "10": "28.08",
        "11": "0",
        "12": "40",
        "13": "40",
        "14": "36.23",
        "15": "25.03",
        "16": "37.45",
        "17": "0",
        "18": "27.83",
        "19": "0",
        "20": "40",
        "21": "40.07",
        "22": "31.06",
        "23": "26.43",
        "24": "27.23",
        "25": "24.11",
        "26": "0",
        "27": "40",
        "28": "40",
        "29": "35.29",
        "30": "27.01",
        "31": "0",
        "tag_reference": "45764B25D79F41NS",
        "Total": "854.63"
    },
    {
        "1": "34.47",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "40",
        "8": "0",
        "9": "38.39",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "37.1",
        "19": "27.07",
        "20": "37.63",
        "21": "0",
        "22": "0",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "29.14",
        "27": "32.05",
        "28": "40",
        "29": "0",
        "30": "40",
        "31": "40",
        "tag_reference": "57F4536C5EBF4CNS",
        "Total": "715.85"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "0",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "5A349B01A1B048NS",
        "Total": "720"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "33.79",
        "12": "0",
        "13": "40",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "0",
        "19": "0",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "0",
        "tag_reference": "568FA1C7EC7747NS",
        "Total": "913.79"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "0",
        "28": "40",
        "29": "0",
        "30": "40",
        "31": "0",
        "tag_reference": "570A2D893F4145NS",
        "Total": "200"
    },
    {
        "1": "0",
        "2": "0",
        "3": "40",
        "4": "0",
        "5": "0",
        "6": "2.33",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "4CF6AD35AA654BNS",
        "Total": "42.33"
    },
    {
        "1": "40",
        "2": "40",
        "3": "39.98",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "34.81",
        "15": "0",
        "16": "40",
        "17": "38.06",
        "18": "34.99",
        "19": "36.71",
        "20": "40",
        "21": "38.43",
        "22": "0",
        "23": "35.75",
        "24": "40",
        "25": "35.78",
        "26": "36.49",
        "27": "36.32",
        "28": "40",
        "29": "38.54",
        "30": "39.83",
        "31": "40",
        "tag_reference": "BB9490A1ED9A4FNS",
        "Total": "1085.69"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "40",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "0",
        "tag_reference": "B99DB25A72504DNS",
        "Total": "760"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "68.5",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "33.35",
        "16": "0",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35.08",
        "29": "35",
        "30": "35.06",
        "31": "35",
        "tag_reference": "C666F62237004CNS",
        "Total": "1101.99"
    },
    {
        "1": "0",
        "2": "0",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "40",
        "9": "0",
        "10": "40",
        "11": "40",
        "12": "34.55",
        "13": "40",
        "14": "36.01",
        "15": "29.04",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "37.56",
        "20": "38.37",
        "21": "37.06",
        "22": "0",
        "23": "0",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "36.42",
        "28": "0",
        "29": "38.63",
        "30": "0",
        "31": "40",
        "tag_reference": "D3EE3FF3BFB04DNS",
        "Total": "767.64"
    },
    {
        "1": "40",
        "2": "40",
        "3": "24",
        "4": "0",
        "5": "40",
        "6": "0",
        "7": "40",
        "8": "0",
        "9": "35.82",
        "10": "31.41",
        "11": "0",
        "12": "40",
        "13": "32.29",
        "14": "0",
        "15": "30.02",
        "16": "0",
        "17": "30.04",
        "18": "0",
        "19": "0",
        "20": "40",
        "21": "0",
        "22": "35.08",
        "23": "0",
        "24": "37.04",
        "25": "0",
        "26": "34.64",
        "27": "0",
        "28": "29.54",
        "29": "32.7",
        "30": "0",
        "31": "0",
        "tag_reference": "CF8B1E10CAEF44NS",
        "Total": "592.58"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "63.94",
        "28": "34.51",
        "29": "39.41",
        "30": "40",
        "31": "40",
        "tag_reference": "E2F4C5CA435C49NS",
        "Total": "1097.86"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "E19CA7AFB63A45NS",
        "Total": "160"
    },
    {
        "1": "38.52",
        "2": "40",
        "3": "40",
        "4": "35.31",
        "5": "40",
        "6": "34.25",
        "7": "0",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "0",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "39.71",
        "21": "40",
        "22": "0",
        "23": "0",
        "24": "40",
        "25": "37.11",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "ECBE1B79CB2E47NS",
        "Total": "1064.9"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "0",
        "19": "40",
        "20": "40",
        "21": "0",
        "22": "40",
        "23": "0",
        "24": "40",
        "25": "0",
        "26": "40",
        "27": "0",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "E95CA631231545NS",
        "Total": "680"
    },
    {
        "1": "39.17",
        "2": "40",
        "3": "36.56",
        "4": "33.55",
        "5": "38.52",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "37.06",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "38.17",
        "17": "40",
        "18": "40",
        "19": "38",
        "20": "0",
        "21": "40",
        "22": "38.3",
        "23": "40",
        "24": "40",
        "25": "34.51",
        "26": "29.69",
        "27": "0",
        "28": "37.65",
        "29": "32.2",
        "30": "33.16",
        "31": "29.8",
        "tag_reference": "FFBAF48A664040NS",
        "Total": "1016.34"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "25.07",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "F3BA070B00A14BNS",
        "Total": "785.07"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "0",
        "20": "40",
        "21": "36.71",
        "22": "40",
        "23": "35",
        "24": "35",
        "25": "40",
        "26": "0",
        "27": "35",
        "28": "35",
        "29": "40",
        "30": "35.01",
        "31": "31.44",
        "tag_reference": "34CADB851DFD49NS",
        "Total": "803.16"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "0",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "0",
        "tag_reference": "A7C77D1ECC1540NS",
        "Total": "440"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "0",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "31.6",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "0",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "37.47",
        "29": "32.74",
        "30": "40",
        "31": "31.02",
        "tag_reference": "A393C5C550CB40NS",
        "Total": "1092.83"
    },
    {
        "1": "37.3",
        "2": "0",
        "3": "40",
        "4": "0",
        "5": "0",
        "6": "40",
        "7": "0",
        "8": "40",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "38.22",
        "17": "27.56",
        "18": "0",
        "19": "40",
        "20": "40",
        "21": "0",
        "22": "40",
        "23": "34.25",
        "24": "0",
        "25": "40",
        "26": "0",
        "27": "40",
        "28": "40",
        "29": "0",
        "30": "40",
        "31": "40",
        "tag_reference": "AB017B73E8E44DNS",
        "Total": "777.33"
    },
    {
        "1": "32.74",
        "2": "35.05",
        "3": "0",
        "4": "40",
        "5": "40",
        "6": "35.05",
        "7": "35.69",
        "8": "31.57",
        "9": "26.86",
        "10": "0",
        "11": "35.29",
        "12": "29.02",
        "13": "32.5",
        "14": "29.6",
        "15": "29.6",
        "16": "27.95",
        "17": "0",
        "18": "31.74",
        "19": "31.24",
        "20": "35.4",
        "21": "27.8",
        "22": "31.92",
        "23": "36.71",
        "24": "0",
        "25": "30.56",
        "26": "25.75",
        "27": "25.07",
        "28": "33.01",
        "29": "27.03",
        "30": "26.42",
        "31": "0",
        "tag_reference": "A8788867760D40NS",
        "Total": "823.57"
    },
    {
        "1": "40",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "0",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "36.38",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "39.52",
        "21": "40",
        "22": "35.01",
        "23": "35",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "AD3B3E87759743NS",
        "Total": "545.91"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "35.16",
        "24": "35.29",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "0",
        "30": "40",
        "31": "39.52",
        "tag_reference": "AB934F3FD1344CNS",
        "Total": "989.97"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "35.12",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "0",
        "9": "40",
        "10": "40.07",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "B6D8416DCCFE43NS",
        "Total": "1195.19"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "20",
        "9": "33.48",
        "10": "40",
        "11": "40",
        "12": "35",
        "13": "39.76",
        "14": "40",
        "15": "39.46",
        "16": "39.44",
        "17": "40",
        "18": "0",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "40",
        "27": "38.59",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "0",
        "tag_reference": "AEA6C086B99D44NS",
        "Total": "830.73"
    },
    {
        "1": "40",
        "2": "0",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "0",
        "10": "40",
        "11": "0",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "40",
        "18": "0",
        "19": "39.83",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "40",
        "29": "40",
        "30": "0",
        "31": "40",
        "tag_reference": "B981719876254FNS",
        "Total": "639.83"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40.09",
        "12": "26.57",
        "13": "32.57",
        "14": "0",
        "15": "40",
        "16": "40",
        "17": "34.88",
        "18": "40",
        "19": "31.3",
        "20": "32.74",
        "21": "25.46",
        "22": "25.79",
        "23": "35",
        "24": "40",
        "25": "35.01",
        "26": "23.22",
        "27": "25",
        "28": "30.08",
        "29": "40",
        "30": "27.01",
        "31": "23.04",
        "tag_reference": "B858816C0F7841NS",
        "Total": "727.76"
    },
    {
        "1": "0",
        "2": "40",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "40",
        "9": "0",
        "10": "40",
        "11": "40",
        "12": "0",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "0",
        "25": "0",
        "26": "40",
        "27": "40",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "0",
        "tag_reference": "9000B2CFFCA341NS",
        "Total": "680"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "42.38",
        "7": "39.39",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "38.96",
        "27": "40",
        "28": "40",
        "29": "0",
        "30": "40",
        "31": "0",
        "tag_reference": "8F1E61270B3A47NS",
        "Total": "960.73"
    },
    {
        "1": "40",
        "2": "0",
        "3": "40",
        "4": "40",
        "5": "37.43",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "0",
        "tag_reference": "929CC1E983174ENS",
        "Total": "917.43"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "39.33",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "0",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "0",
        "27": "39.4",
        "28": "40",
        "29": "40",
        "30": "39.83",
        "31": "40",
        "tag_reference": "911933F6579C48NS",
        "Total": "798.56"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "39.17",
        "27": "0",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "93991D37AEC742NS",
        "Total": "1079.17"
    },
    {
        "1": "40",
        "2": "0",
        "3": "0",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "32.02",
        "31": "36.04",
        "tag_reference": "938BE454EF834BNS",
        "Total": "1108.06"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "0",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "0",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "35",
        "23": "40",
        "24": "40",
        "25": "35",
        "26": "35",
        "27": "40",
        "28": "35.29",
        "29": "35.03",
        "30": "40",
        "31": "35",
        "tag_reference": "A05D42CE8BE64ANS",
        "Total": "770.32"
    },
    {
        "1": "40",
        "2": "40",
        "3": "0",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "0",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "0",
        "31": "40",
        "tag_reference": "9FE21550CA904BNS",
        "Total": "960"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "39.27",
        "9": "40",
        "10": "38.61",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "39.93",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "36.01",
        "24": "32.22",
        "25": "26.86",
        "26": "0",
        "27": "35.45",
        "28": "40",
        "29": "30.41",
        "30": "37.06",
        "31": "0",
        "tag_reference": "67B923B28E5347NS",
        "Total": "1075.82"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "37.41",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "63E5F2737DD04FNS",
        "Total": "1237.41"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "0",
        "13": "40",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "40",
        "25": "0",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "0",
        "30": "40",
        "31": "40",
        "tag_reference": "6E175C4FADAC44NS",
        "Total": "640"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "35",
        "11": "35.01",
        "12": "35",
        "13": "28.88",
        "14": "0",
        "15": "40",
        "16": "0",
        "17": "32.59",
        "18": "27.77",
        "19": "0",
        "20": "38.76",
        "21": "0",
        "22": "34.99",
        "23": "0",
        "24": "38.35",
        "25": "0",
        "26": "0",
        "27": "40",
        "28": "30.96",
        "29": "0",
        "30": "0",
        "31": "38.5",
        "tag_reference": "6AFCF9580BFF4FNS",
        "Total": "455.81"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "0",
        "5": "0",
        "6": "40",
        "7": "40",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "36.99",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "0",
        "19": "0",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "0",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "7D11E2264B984FNS",
        "Total": "956.99"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "0",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "0",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "29.74",
        "29": "0",
        "30": "40",
        "31": "40",
        "tag_reference": "70A4EAA997754ENS",
        "Total": "989.74"
    },
    {
        "1": "0",
        "2": "77.8",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "65.31",
        "7": "0",
        "8": "0",
        "9": "56.89",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "8616B77EF9CC48NS",
        "Total": "200"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "823CBB2367284ENS",
        "Total": "200"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "35.67",
        "8": "35.01",
        "9": "35.03",
        "10": "35",
        "11": "0",
        "12": "35.75",
        "13": "40",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "0",
        "18": "38.98",
        "19": "29.26",
        "20": "0",
        "21": "35",
        "22": "35",
        "23": "32.98",
        "24": "0",
        "25": "35",
        "26": "40",
        "27": "0",
        "28": "35",
        "29": "0",
        "30": "40",
        "31": "0",
        "tag_reference": "8CFC662D4E2448NS",
        "Total": "642.68"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "8983B0F336D049NS",
        "Total": "200"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "36.02",
        "22": "0",
        "23": "0",
        "24": "40",
        "25": "40",
        "26": "0",
        "27": "40",
        "28": "0",
        "29": "40",
        "30": "0",
        "31": "40",
        "tag_reference": "A115D26F73BB4DNS",
        "Total": "436.02"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "34.88",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "36.86",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "0",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "38.63",
        "30": "0",
        "31": "40",
        "tag_reference": "A0F46154F30F4DNS",
        "Total": "1110.37"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "40",
        "27": "0",
        "28": "40",
        "29": "40",
        "30": "0",
        "31": "40",
        "tag_reference": "60F768FBFC204FNS",
        "Total": "920"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "0",
        "9": "38.96",
        "10": "40",
        "11": "39.79",
        "12": "0",
        "13": "33.59",
        "14": "37.52",
        "15": "0",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "0",
        "22": "0",
        "23": "40",
        "24": "40",
        "25": "0",
        "26": "40",
        "27": "40",
        "28": "0",
        "29": "0",
        "30": "40",
        "31": "40",
        "tag_reference": "631F209BAD0F49NS",
        "Total": "709.86"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "0",
        "6": "40",
        "7": "0",
        "8": "40",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "0",
        "13": "40",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "40",
        "22": "40",
        "23": "32.9",
        "24": "40",
        "25": "33.09",
        "26": "0",
        "27": "40",
        "28": "38.83",
        "29": "40",
        "30": "35.49",
        "31": "40",
        "tag_reference": "5E989BFC65474DNS",
        "Total": "740.31"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "25A9719A59644DNS",
        "Total": "1200"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "0",
        "28": "35",
        "29": "35",
        "30": "35.01",
        "31": "35",
        "tag_reference": "1F0355EAC4034DNS",
        "Total": "715.01"
    },
    {
        "1": "39.68",
        "2": "25.81",
        "3": "35.34",
        "4": "40",
        "5": "0",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "34.12",
        "11": "31.44",
        "12": "0",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "40",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "30424CEDF0D643NS",
        "Total": "486.39"
    },
    {
        "1": "0",
        "2": "40",
        "3": "64.99",
        "4": "0",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "44.21",
        "14": "31.85",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "0",
        "27": "40",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "2FB2E3E33FD640NS",
        "Total": "981.05"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "40",
        "8": "0",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "40",
        "27": "0",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "30AD60AF0D5F4ENS",
        "Total": "880"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "30.17",
        "12": "31.09",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "36.67",
        "17": "0",
        "18": "40",
        "19": "37.37",
        "20": "29.34",
        "21": "32.9",
        "22": "0",
        "23": "40",
        "24": "40",
        "25": "28.32",
        "26": "28.58",
        "27": "30.26",
        "28": "31.11",
        "29": "29.08",
        "30": "34.97",
        "31": "0",
        "tag_reference": "4199C2BD201C49NS",
        "Total": "739.86"
    },
    {
        "1": "40",
        "2": "0",
        "3": "0",
        "4": "38.72",
        "5": "0",
        "6": "40",
        "7": "40",
        "8": "37.8",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "39.85",
        "17": "30",
        "18": "35.19",
        "19": "40",
        "20": "36.1",
        "21": "33.7",
        "22": "27.8",
        "23": "35.42",
        "24": "34.71",
        "25": "25.92",
        "26": "38.56",
        "27": "33.7",
        "28": "30.37",
        "29": "28.14",
        "30": "35.1",
        "31": "35.56",
        "tag_reference": "34C7F05C9E8F48NS",
        "Total": "936.64"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "65",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "54.02",
        "9": "0",
        "10": "0",
        "11": "70.68",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "76.66",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "64",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "72.57",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "85BDECAE6EF248NS",
        "Total": "402.93"
    },
    {
        "1": "0",
        "2": "0",
        "3": "82.16",
        "4": "0",
        "5": "0",
        "6": "54.73",
        "7": "0",
        "8": "71.62",
        "9": "0",
        "10": "45.9",
        "11": "0",
        "12": "0",
        "13": "63.07",
        "14": "0",
        "15": "46.29",
        "16": "0",
        "17": "0",
        "18": "64.48",
        "19": "0",
        "20": "0",
        "21": "72.09",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "83.17",
        "28": "0",
        "29": "0",
        "30": "50.26",
        "31": "0",
        "tag_reference": "C8BF5035BA834ENS",
        "Total": "633.77"
    },
    {
        "1": "0",
        "2": "51.58",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "62.39",
        "7": "24.09",
        "8": "0",
        "9": "50.3",
        "10": "0",
        "11": "0",
        "12": "40.59",
        "13": "0",
        "14": "42.12",
        "15": "0",
        "16": "46.43",
        "17": "30.64",
        "18": "0",
        "19": "41.48",
        "20": "0",
        "21": "39.47",
        "22": "0",
        "23": "33.79",
        "24": "0",
        "25": "0",
        "26": "48.28",
        "27": "20.62",
        "28": "0",
        "29": "37.62",
        "30": "0",
        "31": "54.19",
        "tag_reference": "D576FB8950304DNS",
        "Total": "623.59"
    },
    {
        "1": "24.56",
        "2": "22.26",
        "3": "21.75",
        "4": "0",
        "5": "54.27",
        "6": "18.71",
        "7": "18.85",
        "8": "0",
        "9": "51.18",
        "10": "26.16",
        "11": "0",
        "12": "31.62",
        "13": "23.86",
        "14": "29.01",
        "15": "18.01",
        "16": "30.2",
        "17": "33.42",
        "18": "0",
        "19": "29.45",
        "20": "17.68",
        "21": "17.15",
        "22": "13.77",
        "23": "24.63",
        "24": "16.4",
        "25": "0",
        "26": "23.87",
        "27": "18.79",
        "28": "25.54",
        "29": "19.53",
        "30": "16.22",
        "31": "20.86",
        "tag_reference": "DAC393D636614DNS",
        "Total": "647.75"
    },
    {
        "1": "63.25",
        "2": "50.28",
        "3": "0",
        "4": "62.77",
        "5": "0",
        "6": "0",
        "7": "63.31",
        "8": "0",
        "9": "0",
        "10": "23",
        "11": "0",
        "12": "60.24",
        "13": "52.59",
        "14": "0",
        "15": "43.79",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "60.88",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "60.84",
        "29": "0",
        "30": "0",
        "31": "62.22",
        "tag_reference": "1217023051226743",
        "Total": "603.17"
    },
    {
        "1": "0",
        "2": "0",
        "3": "66.89",
        "4": "0",
        "5": "0",
        "6": "59.41",
        "7": "0",
        "8": "44.65",
        "9": "0",
        "10": "51.69",
        "11": "0",
        "12": "0",
        "13": "55.52",
        "14": "0",
        "15": "61.28",
        "16": "0",
        "17": "51.72",
        "18": "0",
        "19": "0",
        "20": "57.8",
        "21": "0",
        "22": "55.44",
        "23": "53.47",
        "24": "0",
        "25": "0",
        "26": "55.99",
        "27": "0",
        "28": "0",
        "29": "76.07",
        "30": "0",
        "31": "0",
        "tag_reference": "AFC6C344CAD34ANS",
        "Total": "689.93"
    },
    {
        "1": "0",
        "2": "0",
        "3": "78.96",
        "4": "0",
        "5": "0",
        "6": "61.13",
        "7": "0",
        "8": "0",
        "9": "60.42",
        "10": "54.95",
        "11": "0",
        "12": "0",
        "13": "38.95",
        "14": "0",
        "15": "52.26",
        "16": "0",
        "17": "0",
        "18": "68.56",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "69.3",
        "24": "0",
        "25": "0",
        "26": "67.4",
        "27": "0",
        "28": "0",
        "29": "63.92",
        "30": "0",
        "31": "0",
        "tag_reference": "51F666759E7441NS",
        "Total": "615.85"
    },
    {
        "1": "0",
        "2": "0",
        "3": "68.99",
        "4": "0",
        "5": "0",
        "6": "66.2",
        "7": "66.11",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "66.62",
        "12": "60.34",
        "13": "0",
        "14": "72.93",
        "15": "0",
        "16": "28.72",
        "17": "73.82",
        "18": "59.76",
        "19": "0",
        "20": "0",
        "21": "76.7",
        "22": "0",
        "23": "72.14",
        "24": "0",
        "25": "0",
        "26": "74.64",
        "27": "0",
        "28": "63.4",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "E75F2BCCCF2C43NS",
        "Total": "850.37"
    },
    {
        "1": "56.42",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "79.4",
        "6": "0",
        "7": "0",
        "8": "72.47",
        "9": "0",
        "10": "59.37",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "60.64",
        "15": "0",
        "16": "0",
        "17": "80.56",
        "18": "0",
        "19": "0",
        "20": "63.02",
        "21": "0",
        "22": "0",
        "23": "49.76",
        "24": "0",
        "25": "0",
        "26": "69.95",
        "27": "0",
        "28": "34.83",
        "29": "0",
        "30": "0",
        "31": "92.64",
        "tag_reference": "04E4E9A4EFA544NS",
        "Total": "719.06"
    },
    {
        "1": "78.26",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "87.08",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "79.6",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "78.07",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "80.02",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "77.45",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "74",
        "tag_reference": "7D7728F3B5C545NS",
        "Total": "554.48"
    },
    {
        "1": "87.69",
        "2": "0",
        "3": "70.79",
        "4": "0",
        "5": "0",
        "6": "56.12",
        "7": "0",
        "8": "73.02",
        "9": "0",
        "10": "63.49",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "77.96",
        "15": "0",
        "16": "0",
        "17": "75",
        "18": "0",
        "19": "0",
        "20": "80.06",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "83.94",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "80.12",
        "29": "0",
        "30": "1.81",
        "31": "0",
        "tag_reference": "F90A0D78B96548NS",
        "Total": "750"
    },
    {
        "1": "0",
        "2": "51.81",
        "3": "0",
        "4": "61.87",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "70",
        "9": "0",
        "10": "0",
        "11": "49.2",
        "12": "40.01",
        "13": "0",
        "14": "0",
        "15": "44.03",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "73.73",
        "20": "0",
        "21": "0",
        "22": "60.02",
        "23": "0",
        "24": "0",
        "25": "50.03",
        "26": "0",
        "27": "0",
        "28": "45.01",
        "29": "0",
        "30": "0",
        "31": "67.49",
        "tag_reference": "9323A09BF66543NS",
        "Total": "613.2"
    },
    {
        "1": "79.88",
        "2": "0",
        "3": "81.43",
        "4": "0",
        "5": "0",
        "6": "63.61",
        "7": "0",
        "8": "0",
        "9": "78.44",
        "10": "0",
        "11": "0",
        "12": "73.83",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "69.95",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "76.07",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "75.01",
        "27": "0",
        "28": "0",
        "29": "71.6",
        "30": "0",
        "31": "80.18",
        "tag_reference": "033F06887D1343NS",
        "Total": "750"
    },
    {
        "1": "46.41",
        "2": "36.83",
        "3": "33.14",
        "4": "0",
        "5": "51.74",
        "6": "35.75",
        "7": "36.55",
        "8": "25.6",
        "9": "27.83",
        "10": "34.99",
        "11": "0",
        "12": "38.23",
        "13": "29.68",
        "14": "33.64",
        "15": "32.43",
        "16": "36.73",
        "17": "26.02",
        "18": "0",
        "19": "31.95",
        "20": "35.97",
        "21": "31.25",
        "22": "39.96",
        "23": "0",
        "24": "49.07",
        "25": "0",
        "26": "42.77",
        "27": "0",
        "28": "49.57",
        "29": "0",
        "30": "23",
        "31": "0",
        "tag_reference": "1217023051254746",
        "Total": "829.11"
    },
    {
        "1": "0",
        "2": "0",
        "3": "85.91",
        "4": "0",
        "5": "62.6",
        "6": "0",
        "7": "0",
        "8": "62.47",
        "9": "0",
        "10": "0",
        "11": "86.36",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "87.29",
        "16": "0",
        "17": "0",
        "18": "87",
        "19": "0",
        "20": "0",
        "21": "77.78",
        "22": "0",
        "23": "0",
        "24": "74.01",
        "25": "0",
        "26": "0",
        "27": "75.18",
        "28": "0",
        "29": "51.5",
        "30": "0",
        "31": "0",
        "tag_reference": "1769281265A843NS",
        "Total": "750.1"
    },
    {
        "1": "0",
        "2": "51.46",
        "3": "0",
        "4": "0",
        "5": "86.84",
        "6": "0",
        "7": "66.16",
        "8": "0",
        "9": "73.24",
        "10": "0",
        "11": "0",
        "12": "71.48",
        "13": "0",
        "14": "0",
        "15": "73.27",
        "16": "57.82",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "74.83",
        "21": "0",
        "22": "80.01",
        "23": "0",
        "24": "67.54",
        "25": "0",
        "26": "62.69",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "EB2C14D6FDB74BNS",
        "Total": "765.34"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "83.25",
        "5": "0",
        "6": "44.57",
        "7": "0",
        "8": "0",
        "9": "63.58",
        "10": "0",
        "11": "0",
        "12": "67.3",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "62.92",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "81.78",
        "29": "0",
        "30": "0",
        "31": "68.59",
        "tag_reference": "62BFDD49A2C941NS",
        "Total": "471.99"
    },
    {
        "1": "64.37",
        "2": "0",
        "3": "71.58",
        "4": "0",
        "5": "0",
        "6": "47.06",
        "7": "0",
        "8": "58.12",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "61.26",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "61.33",
        "17": "0",
        "18": "0",
        "19": "56.65",
        "20": "0",
        "21": "0",
        "22": "65.09",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "68.8",
        "27": "0",
        "28": "0",
        "29": "61.67",
        "30": "0",
        "31": "42.62",
        "tag_reference": "D1A8B20F2F7F43NS",
        "Total": "658.55"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "40",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "0",
        "12": "34.77",
        "13": "0",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "0",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "35",
        "23": "35",
        "24": "0",
        "25": "40",
        "26": "40",
        "27": "38",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "34.05",
        "tag_reference": "97C4B20B85BD45NS",
        "Total": "656.82"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "39.13",
        "10": "40",
        "11": "21.8",
        "12": "40",
        "13": "25.92",
        "14": "0",
        "15": "37.35",
        "16": "23.52",
        "17": "24.71",
        "18": "27.78",
        "19": "25.71",
        "20": "24.46",
        "21": "0",
        "22": "33.09",
        "23": "26.02",
        "24": "33.25",
        "25": "35",
        "26": "21.7",
        "27": "28.27",
        "28": "26.86",
        "29": "26.3",
        "30": "24.41",
        "31": "25.91",
        "tag_reference": "680C3F6BE2D34DNS",
        "Total": "611.19"
    },
    {
        "1": "40",
        "2": "0",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "0",
        "25": "40",
        "26": "40",
        "27": "0",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "0",
        "tag_reference": "5909789960CA4DNS",
        "Total": "960"
    },
    {
        "1": "40",
        "2": "0",
        "3": "21.8",
        "4": "40",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "40",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "0",
        "16": "0",
        "17": "40",
        "18": "0",
        "19": "40",
        "20": "0",
        "21": "0",
        "22": "40",
        "23": "0",
        "24": "40",
        "25": "0",
        "26": "40",
        "27": "0",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "0",
        "tag_reference": "5A0509BECA5C45NS",
        "Total": "501.8"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "0",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "40",
        "24": "0",
        "25": "0",
        "26": "40",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "0",
        "31": "40",
        "tag_reference": "3390EC8456A245NS",
        "Total": "1040"
    },
    {
        "1": "0",
        "2": "40",
        "3": "40",
        "4": "0",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "0",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "0",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "0",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "0",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "25D095440EBD4CNS",
        "Total": "1000"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "35",
        "10": "40",
        "11": "21.8",
        "12": "40",
        "13": "35.01",
        "14": "0",
        "15": "40",
        "16": "29.93",
        "17": "0",
        "18": "29.95",
        "19": "39.63",
        "20": "35.64",
        "21": "35.01",
        "22": "27.23",
        "23": "23.81",
        "24": "29.5",
        "25": "28.01",
        "26": "27.93",
        "27": "25.66",
        "28": "33.68",
        "29": "27.6",
        "30": "22.48",
        "31": "25.7",
        "tag_reference": "8DB4BB69209A46NS",
        "Total": "653.57"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "0",
        "7": "40",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "35",
        "24": "35",
        "25": "34.78",
        "26": "35.06",
        "27": "34.65",
        "28": "39.52",
        "29": "27.82",
        "30": "35",
        "31": "35",
        "tag_reference": "3906CE65D7CD41NS",
        "Total": "1071.83"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "0",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "31.68",
        "10": "26.4",
        "11": "21.8",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "0",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "38.76",
        "24": "0",
        "25": "40",
        "26": "0",
        "27": "40",
        "28": "40",
        "29": "39.92",
        "30": "0",
        "31": "40",
        "tag_reference": "8C690EE06E084ANS",
        "Total": "958.56"
    },
    {
        "1": "120.5",
        "2": "0",
        "3": "112",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "224.3",
        "28": "158.71",
        "29": "0",
        "30": "0.85",
        "31": "0",
        "tag_reference": "1217023051226709",
        "Total": "616.36"
    },
    {
        "1": "0",
        "2": "0",
        "3": "110.93",
        "4": "0",
        "5": "0",
        "6": "43.73",
        "7": "100.66",
        "8": "0",
        "9": "0",
        "10": "119.82",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226739",
        "Total": "375.14"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "59.24",
        "17": "0",
        "18": "0",
        "19": "119.28",
        "20": "0",
        "21": "104.81",
        "22": "0",
        "23": "116.9",
        "24": "0",
        "25": "0",
        "26": "98.79",
        "27": "0",
        "28": "101.06",
        "29": "0",
        "30": "0",
        "31": "142.92",
        "tag_reference": "1217023051226789",
        "Total": "743"
    },
    {
        "1": "45.47",
        "2": "0",
        "3": "17.4",
        "4": "30",
        "5": "0",
        "6": "0",
        "7": "30",
        "8": "18.21",
        "9": "30",
        "10": "30.58",
        "11": "0",
        "12": "30",
        "13": "30",
        "14": "0",
        "15": "0",
        "16": "30",
        "17": "41.25",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051254732",
        "Total": "332.91"
    },
    {
        "1": "25",
        "2": "0",
        "3": "25",
        "4": "0",
        "5": "25",
        "6": "25",
        "7": "25",
        "8": "25",
        "9": "50",
        "10": "25",
        "11": "0",
        "12": "0",
        "13": "25",
        "14": "50",
        "15": "0",
        "16": "50",
        "17": "50.09",
        "18": "0",
        "19": "0",
        "20": "49.5",
        "21": "0",
        "22": "50.25",
        "23": "0",
        "24": "0",
        "25": "49.97",
        "26": "0",
        "27": "0",
        "28": "50.41",
        "29": "0",
        "30": "106.37",
        "31": "36.84",
        "tag_reference": "1217023051226738",
        "Total": "743.43"
    },
    {
        "1": "0",
        "2": "76.12",
        "3": "0",
        "4": "0",
        "5": "88.43",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "69.87",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "77.04",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "83.27",
        "18": "0",
        "19": "51.72",
        "20": "0",
        "21": "0",
        "22": "74.23",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "87.15",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "87.49",
        "tag_reference": "1217023051186849",
        "Total": "695.32"
    },
    {
        "1": "90.1",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "96.99",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "92.57",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "97.66",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "108.48",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "101.73",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "95",
        "31": "0",
        "tag_reference": "1217023051254743",
        "Total": "682.53"
    },
    {
        "1": "0",
        "2": "0",
        "3": "107.65",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "115.86",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "107.57",
        "14": "100.08",
        "15": "0",
        "16": "0",
        "17": "47.09",
        "18": "0",
        "19": "78.18",
        "20": "0",
        "21": "68.99",
        "22": "0.03",
        "23": "24.55",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "100",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051320643",
        "Total": "750"
    },
    {
        "1": "75.95",
        "2": "0",
        "3": "0",
        "4": "83.62",
        "5": "0",
        "6": "92.23",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "86.79",
        "25": "0",
        "26": "0",
        "27": "80.67",
        "28": "0",
        "29": "81.92",
        "30": "0",
        "31": "72.4",
        "tag_reference": "1217023051254742",
        "Total": "573.58"
    },
    {
        "1": "0",
        "2": "97.38",
        "3": "0",
        "4": "0",
        "5": "117.06",
        "6": "0",
        "7": "0",
        "8": "117.88",
        "9": "0",
        "10": "73.18",
        "11": "0",
        "12": "75.57",
        "13": "0",
        "14": "0",
        "15": "88.11",
        "16": "80.82",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "84.5",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "15.5",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226729",
        "Total": "750"
    },
    {
        "1": "25.03",
        "2": "25.01",
        "3": "0",
        "4": "0",
        "5": "49.41",
        "6": "25",
        "7": "24.53",
        "8": "25",
        "9": "20.88",
        "10": "0",
        "11": "50",
        "12": "25",
        "13": "20",
        "14": "25",
        "15": "0",
        "16": "25",
        "17": "25",
        "18": "20",
        "19": "30",
        "20": "40.05",
        "21": "25",
        "22": "22.9",
        "23": "23.95",
        "24": "0",
        "25": "25",
        "26": "25",
        "27": "50",
        "28": "0",
        "29": "123.24",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051254739",
        "Total": "750"
    },
    {
        "1": "91.1",
        "2": "0",
        "3": "0",
        "4": "97.94",
        "5": "0",
        "6": "0",
        "7": "98.23",
        "8": "0",
        "9": "0",
        "10": "84.94",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "112.83",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051254744",
        "Total": "485.04"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "100.06",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226723",
        "Total": "100.06"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "49.57",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "76.79",
        "28": "0",
        "29": "0",
        "30": "74.73",
        "31": "0",
        "tag_reference": "1217023051226741",
        "Total": "201.09"
    },
    {
        "1": "103.52",
        "2": "0",
        "3": "67.08",
        "4": "0",
        "5": "107.62",
        "6": "0",
        "7": "0",
        "8": "103.76",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "99.42",
        "13": "0",
        "14": "87.05",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "91.29",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226722",
        "Total": "659.74"
    },
    {
        "1": "0",
        "2": "0",
        "3": "25",
        "4": "30.01",
        "5": "15.05",
        "6": "50",
        "7": "25.37",
        "8": "0",
        "9": "25.54",
        "10": "50.76",
        "11": "0",
        "12": "44.02",
        "13": "0",
        "14": "25",
        "15": "25",
        "16": "52.16",
        "17": "40",
        "18": "25",
        "19": "26.44",
        "20": "25.8",
        "21": "0",
        "22": "25",
        "23": "50.59",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "25",
        "28": "0",
        "29": "0",
        "30": "130.63",
        "31": "31.47",
        "tag_reference": "1217023051186822",
        "Total": "747.84"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "106.01",
        "18": "43.52",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226740",
        "Total": "149.53"
    },
    {
        "1": "79.52",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "117.17",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "109.72",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "105.82",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "122.29",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "112.65",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "99.94",
        "30": "2.89",
        "31": "0",
        "tag_reference": "1217023051226778",
        "Total": "750"
    },
    {
        "1": "0",
        "2": "41.42",
        "3": "0",
        "4": "50.87",
        "5": "62.49",
        "6": "32.39",
        "7": "34.02",
        "8": "31.62",
        "9": "19.85",
        "10": "0",
        "11": "65.17",
        "12": "79.95",
        "13": "17.4",
        "14": "0",
        "15": "50.01",
        "16": "0",
        "17": "45.82",
        "18": "0",
        "19": "0",
        "20": "84.66",
        "21": "30.16",
        "22": "0",
        "23": "0",
        "24": "65.25",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "38.92",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051254748",
        "Total": "750"
    },
    {
        "1": "0",
        "2": "0",
        "3": "68.13",
        "4": "32.43",
        "5": "0",
        "6": "0",
        "7": "45.4",
        "8": "0",
        "9": "0",
        "10": "64.2",
        "11": "0",
        "12": "0",
        "13": "63.63",
        "14": "0",
        "15": "52",
        "16": "0",
        "17": "59.33",
        "18": "0",
        "19": "52.52",
        "20": "0",
        "21": "55.12",
        "22": "0",
        "23": "0",
        "24": "72.88",
        "25": "0",
        "26": "0",
        "27": "41.63",
        "28": "0",
        "29": "47.47",
        "30": "0",
        "31": "76.03",
        "tag_reference": "1217023051397030",
        "Total": "730.77"
    },
    {
        "1": "79.64",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "114",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "111.07",
        "10": "0",
        "11": "77.95",
        "12": "0",
        "13": "0",
        "14": "0.15",
        "15": "105.04",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "96.11",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "85",
        "tag_reference": "1217023051494493",
        "Total": "668.96"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186808",
        "Total": "1085"
    },
    {
        "1": "40",
        "2": "24.22",
        "3": "43.73",
        "4": "41.83",
        "5": "53.12",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "42.73",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "0",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "1217023051186832",
        "Total": "1205.63"
    },
    {
        "1": "49.16",
        "2": "0",
        "3": "84.54",
        "4": "0",
        "5": "0",
        "6": "79.96",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051186821",
        "Total": "213.66"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "38.45",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "61.36",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "38.13",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "1217023051186814",
        "Total": "1257.94"
    },
    {
        "1": "45.14",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "56.8",
        "14": "35",
        "15": "34.03",
        "16": "35",
        "17": "35",
        "18": "34.44",
        "19": "35",
        "20": "34.64",
        "21": "35",
        "22": "35",
        "23": "27.97",
        "24": "33.81",
        "25": "28.06",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "34.36",
        "31": "35",
        "tag_reference": "1217023051186810",
        "Total": "1099.25"
    },
    {
        "1": "79.25",
        "2": "0",
        "3": "67.15",
        "4": "0",
        "5": "0",
        "6": "62.4",
        "7": "0",
        "8": "51.23",
        "9": "0",
        "10": "0",
        "11": "66.9",
        "12": "0",
        "13": "17.25",
        "14": "0",
        "15": "0",
        "16": "56.95",
        "17": "0",
        "18": "61.01",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "44.76",
        "24": "61",
        "25": "0",
        "26": "0",
        "27": "65.94",
        "28": "0",
        "29": "0",
        "30": "62.94",
        "31": "0",
        "tag_reference": "1217023051429500",
        "Total": "696.78"
    },
    {
        "1": "69.7",
        "2": "0",
        "3": "62",
        "4": "0",
        "5": "0",
        "6": "68.31",
        "7": "0",
        "8": "0",
        "9": "64.06",
        "10": "0",
        "11": "0",
        "12": "51.99",
        "13": "0",
        "14": "0",
        "15": "55.86",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "62.76",
        "20": "0",
        "21": "0",
        "22": "54.79",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "51.46",
        "27": "0",
        "28": "46.86",
        "29": "0",
        "30": "0",
        "31": "63.78",
        "tag_reference": "1217023051254745",
        "Total": "651.57"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "82.39",
        "15": "36.73",
        "16": "31.26",
        "17": "0",
        "18": "0",
        "19": "55.89",
        "20": "0",
        "21": "58.13",
        "22": "34.05",
        "23": "0",
        "24": "43.07",
        "25": "0",
        "26": "0",
        "27": "100.35",
        "28": "35.89",
        "29": "0",
        "30": "50.65",
        "31": "37.66",
        "tag_reference": "1217023051226763",
        "Total": "566.07"
    },
    {
        "1": "78.11",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "76.44",
        "7": "0",
        "8": "0",
        "9": "75.24",
        "10": "0",
        "11": "75.44",
        "12": "0",
        "13": "0",
        "14": "74.97",
        "15": "0",
        "16": "0",
        "17": "73.01",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "66.27",
        "23": "0",
        "24": "0",
        "25": "63.49",
        "26": "0",
        "27": "0",
        "28": "57.94",
        "29": "0",
        "30": "59.65",
        "31": "0",
        "tag_reference": "1217023051254737",
        "Total": "700.56"
    },
    {
        "1": "0",
        "2": "0",
        "3": "73.51",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "77.06",
        "8": "0",
        "9": "0",
        "10": "69.71",
        "11": "0",
        "12": "0",
        "13": "17.25",
        "14": "73",
        "15": "0",
        "16": "0",
        "17": "80.96",
        "18": "0",
        "19": "0",
        "20": "82.46",
        "21": "0",
        "22": "0",
        "23": "75.56",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "83.51",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "73.62",
        "tag_reference": "1217023051423834",
        "Total": "706.64"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "73.44",
        "22": "0",
        "23": "46.47",
        "24": "0",
        "25": "0",
        "26": "61.2",
        "27": "35.86",
        "28": "0",
        "29": "33.55",
        "30": "46.21",
        "31": "20.93",
        "tag_reference": "1217023051226731",
        "Total": "317.66"
    },
    {
        "1": "72.3",
        "2": "0",
        "3": "69.64",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "66.31",
        "8": "0",
        "9": "68.17",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "17.25",
        "14": "73.31",
        "15": "0",
        "16": "0",
        "17": "69.52",
        "18": "0",
        "19": "0",
        "20": "56.87",
        "21": "0",
        "22": "0",
        "23": "84.85",
        "24": "0",
        "25": "0",
        "26": "53.31",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "65.04",
        "31": "0",
        "tag_reference": "1217023051226742",
        "Total": "696.57"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "72.35",
        "15": "55.33",
        "16": "0",
        "17": "51.81",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "71.81",
        "22": "0",
        "23": "0",
        "24": "69.52",
        "25": "0",
        "26": "63.82",
        "27": "60.25",
        "28": "0",
        "29": "0",
        "30": "44.27",
        "31": "71.08",
        "tag_reference": "1217023051226733",
        "Total": "560.24"
    },
    {
        "1": "69.33",
        "2": "44.59",
        "3": "36.47",
        "4": "0",
        "5": "55.49",
        "6": "0",
        "7": "56.3",
        "8": "0",
        "9": "57.41",
        "10": "0",
        "11": "0",
        "12": "50.61",
        "13": "0",
        "14": "50.34",
        "15": "0",
        "16": "0",
        "17": "65.08",
        "18": "0",
        "19": "0",
        "20": "38.07",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226775",
        "Total": "523.69"
    },
    {
        "1": "0",
        "2": "72.05",
        "3": "0",
        "4": "0",
        "5": "46.25",
        "6": "0",
        "7": "0",
        "8": "63.05",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "79.05",
        "14": "21.65",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "60.48",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "74.74",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "65",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "74.7",
        "tag_reference": "1217023051254731",
        "Total": "556.97"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "74.21",
        "22": "0",
        "23": "0",
        "24": "76.64",
        "25": "0",
        "26": "0",
        "27": "67.98",
        "28": "0",
        "29": "71.67",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051254733",
        "Total": "290.5"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "71.52",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "92.23",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "82.67",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226790",
        "Total": "246.42"
    },
    {
        "1": "35",
        "2": "35",
        "3": "0",
        "4": "25.16",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "26.31",
        "12": "35",
        "13": "32.7",
        "14": "35",
        "15": "35",
        "16": "32.46",
        "17": "34.92",
        "18": "33.46",
        "19": "35",
        "20": "0",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "33.96",
        "28": "31.63",
        "29": "20.43",
        "30": "17.29",
        "31": "35",
        "tag_reference": "1217023051226752",
        "Total": "953.32"
    },
    {
        "1": "0",
        "2": "0",
        "3": "35",
        "4": "35",
        "5": "26.68",
        "6": "31.65",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "35",
        "12": "35",
        "13": "0",
        "14": "0",
        "15": "35",
        "16": "21.32",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "35",
        "21": "35",
        "22": "0",
        "23": "23.04",
        "24": "0",
        "25": "0",
        "26": "35",
        "27": "35",
        "28": "0",
        "29": "0",
        "30": "35",
        "31": "0",
        "tag_reference": "1217023051226791",
        "Total": "452.69"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "34.81",
        "7": "28.86",
        "8": "35",
        "9": "21.15",
        "10": "28.08",
        "11": "35",
        "12": "34.01",
        "13": "33.81",
        "14": "35",
        "15": "34.79",
        "16": "35",
        "17": "34.99",
        "18": "35",
        "19": "35",
        "20": "34.29",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "34.62",
        "25": "35",
        "26": "35",
        "27": "35.1",
        "28": "34.9",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226765",
        "Total": "1054.41"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "0",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "0",
        "13": "0",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "0",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "31.37",
        "25": "0",
        "26": "0",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226764",
        "Total": "871.37"
    },
    {
        "1": "34.66",
        "2": "35",
        "3": "35",
        "4": "0",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "0",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "34.2",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "32.7",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "31.07",
        "31": "28.95",
        "tag_reference": "1217023051226713",
        "Total": "1001.58"
    },
    {
        "1": "25.07",
        "2": "0",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "34.36",
        "13": "33.2",
        "14": "34.29",
        "15": "21.84",
        "16": "30.28",
        "17": "31.02",
        "18": "26.01",
        "19": "28.82",
        "20": "30.87",
        "21": "35",
        "22": "21.43",
        "23": "30.35",
        "24": "0",
        "25": "35",
        "26": "32.7",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "31.24",
        "31": "35",
        "tag_reference": "1217023051226780",
        "Total": "936.48"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226710",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "0",
        "tag_reference": "1217023051226768",
        "Total": "1050"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "33.62",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "32.7",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226712",
        "Total": "1081.32"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "34.16",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "34.77",
        "13": "32.7",
        "14": "33.11",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "32.9",
        "25": "35",
        "26": "34.75",
        "27": "35",
        "28": "33.33",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226788",
        "Total": "1075.72"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "27.99",
        "26": "32.48",
        "27": "31.92",
        "28": "34.44",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226774",
        "Total": "406.83"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "0",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "33.07",
        "21": "27.27",
        "22": "29.6",
        "23": "35",
        "24": "26.77",
        "25": "35.29",
        "26": "24.11",
        "27": "24.63",
        "28": "25.33",
        "29": "31.37",
        "30": "25.09",
        "31": "26.53",
        "tag_reference": "1217023051226714",
        "Total": "974.06"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "20.01",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "33.22",
        "tag_reference": "1217023051226748",
        "Total": "1068.23"
    },
    {
        "1": "35.16",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "32.29",
        "19": "34.55",
        "20": "35",
        "21": "35",
        "22": "34.38",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35.12",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226711",
        "Total": "1081.5"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "34.1",
        "5": "22.41",
        "6": "35",
        "7": "31.13",
        "8": "33.57",
        "9": "32.92",
        "10": "29.41",
        "11": "23.06",
        "12": "28.12",
        "13": "35",
        "14": "35",
        "15": "26.86",
        "16": "33.1",
        "17": "0",
        "18": "27.75",
        "19": "32.24",
        "20": "35",
        "21": "35",
        "22": "30.02",
        "23": "32",
        "24": "0",
        "25": "32.29",
        "26": "30.54",
        "27": "20.01",
        "28": "32.72",
        "29": "35",
        "30": "34.84",
        "31": "20.71",
        "tag_reference": "1217023051226756",
        "Total": "902.8"
    },
    {
        "1": "35",
        "2": "35",
        "3": "32.7",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "17.96",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "32.7",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "33.79",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226721",
        "Total": "1062.15"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "34.55",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35.06",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226737",
        "Total": "1084.61"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "34.81",
        "21": "35",
        "22": "34.49",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "0",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226779",
        "Total": "1049.3"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "34.16",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "0",
        "23": "35",
        "24": "35",
        "25": "34.99",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226785",
        "Total": "1049.15"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226725",
        "Total": "875"
    },
    {
        "1": "35",
        "2": "34.92",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226782",
        "Total": "1084.92"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "0",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "0",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "0",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226792",
        "Total": "980"
    },
    {
        "1": "35",
        "2": "35",
        "3": "31",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "34.38",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "30.63",
        "23": "33.16",
        "24": "35",
        "25": "35",
        "26": "34.18",
        "27": "35",
        "28": "0",
        "29": "34.4",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226706",
        "Total": "862.75"
    },
    {
        "1": "35",
        "2": "34.14",
        "3": "34.14",
        "4": "29.26",
        "5": "34.4",
        "6": "34.16",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "32.7",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "34.57",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226783",
        "Total": "1073.37"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "33.68",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "33.77",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226707",
        "Total": "1082.45"
    },
    {
        "1": "35",
        "2": "32.7",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "33.42",
        "7": "30.96",
        "8": "34.05",
        "9": "34.95",
        "10": "28.1",
        "11": "31.13",
        "12": "32.59",
        "13": "32.7",
        "14": "35",
        "15": "33.59",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "32.2",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051226771",
        "Total": "1056.39"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "0",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186864",
        "Total": "1050"
    },
    {
        "1": "40",
        "2": "40",
        "3": "39.07",
        "4": "38.72",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "35.69",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "32.39",
        "23": "40",
        "24": "38.84",
        "25": "27.88",
        "26": "35.56",
        "27": "40",
        "28": "40",
        "29": "40",
        "30": "32.16",
        "31": "32.74",
        "tag_reference": "1217023051186863",
        "Total": "1153.05"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186838",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "34.99",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "34.6",
        "23": "0",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "0",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186870",
        "Total": "1014.59"
    },
    {
        "1": "30.19",
        "2": "35",
        "3": "35",
        "4": "0",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "56.8",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "34.66",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "34.25",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186874",
        "Total": "1065.9"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "56.8",
        "5": "56.8",
        "6": "35",
        "7": "35",
        "8": "0",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "78.6",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "0",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186856",
        "Total": "1102.2"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "34.03",
        "9": "35",
        "10": "33.07",
        "11": "30",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "33.62",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "0",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "0",
        "30": "0",
        "31": "35",
        "tag_reference": "1217023051186843",
        "Total": "970.72"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "34.86",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186867",
        "Total": "979.86"
    },
    {
        "1": "56.8",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "39.52",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186878",
        "Total": "1111.32"
    },
    {
        "1": "32.94",
        "2": "35",
        "3": "35",
        "4": "30.76",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "32.86",
        "10": "33.35",
        "11": "35",
        "12": "34.86",
        "13": "39.81",
        "14": "19.08",
        "15": "35",
        "16": "31.32",
        "17": "35",
        "18": "23.76",
        "19": "25.46",
        "20": "35",
        "21": "33.66",
        "22": "25.9",
        "23": "31.7",
        "24": "34.59",
        "25": "27.21",
        "26": "33.27",
        "27": "34.84",
        "28": "34.29",
        "29": "35",
        "30": "35",
        "31": "28.93",
        "tag_reference": "1217023051186865",
        "Total": "1008.59"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "34.64",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "34.79",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186828",
        "Total": "1084.43"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "24.48",
        "9": "35",
        "10": "35",
        "11": "32.81",
        "12": "35",
        "13": "0",
        "14": "0",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "34.07",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "34.68",
        "29": "34.12",
        "30": "32.11",
        "31": "35",
        "tag_reference": "1217023051186854",
        "Total": "997.27"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "0",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186836",
        "Total": "1050"
    },
    {
        "1": "35",
        "2": "35",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051186846",
        "Total": "70"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186816",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051186860",
        "Total": "105"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "0",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "0",
        "18": "35",
        "19": "0",
        "20": "35",
        "21": "0",
        "22": "35",
        "23": "35",
        "24": "0",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "34.25",
        "29": "0",
        "30": "35",
        "31": "0",
        "tag_reference": "1217023051186853",
        "Total": "629.25"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "34.77",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186837",
        "Total": "1084.77"
    },
    {
        "1": "101.81",
        "2": "53.85",
        "3": "53.61",
        "4": "46.96",
        "5": "43.18",
        "6": "142.87",
        "7": "132.89",
        "8": "62.83",
        "9": "51.58",
        "10": "0",
        "11": "0",
        "12": "73.6",
        "13": "56.53",
        "14": "0",
        "15": "61.76",
        "16": "73.79",
        "17": "192.95",
        "18": "38.06",
        "19": "32.03",
        "20": "0",
        "21": "62.04",
        "22": "0",
        "23": "0",
        "24": "90.82",
        "25": "115.45",
        "26": "83.95",
        "27": "0",
        "28": "0",
        "29": "85.04",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051186858",
        "Total": "1655.6"
    },
    {
        "1": "40",
        "2": "40",
        "3": "24.87",
        "4": "37.13",
        "5": "39.27",
        "6": "40",
        "7": "40.01",
        "8": "35.64",
        "9": "40",
        "10": "39.11",
        "11": "38.35",
        "12": "40.01",
        "13": "46.47",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "33.07",
        "18": "32.98",
        "19": "40",
        "20": "40",
        "21": "38.34",
        "22": "33.13",
        "23": "40",
        "24": "35.75",
        "25": "29.91",
        "26": "37.98",
        "27": "35.05",
        "28": "35.49",
        "29": "36.12",
        "30": "34",
        "31": "36.54",
        "tag_reference": "1217023051186882",
        "Total": "1159.22"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "34.12",
        "10": "35",
        "11": "33.83",
        "12": "35",
        "13": "0",
        "14": "34.49",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "0",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186847",
        "Total": "1012.44"
    },
    {
        "1": "35",
        "2": "32.44",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "30.74",
        "25": "32.26",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186806",
        "Total": "1075.44"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35.05",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186835",
        "Total": "1085.05"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "34.95",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051186823",
        "Total": "839.95"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "29.3",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186879",
        "Total": "1079.3"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186859",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "0",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186844",
        "Total": "1050"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "33.7",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "34.14",
        "tag_reference": "1217023051186824",
        "Total": "1082.84"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "33.38",
        "16": "35",
        "17": "35",
        "18": "24.98",
        "19": "25.42",
        "20": "35",
        "21": "26.33",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186872",
        "Total": "775.11"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "39.02",
        "26": "40",
        "27": "40",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "1217023051186833",
        "Total": "1199.02"
    },
    {
        "1": "56.75",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186868",
        "Total": "1106.75"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "34.88",
        "31": "35",
        "tag_reference": "1217023051186817",
        "Total": "1084.88"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "31.11",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "31.09",
        "19": "28.6",
        "20": "35",
        "21": "31.24",
        "22": "26.73",
        "23": "25.57",
        "24": "25.31",
        "25": "29.02",
        "26": "27.14",
        "27": "30.3",
        "28": "24.11",
        "29": "28.8",
        "30": "35",
        "31": "31.96",
        "tag_reference": "1217023051186820",
        "Total": "895.98"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "43.6",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186831",
        "Total": "1093.6"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "34.38",
        "21": "0",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "0",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186834",
        "Total": "1014.38"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "34.64",
        "8": "35",
        "9": "0",
        "10": "35",
        "11": "33.38",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "0",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "0",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "0",
        "31": "35",
        "tag_reference": "1217023051186812",
        "Total": "943.02"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051373056",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186876",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "0",
        "3": "35",
        "4": "0",
        "5": "0",
        "6": "35",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "35",
        "13": "35",
        "14": "0",
        "15": "0",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "0",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "0",
        "31": "35",
        "tag_reference": "1217023051186818",
        "Total": "665"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "0",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "0",
        "12": "35",
        "13": "56.8",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "0",
        "19": "35",
        "20": "35",
        "21": "34.61",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "0",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186873",
        "Total": "966.41"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "0",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186840",
        "Total": "1050"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186842",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "21.8",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "0",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186855",
        "Total": "1036.8"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186841",
        "Total": "980"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35.01",
        "16": "35",
        "17": "33.62",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "34.37",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186809",
        "Total": "1083"
    },
    {
        "1": "71.13",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "68.87",
        "6": "33.91",
        "7": "0",
        "8": "36.09",
        "9": "0",
        "10": "0",
        "11": "69.6",
        "12": "0",
        "13": "0",
        "14": "76.88",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "76.6",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "78.3",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "73.05",
        "27": "0",
        "28": "0",
        "29": "79.02",
        "30": "0",
        "31": "0",
        "tag_reference": "02E5692F7F6140NS",
        "Total": "663.45"
    },
    {
        "1": "35",
        "2": "34.29",
        "3": "35",
        "4": "34.25",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186883",
        "Total": "1083.54"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "1217023051186807",
        "Total": "120"
    },
    {
        "1": "35",
        "2": "34.29",
        "3": "34.01",
        "4": "35",
        "5": "35",
        "6": "30.32",
        "7": "33.31",
        "8": "31.66",
        "9": "29.99",
        "10": "22.39",
        "11": "35",
        "12": "34.12",
        "13": "37.58",
        "14": "34.38",
        "15": "32.61",
        "16": "33.57",
        "17": "35",
        "18": "32.53",
        "19": "28.06",
        "20": "27.9",
        "21": "33.78",
        "22": "30.93",
        "23": "32.83",
        "24": "25.66",
        "25": "32.24",
        "26": "33.99",
        "27": "31.71",
        "28": "35",
        "29": "35",
        "30": "34.77",
        "31": "32.9",
        "tag_reference": "1217023051186862",
        "Total": "1010.53"
    },
    {
        "1": "43.6",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "0",
        "7": "35",
        "8": "35",
        "9": "28.84",
        "10": "0",
        "11": "35",
        "12": "35",
        "13": "0",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "33.07",
        "18": "26.68",
        "19": "28.1",
        "20": "0",
        "21": "35",
        "22": "30",
        "23": "33.64",
        "24": "33.14",
        "25": "28.73",
        "26": "28.36",
        "27": "0",
        "28": "35",
        "29": "0",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186845",
        "Total": "839.16"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "33.88",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "25.53",
        "25": "32.55",
        "26": "32.16",
        "27": "35",
        "28": "35",
        "29": "33.86",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186839",
        "Total": "1067.98"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186825",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "0",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "33.79",
        "26": "35",
        "27": "34.84",
        "28": "35",
        "29": "35",
        "30": "31.81",
        "31": "35",
        "tag_reference": "1217023051186848",
        "Total": "1045.44"
    },
    {
        "1": "0",
        "2": "0",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "0",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "0",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "0",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186851",
        "Total": "910"
    },
    {
        "1": "0",
        "2": "35",
        "3": "0",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "33.16",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "0",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "0",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186852",
        "Total": "943.16"
    },
    {
        "1": "51.05",
        "2": "0",
        "3": "16.88",
        "4": "0",
        "5": "54.06",
        "6": "0",
        "7": "60.1",
        "8": "0",
        "9": "0",
        "10": "60.27",
        "11": "0",
        "12": "0",
        "13": "48.5",
        "14": "0",
        "15": "0",
        "16": "50.3",
        "17": "0",
        "18": "0",
        "19": "48.45",
        "20": "0",
        "21": "40.32",
        "22": "0",
        "23": "0",
        "24": "55.21",
        "25": "0",
        "26": "0",
        "27": "46.63",
        "28": "0",
        "29": "37.75",
        "30": "0",
        "31": "32.26",
        "tag_reference": "1217023051226718",
        "Total": "601.78"
    },
    {
        "1": "65.71",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "78.07",
        "7": "0",
        "8": "0",
        "9": "65.61",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "59.95",
        "15": "0",
        "16": "0",
        "17": "59.62",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "61.88",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "68.97",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "67.42",
        "31": "24.78",
        "tag_reference": "1217023051254738",
        "Total": "552.01"
    },
    {
        "1": "0",
        "2": "40.28",
        "3": "20.08",
        "4": "19.32",
        "5": "17.02",
        "6": "18.41",
        "7": "19.68",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "88.52",
        "14": "0",
        "15": "0",
        "16": "82.09",
        "17": "0",
        "18": "0",
        "19": "90.04",
        "20": "0",
        "21": "85.1",
        "22": "0",
        "23": "0",
        "24": "85.01",
        "25": "0",
        "26": "0",
        "27": "62.58",
        "28": "0",
        "29": "0",
        "30": "72.51",
        "31": "0",
        "tag_reference": "1217023051457963",
        "Total": "700.64"
    },
    {
        "1": "83.25",
        "2": "0",
        "3": "79.48",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226726",
        "Total": "162.73"
    },
    {
        "1": "70.53",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "64.01",
        "6": "0",
        "7": "47.51",
        "8": "0",
        "9": "0",
        "10": "69.91",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "70.84",
        "23": "0",
        "24": "64.34",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "73.05",
        "30": "0",
        "31": "0",
        "tag_reference": "FC7A94AE576E4BNS",
        "Total": "460.19"
    },
    {
        "1": "79.24",
        "2": "39.94",
        "3": "0",
        "4": "44.52",
        "5": "0",
        "6": "77.88",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "78.33",
        "11": "0",
        "12": "65.77",
        "13": "0",
        "14": "64.56",
        "15": "0",
        "16": "0",
        "17": "49.09",
        "18": "50.05",
        "19": "0",
        "20": "49.68",
        "21": "0",
        "22": "50.94",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "73.24",
        "29": "0",
        "30": "0",
        "31": "26.76",
        "tag_reference": "1217023051226772",
        "Total": "750"
    },
    {
        "1": "0",
        "2": "0",
        "3": "70.26",
        "4": "0",
        "5": "0",
        "6": "65.46",
        "7": "0",
        "8": "64.15",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "70.04",
        "14": "0",
        "15": "0",
        "16": "68.94",
        "17": "0",
        "18": "0",
        "19": "47.46",
        "20": "0",
        "21": "0",
        "22": "56.45",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "63.35",
        "27": "0",
        "28": "0",
        "29": "75.33",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226708",
        "Total": "581.44"
    },
    {
        "1": "0",
        "2": "0",
        "3": "79.65",
        "4": "60.7",
        "5": "92.51",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226736",
        "Total": "232.86"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "78.78",
        "25": "0",
        "26": "64.15",
        "27": "0",
        "28": "50.98",
        "29": "0",
        "30": "0",
        "31": "83.74",
        "tag_reference": "27A04964344B48NS",
        "Total": "277.65"
    },
    {
        "1": "74.77",
        "2": "0",
        "3": "0",
        "4": "64.96",
        "5": "0",
        "6": "0",
        "7": "75.75",
        "8": "0",
        "9": "0",
        "10": "64.57",
        "11": "0",
        "12": "0",
        "13": "70.58",
        "14": "0",
        "15": "0",
        "16": "65.26",
        "17": "0",
        "18": "68.55",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "77.75",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "79.7",
        "27": "0",
        "28": "55.13",
        "29": "0",
        "30": "52.63",
        "31": "0",
        "tag_reference": "1217023051226744",
        "Total": "749.65"
    },
    {
        "1": "0",
        "2": "0",
        "3": "50.35",
        "4": "0",
        "5": "0",
        "6": "47.76",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226746",
        "Total": "98.11"
    },
    {
        "1": "0",
        "2": "0",
        "3": "17.58",
        "4": "0",
        "5": "84.43",
        "6": "0",
        "7": "67.85",
        "8": "0",
        "9": "0",
        "10": "70.16",
        "11": "0",
        "12": "55.04",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "71.79",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "75.69",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "67.1",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "84.89",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226769",
        "Total": "594.53"
    },
    {
        "1": "79.12",
        "2": "0",
        "3": "73.32",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "80.21",
        "10": "34.64",
        "11": "0",
        "12": "73.87",
        "13": "0",
        "14": "0",
        "15": "35.66",
        "16": "79.42",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "82.09",
        "22": "0",
        "23": "0",
        "24": "83.92",
        "25": "0",
        "26": "68.56",
        "27": "0",
        "28": "80.29",
        "29": "0",
        "30": "0",
        "31": "84.92",
        "tag_reference": "1217023051320644",
        "Total": "856.02"
    },
    {
        "1": "0",
        "2": "30.23",
        "3": "0",
        "4": "26.5",
        "5": "0",
        "6": "60.61",
        "7": "0",
        "8": "0",
        "9": "53.23",
        "10": "0",
        "11": "0",
        "12": "46.46",
        "13": "35.09",
        "14": "0",
        "15": "0",
        "16": "58.98",
        "17": "0",
        "18": "0",
        "19": "63.79",
        "20": "0",
        "21": "0",
        "22": "69.84",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "65.8",
        "27": "0",
        "28": "0",
        "29": "72.11",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226750",
        "Total": "582.64"
    },
    {
        "1": "17.25",
        "2": "27.72",
        "3": "18.79",
        "4": "19.6",
        "5": "18.27",
        "6": "17.11",
        "7": "18.04",
        "8": "19.59",
        "9": "14.06",
        "10": "0",
        "11": "0",
        "12": "33.02",
        "13": "21.94",
        "14": "0",
        "15": "0",
        "16": "51.3",
        "17": "0",
        "18": "0",
        "19": "30.74",
        "20": "0",
        "21": "25.04",
        "22": "0",
        "23": "25.6",
        "24": "0",
        "25": "0",
        "26": "38.86",
        "27": "0",
        "28": "50.11",
        "29": "0",
        "30": "37.27",
        "31": "0",
        "tag_reference": "1217023051457950",
        "Total": "484.31"
    },
    {
        "1": "80.02",
        "2": "0",
        "3": "41.01",
        "4": "30.65",
        "5": "23.07",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "77.54",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "126.32",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "42.79",
        "25": "0",
        "26": "78.23",
        "27": "0",
        "28": "60.01",
        "29": "0",
        "30": "48.19",
        "31": "0",
        "tag_reference": "1217023051226755",
        "Total": "607.83"
    },
    {
        "1": "58.2",
        "2": "0",
        "3": "57.02",
        "4": "0",
        "5": "0",
        "6": "75.42",
        "7": "0",
        "8": "60.36",
        "9": "0",
        "10": "0",
        "11": "77.25",
        "12": "0",
        "13": "0",
        "14": "60.13",
        "15": "0",
        "16": "57.87",
        "17": "0",
        "18": "56.71",
        "19": "0",
        "20": "0",
        "21": "57.16",
        "22": "0",
        "23": "52.92",
        "24": "0",
        "25": "0",
        "26": "59.01",
        "27": "0",
        "28": "0",
        "29": "73.57",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226751",
        "Total": "745.62"
    },
    {
        "1": "73.97",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "84.18",
        "7": "0",
        "8": "0",
        "9": "59.08",
        "10": "0",
        "11": "68.46",
        "12": "0",
        "13": "71.91",
        "14": "0",
        "15": "75.93",
        "16": "62.66",
        "17": "0",
        "18": "0",
        "19": "86.15",
        "20": "0",
        "21": "0",
        "22": "60.82",
        "23": "0",
        "24": "0",
        "25": "75.31",
        "26": "31.53",
        "27": "0",
        "28": "0",
        "29": "50",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226759",
        "Total": "800"
    },
    {
        "1": "0",
        "2": "0",
        "3": "73.58",
        "4": "0",
        "5": "0",
        "6": "84.41",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "78.68",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "82.17",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "82.01",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "77.94",
        "31": "0",
        "tag_reference": "1217023051399411",
        "Total": "478.79"
    },
    {
        "1": "0",
        "2": "37.26",
        "3": "0",
        "4": "36.73",
        "5": "0",
        "6": "34.81",
        "7": "34.12",
        "8": "0",
        "9": "40",
        "10": "0",
        "11": "21.8",
        "12": "26.18",
        "13": "0",
        "14": "33.33",
        "15": "0",
        "16": "36.08",
        "17": "0",
        "18": "36.65",
        "19": "0",
        "20": "40",
        "21": "35.51",
        "22": "0",
        "23": "28.54",
        "24": "0",
        "25": "28.67",
        "26": "32",
        "27": "35",
        "28": "0",
        "29": "35",
        "30": "24.02",
        "31": "35",
        "tag_reference": "C53F0815578049NS",
        "Total": "630.7"
    },
    {
        "1": "57.94",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "81.47",
        "6": "0",
        "7": "49.67",
        "8": "0",
        "9": "0",
        "10": "80.47",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "80.37",
        "15": "0",
        "16": "0",
        "17": "83.59",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "62.32",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "75.44",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "80.66",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226730",
        "Total": "651.93"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "0",
        "13": "40",
        "14": "0",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "30.54",
        "21": "0",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "32.29",
        "26": "30.15",
        "27": "34.81",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "37.54",
        "tag_reference": "D677810D50B346NS",
        "Total": "1005.33"
    },
    {
        "1": "40",
        "2": "40",
        "3": "39.76",
        "4": "0",
        "5": "40",
        "6": "40",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "21.8",
        "14": "0",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "0",
        "19": "0",
        "20": "40",
        "21": "0",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "0",
        "26": "40",
        "27": "40",
        "28": "0",
        "29": "0",
        "30": "40",
        "31": "40",
        "tag_reference": "D0A4218E2FFE4CNS",
        "Total": "821.56"
    },
    {
        "1": "79.87",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "88.2",
        "7": "0",
        "8": "0",
        "9": "82.46",
        "10": "0",
        "11": "0",
        "12": "0.02",
        "13": "80.76",
        "14": "0",
        "15": "0",
        "16": "84.42",
        "17": "0",
        "18": "74.91",
        "19": "0",
        "20": "64.57",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "82.71",
        "25": "0",
        "26": "12.08",
        "27": "69.09",
        "28": "0",
        "29": "0",
        "30": "30.91",
        "31": "50",
        "tag_reference": "1217023051226770",
        "Total": "800"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "65.43",
        "6": "0",
        "7": "60.92",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "68.82",
        "24": "66.33",
        "25": "0",
        "26": "21.22",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226754",
        "Total": "282.72"
    },
    {
        "1": "0",
        "2": "0",
        "3": "77.82",
        "4": "0",
        "5": "0",
        "6": "77.61",
        "7": "0",
        "8": "0",
        "9": "74.61",
        "10": "0",
        "11": "0",
        "12": "75.83",
        "13": "0",
        "14": "0",
        "15": "71.13",
        "16": "0",
        "17": "0",
        "18": "71.36",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "74.08",
        "23": "0",
        "24": "0",
        "25": "79.96",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "75.34",
        "30": "0",
        "31": "72.26",
        "tag_reference": "1217023051423835",
        "Total": "750"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "5.61",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226749",
        "Total": "5.61"
    },
    {
        "1": "65.22",
        "2": "0",
        "3": "71.28",
        "4": "0",
        "5": "60.02",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226757",
        "Total": "196.52"
    },
    {
        "1": "73.88",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "79.49",
        "7": "0",
        "8": "0",
        "9": "77.8",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "77.05",
        "15": "0",
        "16": "0",
        "17": "65.86",
        "18": "0",
        "19": "0",
        "20": "73.53",
        "21": "0",
        "22": "0",
        "23": "73.45",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "73.43",
        "28": "0",
        "29": "0",
        "30": "76.19",
        "31": "0",
        "tag_reference": "1217023051226766",
        "Total": "670.68"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "76.04",
        "5": "0",
        "6": "30.06",
        "7": "0",
        "8": "50.89",
        "9": "0",
        "10": "75.35",
        "11": "0",
        "12": "0",
        "13": "31.64",
        "14": "40.22",
        "15": "0",
        "16": "78.51",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "66.03",
        "21": "0",
        "22": "0",
        "23": "63.49",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226762",
        "Total": "512.23"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "83.33",
        "5": "0",
        "6": "75.03",
        "7": "17.4",
        "8": "62.48",
        "9": "77.53",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "75.3",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226720",
        "Total": "391.07"
    },
    {
        "1": "0",
        "2": "0",
        "3": "80.01",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "79.52",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "78.36",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "77.03",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "83.56",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "78.79",
        "27": "0",
        "28": "0",
        "29": "78.18",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226776",
        "Total": "555.45"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "84.19",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "77.07",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "82.94",
        "14": "0",
        "15": "0",
        "16": "73.38",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "87.79",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "87.65",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "83.84",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226728",
        "Total": "576.86"
    },
    {
        "1": "100",
        "2": "0",
        "3": "0",
        "4": "100.32",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "220.42",
        "15": "0",
        "16": "0",
        "17": "168.02",
        "18": "0",
        "19": "0",
        "20": "130.06",
        "21": "0",
        "22": "155.88",
        "23": "0",
        "24": "76.52",
        "25": "153.46",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "161.18",
        "30": "0",
        "31": "167.24",
        "tag_reference": "1217023051226724",
        "Total": "1433.1"
    },
    {
        "1": "0",
        "2": "83.59",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "84.15",
        "7": "0",
        "8": "0",
        "9": "66.65",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "34.43",
        "14": "78.74",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "81.57",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "79.99",
        "23": "0",
        "24": "0",
        "25": "14.93",
        "26": "83",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "78.98",
        "tag_reference": "1217023051226719",
        "Total": "686.03"
    },
    {
        "1": "0",
        "2": "0",
        "3": "53.82",
        "4": "0",
        "5": "0",
        "6": "56.97",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "72.28",
        "25": "0",
        "26": "50",
        "27": "45.3",
        "28": "18.94",
        "29": "0",
        "30": "0",
        "31": "68.81",
        "tag_reference": "1217023051226784",
        "Total": "366.12"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "81.47",
        "8": "17.13",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "83.41",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "81.65",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "65.66",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051226727",
        "Total": "329.32"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "42.86",
        "31": "54.8",
        "tag_reference": "1217023051226735",
        "Total": "97.66"
    },
    {
        "1": "35",
        "2": "35",
        "3": "52.12",
        "4": "25.03",
        "5": "0",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "0",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "33.35",
        "17": "30.04",
        "18": "25",
        "19": "0",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "26.01",
        "26": "0",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "31.41",
        "31": "35",
        "tag_reference": "1217023051186813",
        "Total": "922.96"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "34.2",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186827",
        "Total": "1084.2"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "33.83",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186857",
        "Total": "1083.83"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "34.71",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "34.05",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186871",
        "Total": "1083.76"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186815",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186866",
        "Total": "1085"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186829",
        "Total": "945"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "34.71",
        "23": "35",
        "24": "35",
        "25": "29.91",
        "26": "35",
        "27": "0",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186869",
        "Total": "1044.62"
    },
    {
        "1": "23.22",
        "2": "21.8",
        "3": "34.62",
        "4": "0",
        "5": "35",
        "6": "24.96",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051186826",
        "Total": "139.6"
    },
    {
        "1": "24.22",
        "2": "26.33",
        "3": "35",
        "4": "24.05",
        "5": "35",
        "6": "35",
        "7": "30.74",
        "8": "31.94",
        "9": "29.54",
        "10": "29.58",
        "11": "29.8",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "30.48",
        "16": "35",
        "17": "35",
        "18": "30.08",
        "19": "35",
        "20": "29.78",
        "21": "26.05",
        "22": "33.92",
        "23": "27.99",
        "24": "31.89",
        "25": "27.47",
        "26": "35",
        "27": "29.8",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186861",
        "Total": "983.66"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "35",
        "13": "20.99",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "0",
        "24": "21.8",
        "25": "35",
        "26": "0",
        "27": "0",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186875",
        "Total": "812.79"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "35",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35.05",
        "tag_reference": "1217023051186830",
        "Total": "1085.05"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186881",
        "Total": "280"
    },
    {
        "1": "35",
        "2": "35",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "0",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "56.8",
        "14": "35",
        "15": "35",
        "16": "35",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "35",
        "31": "35",
        "tag_reference": "1217023051186877",
        "Total": "1071.8"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "40",
        "14": "40",
        "15": "0",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "0",
        "20": "40",
        "21": "40",
        "22": "0",
        "23": "35",
        "24": "35",
        "25": "35",
        "26": "0",
        "27": "40",
        "28": "40",
        "29": "0",
        "30": "40",
        "31": "35",
        "tag_reference": "D62237A2ED7748NS",
        "Total": "700"
    },
    {
        "1": "40",
        "2": "26.23",
        "3": "36.19",
        "4": "26.29",
        "5": "30.96",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "40",
        "10": "0",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "0",
        "18": "33.96",
        "19": "32.68",
        "20": "0",
        "21": "40",
        "22": "26.73",
        "23": "20.82",
        "24": "0",
        "25": "40",
        "26": "25.9",
        "27": "0",
        "28": "40",
        "29": "36.86",
        "30": "0",
        "31": "30.78",
        "tag_reference": "F4642B6457C042NS",
        "Total": "727.4"
    },
    {
        "1": "35",
        "2": "0",
        "3": "35",
        "4": "35",
        "5": "35",
        "6": "35",
        "7": "35",
        "8": "35",
        "9": "0",
        "10": "35",
        "11": "35",
        "12": "35",
        "13": "35",
        "14": "35",
        "15": "35",
        "16": "0",
        "17": "35",
        "18": "35",
        "19": "35",
        "20": "35",
        "21": "35",
        "22": "35",
        "23": "0",
        "24": "35",
        "25": "35",
        "26": "35",
        "27": "35",
        "28": "35",
        "29": "35",
        "30": "0",
        "31": "35",
        "tag_reference": "C3F8A35A580B4ENS",
        "Total": "910"
    },
    {
        "1": "40",
        "2": "40",
        "3": "40",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40.07",
        "8": "0",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "40",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "0",
        "20": "40",
        "21": "40",
        "22": "35",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "40",
        "28": "0",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "A421EAA70F3343NS",
        "Total": "1075.07"
    },
    {
        "1": "0",
        "2": "43.14",
        "3": "41.75",
        "4": "40.9",
        "5": "40.22",
        "6": "46",
        "7": "38.39",
        "8": "0",
        "9": "39.79",
        "10": "35.12",
        "11": "38.63",
        "12": "38.65",
        "13": "34.97",
        "14": "38.65",
        "15": "0",
        "16": "53.8",
        "17": "48.31",
        "18": "37.3",
        "19": "43.64",
        "20": "45.63",
        "21": "36.89",
        "22": "0",
        "23": "39.79",
        "24": "0",
        "25": "70.41",
        "26": "43.1",
        "27": "32.09",
        "28": "43.06",
        "29": "0",
        "30": "46.24",
        "31": "35.75",
        "tag_reference": "C01EF6C24FBD43NS",
        "Total": "1052.22"
    },
    {
        "1": "33.83",
        "2": "29.91",
        "3": "28.97",
        "4": "30.11",
        "5": "36.71",
        "6": "0",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "34.81",
        "12": "35.6",
        "13": "0",
        "14": "40",
        "15": "40",
        "16": "35.14",
        "17": "31.44",
        "18": "36.12",
        "19": "40",
        "20": "0",
        "21": "40",
        "22": "40",
        "23": "40",
        "24": "40",
        "25": "40",
        "26": "40",
        "27": "0",
        "28": "40",
        "29": "40",
        "30": "40",
        "31": "40",
        "tag_reference": "BD956417EA2346NS",
        "Total": "1012.64"
    },
    {
        "1": "0",
        "2": "56.17",
        "3": "0",
        "4": "0",
        "5": "62.51",
        "6": "53.29",
        "7": "0",
        "8": "53.18",
        "9": "0",
        "10": "0",
        "11": "58.95",
        "12": "0",
        "13": "2.89",
        "14": "51.31",
        "15": "57.52",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "51.35",
        "20": "0",
        "21": "58.37",
        "22": "0",
        "23": "54.03",
        "24": "0",
        "25": "15.78",
        "26": "44.14",
        "27": "48.39",
        "28": "0",
        "29": "48.71",
        "30": "0",
        "31": "33.41",
        "tag_reference": "1217023051226781",
        "Total": "750"
    },
    {
        "1": "31.14",
        "2": "24.48",
        "3": "0",
        "4": "0",
        "5": "53.75",
        "6": "0",
        "7": "45.6",
        "8": "0",
        "9": "0",
        "10": "51.8",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "0",
        "18": "0",
        "19": "64.14",
        "20": "0",
        "21": "0",
        "22": "42.41",
        "23": "0",
        "24": "31.37",
        "25": "0",
        "26": "43.53",
        "27": "0",
        "28": "56.36",
        "29": "0",
        "30": "51.13",
        "31": "28.75",
        "tag_reference": "1217023051254735",
        "Total": "524.46"
    },
    {
        "1": "56.01",
        "2": "0",
        "3": "62.05",
        "4": "0",
        "5": "50.59",
        "6": "0",
        "7": "62",
        "8": "0",
        "9": "0",
        "10": "60.82",
        "11": "58.82",
        "12": "0",
        "13": "34.5",
        "14": "58.08",
        "15": "0",
        "16": "61.23",
        "17": "38.74",
        "18": "0",
        "19": "0",
        "20": "53.39",
        "21": "48.18",
        "22": "0",
        "23": "48.28",
        "24": "46.97",
        "25": "0",
        "26": "38.84",
        "27": "0",
        "28": "48.85",
        "29": "0",
        "30": "40.55",
        "31": "41.57",
        "tag_reference": "1217023051226734",
        "Total": "909.47"
    },
    {
        "1": "50",
        "2": "57.93",
        "3": "0",
        "4": "0",
        "5": "43.79",
        "6": "38.11",
        "7": "0",
        "8": "61.02",
        "9": "0",
        "10": "72.22",
        "11": "0",
        "12": "0",
        "13": "45.85",
        "14": "52.27",
        "15": "0",
        "16": "71.77",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "69.3",
        "23": "0",
        "24": "0",
        "25": "68.98",
        "26": "0",
        "27": "0",
        "28": "60.11",
        "29": "0",
        "30": "58.65",
        "31": "0",
        "tag_reference": "1217023051254747",
        "Total": "750"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "67.78",
        "9": "32.4",
        "10": "20.48",
        "11": "21.24",
        "12": "20.62",
        "13": "26.71",
        "14": "21.32",
        "15": "0",
        "16": "33.72",
        "17": "0",
        "18": "48.5",
        "19": "19.5",
        "20": "25.92",
        "21": "22.29",
        "22": "0",
        "23": "38.73",
        "24": "27.78",
        "25": "0",
        "26": "0",
        "27": "47.36",
        "28": "23.63",
        "29": "0",
        "30": "41.68",
        "31": "21.23",
        "tag_reference": "1217023051254741",
        "Total": "560.89"
    },
    {
        "1": "0",
        "2": "68.74",
        "3": "0",
        "4": "0",
        "5": "0",
        "6": "68.75",
        "7": "0",
        "8": "0",
        "9": "0",
        "10": "65.71",
        "11": "0",
        "12": "0",
        "13": "0",
        "14": "67.56",
        "15": "0",
        "16": "0",
        "17": "55.08",
        "18": "0",
        "19": "0",
        "20": "64.62",
        "21": "0",
        "22": "0",
        "23": "0",
        "24": "63.7",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "66.08",
        "29": "42.6",
        "30": "0",
        "31": "0",
        "tag_reference": "1217023051254736",
        "Total": "562.84"
    },
    {
        "1": "192.06",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "183.4",
        "6": "0",
        "7": "0",
        "8": "0",
        "9": "149.49",
        "10": "0",
        "11": "57.52",
        "12": "0",
        "13": "78.21",
        "14": "96.61",
        "15": "0",
        "16": "88",
        "17": "0",
        "18": "0",
        "19": "94.3",
        "20": "0",
        "21": "0",
        "22": "100.66",
        "23": "0",
        "24": "0",
        "25": "0",
        "26": "136.25",
        "27": "0",
        "28": "112.3",
        "29": "0",
        "30": "0",
        "31": "0",
        "tag_reference": "05A946E0E9D743NS",
        "Total": "1288.8"
    },
    {
        "1": "0",
        "2": "0",
        "3": "167.44",
        "4": "0",
        "5": "0",
        "6": "0",
        "7": "0",
        "8": "151.52",
        "9": "0",
        "10": "0",
        "11": "0",
        "12": "135.04",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "0",
        "17": "172.49",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "143.34",
        "24": "0",
        "25": "0",
        "26": "0",
        "27": "0",
        "28": "0",
        "29": "163.77",
        "30": "0",
        "31": "0",
        "tag_reference": "20395FEBD2BC42NS",
        "Total": "933.6"
    },
    {
        "1": "0",
        "2": "0",
        "3": "0",
        "4": "0",
        "5": "106.87",
        "6": "0",
        "7": "0",
        "8": "138.22",
        "9": "0",
        "10": "0",
        "11": "30",
        "12": "151.26",
        "13": "0",
        "14": "0",
        "15": "0",
        "16": "120.24",
        "17": "0",
        "18": "0",
        "19": "0",
        "20": "0",
        "21": "0",
        "22": "0",
        "23": "62.46",
        "24": "100.5",
        "25": "0",
        "26": "0",
        "27": "50.04",
        "28": "0",
        "29": "196.53",
        "30": "0",
        "31": "0",
        "tag_reference": "23CC450D068049NS",
        "Total": "956.12"
    },
    {
        "1": "40",
        "2": "40",
        "3": "0",
        "4": "40",
        "5": "40",
        "6": "40",
        "7": "40",
        "8": "40",
        "9": "40",
        "10": "40",
        "11": "40",
        "12": "39.76",
        "13": "0",
        "14": "40",
        "15": "20",
        "16": "40",
        "17": "40",
        "18": "40",
        "19": "40",
        "20": "40",
        "21": "40",
        "22": "37.28",
        "23": "39.94",
        "24": "37.82",
        "25": "40",
        "26": "40",
        "27": "0",
        "28": "62.06",
        "29": "0",
        "30": "40",
        "31": "0",
        "tag_reference": "F85BB4E6BBED40NS",
        "Total": "1036.86"
    }
]';

        $data = json_decode($data, true);
        // dd($data);
        $messing_array = array();
         foreach($data as $count1=>$data_item){
            //  dd($data_item['tag_reference']);
             $sql = "select * from vehicles where fuel_tag = '".$data_item['tag_reference']."'";
             $vehicles = DB::select($sql);
            //  dd($vehicles);
            if(count($vehicles)>0){
                for($i=1;$i<=31;$i++){
                 $char = $i;
                 if(isset($data_item[$char])){
                     if($data_item[$char] > 0){
                         if(count($vehicles)>0){
                            $sql2 = "INSERT INTO `vehicles_fuel`(`vehicle_id`, `fuel_price`, `year`, `month`, `day`, `added_at`) VALUES (".$vehicles[0]->id.",".$data_item[$char].",'2024','10','".$char."',now())";
                            DB::select($sql2);
                            // dd($sql2);
                         }else{
                            $messing_array[]= $data_item;
                         }
                     }

                 }else{
                     echo $count1.'-'.$vehicles[0]->plate.':'.'Zero'.'<br>';
                 }
             }
            }else{
                echo $count1.'-'.$data_item['tag_reference'].'Zero'.'<br>';
            }

         }
        // dd($messing_array);

    }
    function DA_PANDA_Handling() {
            //  for($i=1;$i<=4;$i++){
            //          $sql = "INSERT INTO `btc_properties` (`id`, `property_id`, `name`, `name_ar`, `description`, `branches`, `price`, `status_id`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES (NULL, '41', 'Uniform', NULL, 'Offical BTC drivres uniform Size: XXXL (4)', 'Ninja Project', '1.00', '1', '2', '2024-05-29 11:40:57', NULL, NULL);";
            //         \DB::select($sql);
            //  }

            // dd("Done");



            // exit;
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
    public function contract_method($job_id){

        // DB::select("SELECT * FROM `drivers_contracts` where job_id='".$job_id."'");
        $drivers = Drivers::where('job_id',$job_id)->get();
        if (count($drivers) > 0) {
            $check_if_exsist = DB::select("SELECT * FROM `drivers_contracts` where job_id='".$job_id."'");
            if(count($check_if_exsist)>0){

            } else {
                $drivers = DB::select("SELECT warehouse.warehouseName,drivers.*FROM drivers INNER JOIN warehouse ON drivers.warehouseId=warehouse.id WHERE job_id='$job_id'");
                $driver_name = $drivers[0]->fullName;
                $job_id = $drivers[0]->job_id;
                $iqama = $drivers[0]->iqama;
                $phone = $drivers[0]->mobileNumber;
                $warehouseName = $drivers[0]->warehouseName;
                $num = HelperFunctionsController::generateOTP(8);
                $ref_no = 'EC' . $num;
                DB::insert("INSERT INTO drivers_contracts (reference_no, driver_name, job_id, iqama, phone, work_area) VALUES ('$ref_no', '$driver_name', '$job_id', '$iqama', '$phone', '$warehouseName')");
                $check_if_exsist = DB::select("SELECT * FROM `drivers_contracts` where job_id='".$job_id."'");
            }
            foreach($check_if_exsist as $driver) {
                // dd($driver->driver_signed_date);
                // $driverDB = DB::select("select * from drivers where job_id='".$driver[0]->job_id."' ");
                if(isset($drivers[0]->nationality_id)){
                     $countries = DB::select("SELECT * FROM `lkp_country` where id=".$drivers[0]->nationality_id."");
                     if(count($countries)>0){
                         $driverDB = DB::select("UPDATE `drivers_contracts` SET `driver_signed_date`='".$drivers[0]->created_at."',phone='".$drivers[0]->mobileNumber."',iqama='".$drivers[0]->iqama."',nationality='".$countries[0]->country_ar."' WHERE `job_id`='".$check_if_exsist[0]->job_id."' ");
                     }else{
                         $driverDB = DB::select("UPDATE `drivers_contracts` SET `driver_signed_date`='".$drivers[0]->created_at."',phone='".$drivers[0]->mobileNumber."',iqama='".$drivers[0]->iqama."' WHERE `job_id`='".$check_if_exsist[0]->job_id."' ");
                     }
                }else{
                    $driverDB = DB::select("UPDATE `drivers_contracts` SET `driver_signed_date`='".$drivers[0]->created_at."',phone='".$drivers[0]->mobileNumber."',iqama='".$drivers[0]->iqama."' WHERE `job_id`='".$check_if_exsist[0]->job_id."' ");
                }
            }
            $drivers = DB::select("SELECT * FROM `drivers_contracts` where job_id='".$job_id."'");
            // dd($drivers);
            return view("Ninga",compact('drivers'));
        } else {
             echo("رقم عقد العمل غير صحيح");
        }

    }
    public function updateDriver(){
        $payload = '[
    {
        "job_id": "1725358760237460",
        "fullname": "HAFEDHALNASI",
        "bank_type": "2",
        "ben_iban": "SA7080000355608019403915",
        "ben_name": "Abdulqawei Alnesi",
        "ben_iqama": "2300516172"
    },
    {
        "job_id": "1726396496237180",
        "fullname": "AHMEDABDULRAHMAN",
        "bank_type": "2",
        "ben_iban": "SA8280000980608017375316",
        "ben_name": "ABUBAKER SIFELDIN AHMED",
        "ben_iqama": "2572103956"
    },
    {
        "job_id": "1726318273480210",
        "fullname": "MUBARAKALAWLAQI",
        "bank_type": "2",
        "ben_iban": "SA7780000644608016908370",
        "ben_name": "ABDULLAH MOHSEN MOHAMED",
        "ben_iqama": "2536309657"
    },
    {
        "job_id": "1726338309088280",
        "fullname": "MOHAMMADHOSSAIN",
        "bank_type": "2",
        "ben_iban": "SA1380000129608016486744",
        "ben_name": "MOHAMMAD SHAHADAT",
        "ben_iqama": "2439590262"
    },
    {
        "job_id": "1724012074257760",
        "fullname": "IZAZMUHAMMAD",
        "bank_type": "2",
        "ben_iban": "SA968000098060801653 9409",
        "ben_name": "IZAZ KHAN DIR MUHAMMAD",
        "ben_iqama": "2559286170 "
    },
    {
        "job_id": "1724010986257640",
        "fullname": "EMADELSAADAWY",
        "bank_type": "13",
        "ben_iban": "SA3405000068205315331000",
        "ben_name": "Mohammed Taha Abdullah ",
        "ben_iqama": "2563840152"
    },
    {
        "job_id": "1725188440202480",
        "fullname": "AHMEDALSHAER",
        "bank_type": "13",
        "ben_iban": "SA8605000068204693297000",
        "ben_name": "AHMED HAMED AL SHAER",
        "ben_iqama": "2124619145"
    },
    {
        "job_id": "1723892796206280",
        "fullname": "RIYADHALNASI",
        "bank_type": "13",
        "ben_iban": "SA1405000068202245293000",
        "ben_name": "RIYADH SALEM LGRAD",
        "ben_iqama": "2335831828"
    },
    {
        "job_id": "1725189901202820",
        "fullname": "MOHAMMEDELBESHEITI",
        "bank_type": "2",
        "ben_iban": "SA5180000392608010111165",
        "ben_name": "MOHAMMED ELBESHEITI",
        "ben_iqama": "2152735904"
    },
    {
        "job_id": "1723737239480580",
        "fullname": "ABDALLAHAwlaqi",
        "bank_type": "2",
        "ben_iban": "SA3880000644608016900245",
        "ben_name": " Abdullah alawi ahmed",
        "ben_iqama": "2551023308"
    },
    {
        "job_id": "1724083951206270",
        "fullname": "ABOBAKRKAADAN",
        "bank_type": "2",
        "ben_iban": "SA2980000129608016742245",
        "ben_name": "ABOBAKR ALI",
        "ben_iqama": "2556530430"
    },
    {
        "job_id": "1724176755480970",
        "fullname": "KHALIDALSADAWI",
        "bank_type": "2",
        "ben_iban": "SA0380000174608010165512",
        "ben_name": "KHALID  ALI  MOHSEN  AL SADAWI",
        "ben_iqama": "2170582149"
    },
    {
        "job_id": "1723892051088130",
        "fullname": "AHMEDAWLAQI",
        "bank_type": "2",
        "ben_iban": "SA708000059760801631580",
        "ben_name": "AHMED HUSSEIN AHMED",
        "ben_iqama": "2558114084"
    },
    {
        "job_id": "1723723652419180",
        "fullname": "QAIDAHMED",
        "bank_type": "2",
        "ben_iban": "SA718000063960801020 8162",
        "ben_name": "QAID MOHAMMED ALAW AHMED",
        "ben_iqama": "2129945206"
    },
    {
        "job_id": "1724062175088440",
        "fullname": "MOHAMEDABDALLA",
        "bank_type": "2",
        "ben_iban": "SA9080000140608016226400",
        "ben_name": "MOHAMED BALA MOHAMED",
        "ben_iqama": "2540457997"
    },
    {
        "job_id": "1723975502419980",
        "fullname": "ALAAELDINADAM",
        "bank_type": "2",
        "ben_iban": "SA9080000140608016226400",
        "ben_name": "MOHAMED BALA MOHAMED",
        "ben_iqama": "2540457997"
    },
    {
        "job_id": "1723637535202920",
        "fullname": "DulalHossain",
        "bank_type": "2",
        "ben_iban": "SA7880000597608016321233",
        "ben_name": "Dulal Hossain",
        "ben_iqama": "2518256355"
    },
    {
        "job_id": "1723660803202560",
        "fullname": "HESHAMMOHAMMED",
        "bank_type": "2",
        "ben_iban": "SA0680000639608016085689",
        "ben_name": "HESHAM",
        "ben_iqama": "2411279835"
    },
    {
        "job_id": "1723561943088720",
        "fullname": "RAJIBULALAM",
        "bank_type": "2",
        "ben_iban": "SA2180000539608015494354",
        "ben_name": "RAJIBUL",
        "ben_iqama": "2511739498"
    },
    {
        "job_id": "1725199512237870",
        "fullname": "SAEEDSAEED",
        "bank_type": "2",
        "ben_iban": "SA9480000135608010199386",
        "ben_name": "SAEED SALEM SAEED",
        "ben_iqama": "2054669367"
    },
    {
        "job_id": "1725542063202580",
        "fullname": "HAFIZHAGAHMED",
        "bank_type": "13",
        "ben_iban": "SA3210000011100375684106",
        "ben_name": "HAFIZ MOHSIN",
        "ben_iqama": "2503924413"
    },
    {
        "job_id": "1723642323202530",
        "fullname": "SallahMaki",
        "bank_type": "10",
        "ben_iban": "SA8060100030693005258001",
        "ben_name": "Salah aldeen yousef",
        "ben_iqama": "2022276295"
    },
    {
        "job_id": "1723722680480760",
        "fullname": "HAITHMELNSAI",
        "bank_type": "13",
        "ben_iban": "SA3810000011100050782207",
        "ben_name": "HAITHM ELNSI",
        "ben_iqama": "2300516206"
    },
    {
        "job_id": "1723720493419300",
        "fullname": "ALITAERAN",
        "bank_type": "13",
        "ben_iban": "SA8510000065500004821205",
        "ben_name": "Ali Mohammed Ali",
        "ben_iqama": "2258013313"
    },
    {
        "job_id": "1724240946206660",
        "fullname": "ADELALSHAMMARI",
        "bank_type": "13",
        "ben_iban": "SA2110000011100081285909",
        "ben_name": "ADEL NAWAF",
        "ben_iqama": "1051780232"
    },
    {
        "job_id": "1726147715480670",
        "fullname": "OMERELKARNAKI",
        "bank_type": "13",
        "ben_iban": "SA8010000011100122766509",
        "ben_name": "RAMI KAMEL ALI",
        "ben_iqama": "2494072784"
    },
    {
        "job_id": "1723738201202280",
        "fullname": "ALIAWAD",
        "bank_type": "2",
        "ben_iban": "SA3880000644608016900245",
        "ben_name": " Abdullah alawi awlaqi",
        "ben_iqama": "2551023308"
    }
]';

        $payload = json_decode($payload);
        // dd($payload);
        $new_drivers = array();
        foreach($payload as $users){
            $warehouse_id = 372;
            // dd($users);
            $driver = Drivers::where('job_id',$users->job_id)->get();
            // dd($driver);
            if(count($driver)>0){
                $driver[0]->bank_id  = $users->bank_type;
                $driver[0]->benIBAN  = $users->ben_iban;
                $driver[0]->benIqama  = $users->ben_iqama;
                $driver[0]->benName  = $users->ben_name;
                $driver[0]->created_by_id  = 2;
                $driver[0]->save();
            }else{
                // dd($users);
                $new_drivers[] =$users;
                // $new_drivers[] = Drivers::create([
                //     'bander_car_id'=>$users->bander_car,
                //     'fullName'=>$users->name,
                //     'mobileNumber'=>$users->phone,
                //     'nationality_id'=>$users->nationalty,
                //     'iqama'=>$users->iqama,
                //     'email_id'=>$users->email,
                //     'job_id'=>$users->job_id,
                //     'status_id'=>1,
                //     'warehouseId'=>$warehouse_id,
                // ]);
            }


            // if(count($db_driver)>0){
            //     $db_driver = $db_driver[0];
            //     $db_driver->bank_id = $users->bank_id;
            //     $db_driver->benIBAN = $users->iban;
            //     $db_driver->benIqama = $users->iqama;
            //     $db_driver->benName = $users->ben_name;
            //     $db_driver->save();
            //     // dd($db_driver);
            // }else{
            //     $new_drivers[]=$users;
            // }
        }
        dd($new_drivers);

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
        $or_from = "panda_jed_0039";
        $or_to = 'panda-jed-0039';
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
