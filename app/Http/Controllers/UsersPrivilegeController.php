<?php

namespace App\Http\Controllers;

use App\UsersMenu;
use App\UsersPrivilege;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class UsersPrivilegeController extends Controller
{
    protected $menu = 14;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {

        // return session('menu');
        $user = DB::select("select id,user_type_id,name from users where id=" . $id)[0];
        $lkp_privilege_type = DB::select('SELECT * from lkp_privilege_type');
        $UsersMenu = DB::table('warehouse')
            ->select('warehouse.id as id', 'warehouseName', 'companyId', 'companyName', 'cityId', 'name_en',
                'warehouse.created_at as created_at', 'privilage_type_id')
            ->leftJoin('lkp_company', 'warehouse.companyId', '=', 'lkp_company.id')
            ->leftJoin('lkp_city', 'warehouse.cityId', '=', 'lkp_city.id')
            ->leftJoin(DB::raw('(SELECT * FROM users_privilege where user_id=' . $id . ')users_privilege'),
                function ($join) {
                    $join->on('warehouse.id', '=', 'users_privilege.warehouseId');
                })
            ->orderBy('companyId', 'ASC')
            ->orderBy('cityId', 'ASC')
            ->orderBy('warehouseName', 'ASC')
            ->get();

        return view('UsersPrivilege.index')->with(compact('UsersMenu'))
            ->with(compact('lkp_privilege_type'))
            ->with(compact('user'));
    }

    public function store(Request $request)
    {
        try {
            $Users = DB::select("select user_type_id from users where id=" . $request->input("user_id"))[0];
            if ($Users->user_type_id == 3) {
                DB::table('users_privilege')->where('user_id', $request->input('user_id'))->delete();

                DB::insert("INSERT INTO users_privilege (user_id,warehouseId,privilage_type_id)
            VALUES (" . $request->input("user_id") . "," . $request->input("warehouseId") . "," . $request->input("privilage_type_id") . ")");
                //-------------------------------------------------------------------------------------------------
                $warehouse = DB::select("select companyId from warehouse where warehouse.id=" . $request->input("warehouseId"))[0];
                if ($warehouse->companyId == 6) $role_id = 7; else $role_id = 6;
                DB::update("update users set role_id=" . $role_id . " where users.id=" . $request->input('user_id'));
            } elseif ($Users->user_type_id == 2) {
                DB::table('users_privilege')->where('user_id', $request->input('user_id'))->delete();

                $UsersMenu = DB::select("select * from warehouse");
                $flag_jahiz = 0;
                $flag_no = 0;
                foreach ($UsersMenu as $User_Menu) {
                    if ($request->input("Read_$User_Menu->id") == '1' || $request->input("Full_$User_Menu->id")) {
                        if ($request->input("Full_$User_Menu->id") == "1") $privilage_type_id = "1";
                        elseif ($request->input("Read_$User_Menu->id") == '1') $privilage_type_id = "0";
                        DB::insert("INSERT INTO users_privilege (user_id,warehouseId,privilage_type_id)
                                     VALUES (" . $request->input("user_id") . "," . $User_Menu->id . "," . $privilage_type_id . ")");

                        //---------------------------------------------------------------------
                        if ($User_Menu->companyId == 6) $flag_jahiz = 3;
                        if ($User_Menu->companyId <> 6) $flag_no = 2;
                    }
                    $flag=0;
                    $flag = $flag_jahiz + $flag_no;
                    if ($flag == 3) $role_id = 7;
                    elseif ($flag == 2) $role_id = 6;
                    elseif ($flag == 5) $role_id = 8;
                    if ($flag==0)
                        DB::update("update users set role_id=null where users.id=" . $request->input('user_id'));
                    else
                        DB::update("update users set role_id=" . $role_id . " where users.id=" . $request->input('user_id'));
                }
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->index($request->input("user_id"))->with('error', $e->getPrevious()->getMessage());
        }
        return $this->index($request->input("user_id"))->with('success', 'Done successfully');

        //return redirect('/Supervisors')->with('success', 'Done successfully');


    }


}
