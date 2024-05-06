<?php

namespace App\Http\Controllers;

use App\Drivers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersRoleController extends Controller
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
        if (request()->ajax()) {
            $Select_db = DB::table('users_role')
                ->select('users_role.id as id', 'role_name', 'users_role.active_id', 'active_status', 'created_at', 'updated_at')
                ->leftJoin('lkp_active', 'users_role.active_id', '=', 'lkp_active.id');


            return datatables()->of($Select_db)->make(true);
        }
        //$data = $Select_db->get();
        return view('UsersRole.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $lkp_active = DB::select('SELECT * from lkp_active where id in(0,1)');
        return view('UsersRole.create')->with(compact('lkp_active'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role_name' => ['required', 'string', 'max:255'],
        ]);

        DB::table('users_role')->insert(
            [
                'role_name' => $request->input('role_name'),
                'active_id' => $request->input('active_id'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),

            ]
        );

        return redirect('/UsersRole')->with('success', 'Done successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Select_db = DB::table('UsersRole')
            ->select('UsersRole.id as id', 'UsersRole.name as name', 'IdentityNo', 'phone', 'email', 'created_at',
                'user_type_id', 'lkp_user_type.user_type as user_type_name', 'active_id', 'active_status', 'bank_id', 'bank_name_en', 'account_Number')
            ->leftJoin('lkp_user_type', 'UsersRole.user_type_id', '=', 'lkp_user_type.id')
            ->leftJoin('lkp_active', 'UsersRole.active_id', '=', 'lkp_active.id')
            ->leftJoin('lkp_bank', 'UsersRole.bank_id', '=', 'lkp_bank.id')
            ->where('UsersRole.id', $id);
        $UsersRole = $Select_db->first();
        return view('UsersRole.show')->with('UsersRole', $UsersRole);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lkp_active = DB::select('SELECT * from lkp_active where id in(0,1)');
        $UsersRole = DB::select(DB::raw('SELECT * from users_role where id=' . $id))[0];
        return view('UsersRole.edit')->with(compact('UsersRole'))
            ->with(compact('lkp_active'));
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

        //'password' => ['required', 'string', 'min:8', 'confirmed'],
        $this->validate($request, [
            'role_name' => ['required', 'string', 'max:255'],
        ]);
        try {
            DB::table('users_role')
                ->where('id', $id)
                ->update([
                    'role_name' => $request->input('role_name'),
                    'active_id' => $request->input('active_id'),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->edit($id)->with('error', $e->getPrevious()->getMessage());
        }
        return $this->edit($id)->with('success', 'Done successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('users_role')->where('id', '=', $id)->delete();

        return redirect('/UsersRole')->with('success', 'Done successfully');
    }


    public function UsersRolePrivilage($role_id)
    {
        $users_role = DB::select(DB::raw('SELECT * from users_role where id=' . $role_id))[0];
        $UsersMenu = DB::table('lkp_menu')
            ->select('lkp_menu.*', 'users_role_privilege.read as read',
                'users_role_privilege.create as create',
                'users_role_privilege.update as update',
                'users_role_privilege.delete as delete',
                'users_role_privilege.post as post')
            ->leftJoin(DB::raw('(SELECT * FROM users_role_privilege where role_id=' . $role_id . ')
        users_role_privilege'),
                function ($join) {
                    $join->on('lkp_menu.id', '=', 'users_role_privilege.menu_id');
                })
            ->orderBy('lkp_menu.id', 'ASC')
            ->get();

        //return $UsersMenu->toSql();
        // $UsersMenu = UsersMenu::all();
        return view('UsersRole.UsersRolePrivilage')->with(compact('UsersMenu'))->with(compact('users_role'));
    }

    public function UsersRolePrivilageSave(Request $request)
    {

        DB::table('users_role_privilege')->where('role_id', $request->input('role_id'))->delete();

        try {
            $UsersMenu = DB::select(" select * from lkp_menu");
            foreach ($UsersMenu as $User_Menu) {

                if ($request->input("Read_$User_Menu->id") == '1' || $request->input("Create_$User_Menu->id") == '1' || $request->input("Update_$User_Menu->id") == '1' || $request->input("Delete_$User_Menu->id") == '1'|| $request->input("Post_$User_Menu->id") == '1') {
                    DB::table('users_role_privilege')->insert(
                        [
                            'role_id' => $request->input('role_id'),
                            'menu_id' => $User_Menu->id,
                            'read' => $request->input("Read_$User_Menu->id"),
                            'create' => $request->input("Create_$User_Menu->id"),
                            'update' => $request->input("Update_$User_Menu->id"),
                            'delete' => $request->input("Delete_$User_Menu->id"),
                            'post' => $request->input("Post_$User_Menu->id"),
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),

                        ]
                    );


                }
            }


        } catch (\Illuminate\Database\QueryException $e) {
            return $this->UsersRolePrivilage($request->input('role_id'))->with('error', $e->getPrevious()->getMessage());
        }
        return $this->UsersRolePrivilage($request->input('role_id'))->with('success', 'Done successfully');
    }
}
