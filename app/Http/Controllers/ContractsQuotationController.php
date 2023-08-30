<?php

namespace App\Http\Controllers;

use App\Salary;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Storage;


class ContractsQuotationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['company_quotation_accept', 'company_quotation_reject', 'company_quotation_reject_reason']]);
    }
    public function verification(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->id;
        echo 'done';
        

    }
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $contracts = DB::select('SELECT * from contracts_quotations');
        $approved_users = DB::select('SELECT * from contracts_quotations_approved_by');
        // $emp_ids = $cont_quot_ids = array();
        // foreach($approved_users as $approved_user)
        // {
        //     $emp_ids[] = $approved_user->emp_id;
        //     $cont_quot_ids[] = $approved_user->cont_quot_id;

        // }
        $approval_users = DB::select("SELECT contracts_quotations_approval_users.emp_id, users.`name` FROM contracts_quotations_approval_users INNER JOIN users ON contracts_quotations_approval_users.emp_id=users.id ORDER BY CASE WHEN users.id = '$user_id' THEN 0 ELSE 1 END, users.id");
        
        return view('ContractsQuotation.index')->with('contracts', $contracts)->with('approved_users', $approved_users)->with('approval_users', $approval_users);
    }
    
    public function create(Request $request)
    {
        $type = $request->type;
        return view('ContractsQuotation.create')->with('type', $type);
    }
    public function store(Request $request)
    {
        $type = $request->type;
        $type = lcfirst($type);
        $companyName = $request->companyName;
        $companyEmail = $request->companyEmail;
        $body = $request->body;

        $user_id = Auth::user()->id;
        DB::insert("INSERT into contracts_quotations (type, companyName, companyEmail, body, created_by, created_at) VALUES ('$type', '$companyName', '$companyEmail', '$body', '$user_id', NOW())");
        return redirect('/ContractsQuotation')->with('success', "Data Added successfully");
    }
    public function get(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $contract = DB::select("SELECT * from contracts_quotations WHERE id = '$id'");
        $reject_reasons = DB::select("SELECT contracts_quotations_approved_by.reject_reason,users.`name` FROM contracts_quotations_approved_by INNER JOIN users ON contracts_quotations_approved_by.emp_id=users.id WHERE contracts_quotations_approved_by.reject_reason is not null AND contracts_quotations_approved_by.id = '$id'");
        
        return view('ContractsQuotation.edit')->with('type', $type)->with('data', $contract)->with('reject_reasons', $reject_reasons);
    }
    public function showContract(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $contract = DB::select("SELECT * from contracts_quotations WHERE id = '$id'");

        return view('ContractsQuotation.show')->with('type', $type)->with('data', $contract);
    }
    
    
    public function update(Request $request)
    {
        $companyName = $request->companyName;
        $companyEmail = $request->companyEmail;
        $body = $request->body;
        $id = $request->id;
        $user_id = Auth::user()->id;
        
        $names = $request->name;
        $descriptions = $request->description;
        $prices = $request->price;
        DB::delete("DELETE from contracts_quotations_items WHERE quot_id = '$id'");
        for ($i = 0; $i < sizeof($name); $i++) {
            $name = $names[$i];
            $description = $descriptions[$i];
            $price = $prices[$i];
            DB::insert("INSERT into contracts_quotations_items (quot_id, name, description, price, created_by, created_at) VALUES ('$id', '$name', '$description', '$price', '$user_id', NOW())");
        }
        if(isset($request->reasons_update))
            DB::delete("DELETE FROM contracts_quotations_approved_by WHERE cont_quot_id = '$id'");
        DB::update("UPDATE contracts_quotations set companyName = '$companyName', companyEmail = '$companyEmail', body = '$body', updated_by = '$user_id', updated_at = NOW() WHERE id = '$id'");
        return redirect('/ContractsQuotation')->with('success', "Data Updated successfully");
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        DB::delete("DELETE FROM contracts_quotations WHERE id = '$id'");
        return redirect('/ContractsQuotation')->with('success', "Data DELETED successfully");
    }
    public function add_approval(Request $request)
    {
        $status = $request->status;
        $emp_id = $request->emp_id;
        $cont_quot_id = $request->cont_quot_id;
        DB::insert("INSERT into contracts_quotations_approved_by (emp_id, status, cont_quot_id, created_on) VALUES ('$emp_id', '$status', '$cont_quot_id', NOW())");
        $approved = DB::select("SELECT * FROM contracts_quotations_approved_by WHERE cont_quot_id = '$cont_quot_id'");
        $approval = DB::select("SELECT * FROM contracts_quotations_approval_users");
        if (count($approved) == count($approval)) {
            $row = DB::select("SELECT * FROM contracts_quotations WHERE id = '$cont_quot_id'");
            $company = $row[0]->companyName;
            $email = $row[0]->companyEmail;
            $msg = "Hi <b>$company</b>, <br><br>We trust this email find you well.<br><br>This email contains quotation as below.<br>";
            $msg .= $row[0]->body;
            $msg .= '<br>';
            $msg .= 'If you wanna accept this quotation please <a href="https://btcdmins.com/QuotationAccept/'.base64_encode($row[0]->id).'">click here</a>.<br>If you wanna reject this quotation please <a href="https://btcdmins.com/QuotationReject/'.base64_encode($row[0]->id).'">click here</a>.<br><br>';
            $msg .= 'Best Regards<br>';
            $msg .= 'Bandar Trading Company';
            $recipients = [
                'muhammad.shehroze@spsnet.com',
            ];
            $ccRecipients = [
                // 'a.omar@btclogistic.com'
            ];
            $subject = "Quotation by BTC";
            Mail::send([], [], function ($message) use ($recipients, $ccRecipients, $msg, $subject) {
                $message->to($recipients)
                        ->cc($ccRecipients)
                        ->subject($subject)
                        ->setBody($msg, 'text/html');
            });
            if (count(Mail::failures()) > 0) {
                return response()->json(['message' => 'Failed to send email.'], 500);
            }

        }
    }
    
    public function reject_quotation(Request $request)
    {
        $reject_reason = $request->reject_reason;
        $status = 0;
        $emp_id = $request->emp_id;
        $cont_quot_id = $request->cont_quot_id;
        DB::insert("INSERT into contracts_quotations_approved_by (emp_id, status, reject_reason, cont_quot_id, created_on) VALUES ('$emp_id', '$status', '$reject_reason', '$cont_quot_id', NOW())");
        return redirect('/ContractsQuotation')->with('success', "Reject reason Added successfully");
    }
    public function company_quotation_accept($id) {
        $id = base64_decode($id);
        $row = DB::select("SELECT * FROM contracts_quotations WHERE id = '$id'");
        if(count($row) > 0) {
            $company = $row[0]->companyName;
            $status = $row[0]->status;
            $id = base64_encode($id);
            return view('ContractsQuotation.accept')->with('id', $id)->with('status', $status)->with('company', $company);
        } else {
            return response()->json(['message' => 'Something is wrong.'], 500);
        }
    }
    public function company_quotation_accept_data(Request $request) {
        $request->validate([
            'id' => 'required',
            'reg_number' => 'required',
            'iban_number' => 'required',
            'info_person' => 'required',
            'reg_certificate' => 'required',
            'address' => 'required',
            'chamber_file' => 'required',
            'iqama' => 'required',
            'vat_certificate' => 'required',
            'iban_certificate' => 'required',
        ]);
        $id = base64_decode($request->id);
        $reg_number = $request->reg_number;
        $iban_number = $request->iban_number;
        $info_person = $request->info_person;
 
        
        $reg_certificate = 'Registration Certificate_'.time().'.'.$request->reg_certificate->extension();
        $request->reg_certificate->move(storage_path('app/public/CompanyQuotation'), $reg_certificate);
        
        $address = 'Address_'.time().'.'.$request->address->extension();
        $request->address->move(storage_path('app/public/CompanyQuotation'), $address);
        
        $chamber_file = 'Chamber file_'.time().'.'.$request->chamber_file->extension();
        $request->chamber_file->move(storage_path('app/public/CompanyQuotation'), $chamber_file);
        
        $iqama = 'Iqama_'.time().'.'.$request->iqama->extension();
        $request->iqama->move(storage_path('app/public/CompanyQuotation'), $iqama);
        
        $vat_certificate = 'VAT Certificate_'.time().'.'.$request->vat_certificate->extension();
        $request->vat_certificate->move(storage_path('app/public/CompanyQuotation'), $vat_certificate);
        
        $iban_certificate = 'IBAN Certificate_'.time().'.'.$request->iban_certificate->extension();
        $request->iban_certificate->move(storage_path('app/public/CompanyQuotation'), $iban_certificate);
        $auth_letter = $iqama_image = "";
        if($info_person == 1) {
            $auth_letter = 'Authentication letter_'.time().'.'.$request->auth_letter->extension();
            $request->auth_letter->move(storage_path('app/public/CompanyQuotation'), $auth_letter);
            $iqama_image = 'Info_Iqama_'.time().'.'.$request->iqama_image->extension();
            $request->iqama_image->move(storage_path('app/public/CompanyQuotation'), $iqama_image);
        }
        DB::update("UPDATE contracts_quotations set status = '1', reg_number = '$reg_number'
        , iban_number = '$iban_number'
        , info_person = '$info_person'
        , reg_certificate = '$reg_certificate'
        , address = '$address'
        , chamber_file = '$chamber_file'
        , iqama = '$iqama'
        , vat_certificate = '$vat_certificate'
        , iban_certificate = '$iban_certificate'
        , auth_letter = '$auth_letter'
        , iqama_image = '$iqama_image'
        WHERE id = '$id'");
        
        session()->flash('message', 'Thanks for providing the Data.');
        return redirect()->back();
    }
    
    public function company_quotation_reject($id) {
        $id = base64_decode($id);
        $row = DB::select("SELECT * FROM contracts_quotations WHERE id = '$id'");
        if(count($row) > 0) {
            $company = $row[0]->companyName;
            $status = $row[0]->status;
            $id = base64_encode($id);
            return view('ContractsQuotation.reject')->with('id', $id)->with('status', $status)->with('company', $company);
        } else {
            return response()->json(['message' => 'Something is wrong.'], 500);
        }
    }
    public function company_quotation_reject_reason(Request $request) {
        $request->validate([
            'id' => 'required',
            'reject_reason' => 'required',
        ]);
        $id = base64_decode($request->id);
        $reject_reason = $request->reject_reason;
        DB::update("UPDATE contracts_quotations set status = '0', reject_reason = '$reject_reason' WHERE id = '$id'");
        
        session()->flash('message', 'Thanks for providing the reason.');
        return redirect()->back();
    }
}
