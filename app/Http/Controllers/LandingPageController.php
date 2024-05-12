<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HelperFunctionsController;

class LandingPageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index($type)
    {
        if($type == 'ar')
            return view('LandingPages.index_ar');
        else
            return view('LandingPages.index');
    }
    public function store(Request $request)
    {
        $comp_name = $request->comp_name;
        $store_name = $request->store_name;
        $comp_email = $request->comp_email;
        $contact_name = $request->contact_name;
        $contact_phone = $request->contact_phone;
        $contact_email = $request->contact_email;
        $prod_type = $request->prod_type;
        $prod_size = $request->prod_size;
        $prod_weight = $request->prod_weight;
        $prod_storage = $request->prod_storage;
        $cities = $request->cities;
        $monthly_orders = $request->monthly_orders;
        $requests_no = $request->requests_no;
        $prod_types = $request->prod_types;
        $products = implode(", ", $prod_types);
        $acknowledgment = $request->acknowledgment;
        if($acknowledgment == 'on') {
            DB::insert("INSERT INTO clients_information (comp_name, store_name, comp_email, contact_name, contact_phone, contact_email, prod_type, prod_size, prod_weight, prod_storage, cities, monthly_orders, requests_no, added_on) VALUES 
            ('$comp_name', '$store_name', '$comp_email', '$contact_name', '$contact_phone', '$contact_email', '$prod_type', '$prod_size', '$prod_weight', '$prod_storage', '$cities', '$monthly_orders', '$requests_no', NOW())");
            $lastInsertedId = DB::getPdo()->lastInsertId();
            foreach ($prod_types as $prod_type)
                DB::insert("INSERT INTO clients_information_products (client_id, prod_type) VALUES ('$lastInsertedId', '$prod_type')");
            
            $msg = "The following trader: $comp_name has requested a call back regarding Contracting wrt deliver their shipments. Please review the following details of $comp_name company and negotiate with its representative.<br><br>
            <b>Company: $comp_name<br>
            Store: $store_name<br>
            Email: $comp_email<br><br>
            Contact name: $contact_name<br>
            Contact phone: $contact_phone<br>
            Contact email: $contact_email<br><br>
            Product type: $prod_type<br>
            Product size: $prod_size<br>
            Product weight: $prod_weight<br>
            Cities: <br>
            Monthly orders: $monthly_orders<br>
            Number of Requests during presentations: $requests_no<br>
            Products: $products</b><br><br>
            Regards<br>
            System generated email.
            ";
            $recipients = [
                'm.shehroze@btclogistic.com',
                // 'cpm@btclogistic.com',
                // 'm.shehroze@btclogistic.com',
            ];
            $ccRecipients = [
                // 'cpm@btclogistic.com',
            ];
            $subject = "Zid Trader Contracting Request";
            $email_status = HelperFunctionsController::send_email($recipients, $ccRecipients, $msg, $subject);
            if($email_status == false) {
                return response()->json(['message' => 'Failed to send email.'], 500);
            }
            session()->flash('message', 'عزيزي العميل تم استلام طلبكم، شاكرين لتعاونكم، سيتم تزويدكم ببيانات التفعيل');
            return redirect()->back();
        }
        session()->flash('error', 'Something went wrong. Please try again.');
        return redirect()->back();
    }
    
    public function system() {
        $unions = DB::select("SELECT * FROM tbl_union");
        return view('LandingPages.system')->with('unions', $unions);
    }
}