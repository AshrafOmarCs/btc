<?php

namespace App\Http\Controllers;

use App\Company;
use \Illuminate\Support\Facades\DB;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return Response()->json(['here'=>'2']);
        $lkp_calculation_method = DB::select('SELECT * from lkp_calculation_method ');

        $Select_db = DB::table('lkp_company')
            ->select('lkp_company.status', 'lkp_company.id as id', 'companyName', 'calculation_method_id', 'calculation_method',
                'period_start', 'period_end', 'companyFullName_en', 'companyFullName_ar', 'TaxNumber', 'CreditNote_Letter',
                'created_users.name as created_users', 'updated_users.name as updated_users', 'lkp_company.created_at', 'lkp_company.updated_at'
            )
            ->leftJoin('lkp_calculation_method', 'lkp_company.calculation_method_id', '=', 'lkp_calculation_method.id')
            ->leftJoin('users as created_users', 'lkp_company.createdby_id', '=', 'created_users.id')
            ->leftJoin('users as updated_users', 'lkp_company.updatedby_id', '=', 'updated_users.id');


        //dd($Select_db->first());

        if (request()->ajax()) {
            if (!empty($request->filter_companyName)) {
                $Select_db->whereRaw("UPPER(companyName) LIKE '%" . strtoupper($request->filter_companyName) . "%'");
            }
            if (!empty($request->filter_calculation_method_id)) {
                $Select_db->where('calculation_method_id', $request->filter_calculation_method_id);
            }
            if (!empty($request->filter_period_start)) {
                $Select_db->whereRaw("UPPER(period_start) LIKE '%" . strtoupper($request->filter_period_start) . "%'");
            }
            if (!empty($request->filter_period_end)) {
                $Select_db->whereRaw("UPPER(period_end) LIKE '%" . strtoupper($request->filter_period_end) . "%'");
            }
            if (!empty($request->filter_companyFullName_en)) {
                $Select_db->whereRaw("UPPER(companyFullName_en) LIKE '%" . strtoupper($request->filter_companyFullName_en) . "%'");
            }
            if (!empty($request->filter_companyFullName_ar)) {
                $Select_db->whereRaw("UPPER(companyFullName_ar) LIKE '%" . strtoupper($request->filter_companyFullName_ar) . "%'");
            }
            if (!empty($request->filter_TaxNumber)) {
                $Select_db->whereRaw("UPPER(TaxNumber) LIKE '%" . strtoupper($request->filter_TaxNumber) . "%'");
            }
            if (!empty($request->filter_CreditNote_Letter)) {
                $Select_db->whereRaw("UPPER(CreditNote_Letter) LIKE '%" . strtoupper($request->filter_CreditNote_Letter) . "%'");
            }
            if (!empty($request->filter_created_at)) {
                $filter_created_at = explode(" - ", $request->filter_created_at);
                $Select_db->whereRaw("CAST(lkp_company.created_at as date) between STR_TO_DATE('$filter_created_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_created_at[1]','%d/%m/%Y')");
            }
            if (!empty($request->filter_updated_at)) {
                $filter_updated_at = explode(" - ", $request->filter_updated_at);
                $Select_db->whereRaw("CAST(lkp_company.updated_at as date) between STR_TO_DATE('$filter_updated_at[0]','%d/%m/%Y') and STR_TO_DATE('$filter_updated_at[1]','%d/%m/%Y')");
            }

            return datatables()->of($Select_db)->make(true);
        }

        //$data = $Select_db->get();
        return view('new_porttal.Company.index')->with(compact('lkp_calculation_method'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lkp_calculation_method = DB::select('SELECT * from lkp_calculation_method ');
        return view('new_porttal.Company.create')->with(compact('lkp_calculation_method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::table('lkp_company')->insert(
            [
                'status' => $request->input('status'),
                'rent_check' => $request->input('rent_check'),
                'companyName' => $request->input('companyName'),
                'calculation_method_id' => $request->input('calculation_method_id'),
                'period_start' => $request->input('period_start'),
                'period_end' => $request->input('period_end'),
                'companyFullName_en' => $request->input('companyFullName_en'),
                'companyFullName_ar' => $request->input('companyFullName_ar'),
                'TaxNumber' => $request->input('TaxNumber'),
                'CreditNote_Letter' => $request->input('CreditNote_Letter'),
                'updatedby_id' => Auth::user()->id,
                'createdby_id' => Auth::user()->id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),

            ]
        );

        return redirect('/Company')->with('success', 'Done successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Company = DB::table('lkp_company')
            ->select('lkp_company.status', 'lkp_company.id as id', 'rent_check', 'companyName', 'calculation_method_id', 'calculation_method',
                'period_start', 'period_end', 'companyFullName_en', 'companyFullName_ar', 'TaxNumber', 'CreditNote_Letter',
                'created_users.name as created_users', 'updated_users.name as updated_users', 'lkp_company.created_at', 'lkp_company.updated_at'
            )
            ->leftJoin('lkp_calculation_method', 'lkp_company.calculation_method_id', '=', 'lkp_calculation_method.id')
            ->leftJoin('users as created_users', 'lkp_company.createdby_id', '=', 'created_users.id')
            ->leftJoin('users as updated_users', 'lkp_company.updatedby_id', '=', 'updated_users.id')
            ->where('lkp_company.id', $id)
            ->first();

        return view('new_porttal.Company.show')->with('Company', $Company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $lkp_calculation_method = DB::select('SELECT * from lkp_calculation_method ');

        $Company = DB::table('lkp_company')
            ->select('lkp_company.status', 'lkp_company.id as id', 'rent_check', 'companyName', 'calculation_method_id', 'calculation_method',
                'period_start', 'period_end', 'companyFullName_en', 'companyFullName_ar', 'TaxNumber', 'CreditNote_Letter',
                'created_users.name as created_users', 'updated_users.name as updated_users', 'lkp_company.created_at', 'lkp_company.updated_at'
            )
            ->leftJoin('lkp_calculation_method', 'lkp_company.calculation_method_id', '=', 'lkp_calculation_method.id')
            ->leftJoin('users as created_users', 'lkp_company.createdby_id', '=', 'created_users.id')
            ->leftJoin('users as updated_users', 'lkp_company.updatedby_id', '=', 'updated_users.id')
            ->where('lkp_company.id', $id)
            ->first();
        return view('new_porttal.Company.edit')->with(compact('Company'))->with(compact('lkp_calculation_method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('lkp_company')
            ->where('id', $id)
            ->update([
                'status' => $request->input('status'),
                'rent_check' => $request->input('rent_check'),
                'companyName' => $request->input('companyName'),
                'calculation_method_id' => $request->input('calculation_method_id'),
                'period_start' => $request->input('period_start'),
                'period_end' => $request->input('period_end'),
                'companyFullName_en' => $request->input('companyFullName_en'),
                'companyFullName_ar' => $request->input('companyFullName_ar'),
                'TaxNumber' => $request->input('TaxNumber'),
                'CreditNote_Letter' => $request->input('CreditNote_Letter'),
                'updatedby_id' => Auth::user()->id,
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        return redirect('/Company')->with('success', 'Done successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('lkp_company')->where('id', $id)->delete();

        return redirect('/Company')->with('success', 'Done successfully');
    }


    public function updatePaid($id)
    {

        $lkp_company = DB::select('SELECT fullName from lkp_company
        inner join drivers on drivers.id =lkp_company.driverId
        where lkp_company.id=' . $id)[0];
        return view('Company.updatePaid')->with(compact('id'))->with(compact('lkp_company'));
    }

    public function updatePaidSave(Request $request)
    {


        //$this->validate($request, [
//
        //   'paid_image' => 'required|image|mimes:jpeg,png,jpg,',
        //]);

        //if ($request->hasFile('paid_image')) {

        //    $filenameWithExtention = $request->file('paid_image')->getClientOriginalName();
        //$fileName = pathinfo($filenameWithExtention,PATHINFO_FILENAME);
        //    $extension = $request->file('paid_image')->getClientOriginalExtension();
        //   $fileNameStore = $request->input('lkp_company_id') . '.' . $extension;
        //    try {
        //        $path = $request->file('paid_image')->move(base_path() . '/public/doc/paid_image/', $fileNameStore);
        //   } catch (Exception $e) {
        //       return redirect('/Company')->with('error', $e->getMessage());
        //   }

        //}


        $Company = Company::find($request->input('lkp_company_id'));
        $Company->status_id = 4;
        //$Company->paid_image = $fileNameStore;
        $Company->save();

        $lkp_company = DB::select('SELECT * from lkp_company where lkp_company.id=' . $request->input('lkp_company_id'))[0];


        try {
            DB::insert("insert into journal (driverId,journal_date,debit,credit,note,journal_type_id,post_id,
        createdby_id,updatedby_id,created_at,updated_at)
        values
        (" . $lkp_company->driverId . ",'" . $lkp_company->journal_date . "'," . $lkp_company->amount . ",null,'" . $lkp_company->note . "',1," . $lkp_company->id . ",
        " . Auth::user()->id . "," . Auth::user()->id . ",'" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "'
        )");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/LoanPaid/' . $request->input('lkp_company_id'))->with('error', $e->getPrevious()->getMessage());
        }

        try {
            DB::update("UPDATE lkp_company
    JOIN journal  ON (lkp_company.id = journal.post_id and journal.journal_type_id=1)
    SET lkp_company.journal_id = journal.id
    where lkp_company.id =" . $request->input('lkp_company_id')
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/LoanPaid/' . $request->input('lkp_company_id'))->with('error', $e->getPrevious()->getMessage());
        }


        return redirect('/LoanPaid/' . $request->input('lkp_company_id'))->with('success', 'Done successfully');
    }
}
