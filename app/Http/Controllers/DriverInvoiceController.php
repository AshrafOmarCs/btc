<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax())
        {
            $driverInvoice=DB::table('driver_invoices')
                ->leftJoin('users','driver_invoices.user_id','=','users.id')
                ->leftJoin('drivers','driver_invoices.driver_id','=','drivers.id')
                ->leftJoin('warehouse','drivers.warehouseId','=','warehouse.id')
                ->leftJoin('lkp_company','warehouse.companyId','=','lkp_company.id')
                ->leftJoin('lkp_invoice_description','driver_invoices.description_id','=','lkp_invoice_description.id')
                ->select('drivers.id as driverId','users.id as userId','warehouse.id as warehouseId','lkp_company.id as companyId','warehouseName','lkp_company.companyName','users.name','driver_invoices.companyName as invoiceCompany','drivers.fullName','vatNumber','invoiceNumber','amount','date','description_en','description_ar','driver_invoices.created_at')
                ->orderBy('driver_invoices.id','DESC');

            return datatables()->of($driverInvoice)
                ->make(true);

        }
        return view('DriverInvoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
