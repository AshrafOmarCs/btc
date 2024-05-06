<?php

namespace App\Http\Controllers;

use App\Drivers;
use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
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
        // dd($request->all());
        if (request()->ajax()) {
            $Select_db = DB::table('users')
                ->select('users.id as id', 'users.name as name', 'IdentityNo', 'phone', 'email', 'users.created_at',
                    'user_type_id', 'lkp_user_type.user_type as user_type', 'users.active_id', 'lkp_active.active_status', 'role_name',
                    DB::raw("GROUP_CONCAT(CONCAT(warehouseName,' ',privilege_type) SEPARATOR ', ') as warehouses")
                )
                ->leftJoin('lkp_user_type', 'users.user_type_id', '=', 'lkp_user_type.id')
                ->leftJoin('lkp_active', 'users.active_id', '=', 'lkp_active.id')
                ->leftJoin('users_privilege', 'users_privilege.user_id', '=', 'users.id')
                ->leftJoin('lkp_privilege_type', 'lkp_privilege_type.id', '=', 'users_privilege.privilage_type_id')
                ->leftJoin('warehouse', 'warehouse.id', '=', 'users_privilege.warehouseId')
                ->leftJoin('users_role', 'users_role.id', '=', 'users.role_id')
                ->groupBy('users.id', 'users.name', 'IdentityNo', 'phone', 'email', 'users.created_at', 'user_type_id',
                    'lkp_user_type.user_type', 'users.active_id', 'active_status');

            if ($request->filter_screenId == 'Users') {
                $Select_db->where('users.user_type_id', 1);
            }
            if ($request->filter_screenId == 'Supervisors') {
                $Select_db->whereRaw("users.user_type_id in(2,3)");
            }
            return datatables()->of($Select_db)->make(true);
        } //$data = $Select_db->get();


        elseif (Route::getFacadeRoot()->current()->uri() == 'Users')
            $view = "index";
        elseif (Route::getFacadeRoot()->current()->uri() == 'Supervisors')
            $view = "Supervisors";
        return view('Users.' . $view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type_id)
    {
        if ($type_id == 2)
            $lkp_user_type = DB::select('SELECT * from lkp_user_type where id in(2,3) order by id desc');
        else
            $lkp_user_type = DB::select('SELECT * from lkp_user_type where id=1');

        $users_role = DB::select('SELECT id,role_name from users_role order by role_name');

        $lkp_bank = DB::select('SELECT * from lkp_bank');
        $lkp_active = DB::select('SELECT * from lkp_active');
        return view('Users.create')
            ->with(compact('lkp_bank'))
            ->with(compact('lkp_user_type'))
            ->with(compact('lkp_active'))
            ->with(compact('users_role'))
            ->with(compact('type_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],


        ]);

        $Users = new User;
        $Users->name = $request->input('name');
        $Users->email = $request->input('email');
        $Users->IdentityNo = $request->input('IdentityNo');
        $Users->phone = $request->input('phone');
        $Users->user_type_id = $request->input('user_type_id');
        $Users->active_id = $request->input('active_id');
        $Users->role_id = $request->input('role_id');
        $Users->password = bcrypt($request->input('password'));
        if (!empty($request->input('bank_id')))
            $Users->bank_id = $request->input('bank_id');
        if (!empty($request->input('account_Number')))
            $Users->account_Number = $request->input('account_Number');

        $Users->save();

        if ($request->input('type_id') == 1)
            return redirect('/Users')->with('success', 'Done successfully');
        if ($request->input('type_id') == 2)
            return redirect('/Supervisors')->with('success', 'Done successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Select_db = DB::table('users')
            ->select('users.id as id', 'users.name as name', 'IdentityNo', 'phone', 'email', 'created_at',
                'user_type_id', 'lkp_user_type.user_type as user_type_name', 'active_id', 'active_status', 'bank_id', 'bank_name_en', 'account_Number')
            ->leftJoin('lkp_user_type', 'users.user_type_id', '=', 'lkp_user_type.id')
            ->leftJoin('lkp_active', 'users.active_id', '=', 'lkp_active.id')
            ->leftJoin('lkp_bank', 'users.bank_id', '=', 'lkp_bank.id')
            ->where('users.id', $id);
        $Users = $Select_db->first();
        return view('Users.show')->with('Users', $Users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type_id)
    {
        if ($type_id == 2)
            $lkp_user_type = DB::select('SELECT * from lkp_user_type where id in(2,3) order by id desc');
        else
            $lkp_user_type = DB::select('SELECT * from lkp_user_type where id=1');

        $users_role = DB::select('SELECT id,role_name from users_role order by role_name');

        $lkp_bank = DB::select('SELECT * from lkp_bank');
        $lkp_active = DB::select('SELECT * from lkp_active');
        $Users = DB::select(DB::raw('SELECT * from users where id=' . $id))[0];
        return view('Users.edit')->with('Users', $Users)
            ->with(compact('lkp_bank'))
            ->with(compact('lkp_user_type'))
            ->with(compact('lkp_active'))
            ->with(compact('users_role'))
            ->with(compact('type_id'));;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',],

        ]);
        try {
            $Users = User::find($id);
            $Users->name = $request->input('name');
            $Users->email = $request->input('email');
            $Users->IdentityNo = $request->input('IdentityNo');
            $Users->phone = $request->input('phone');
            $Users->user_type_id = $request->input('user_type_id');
            $Users->active_id = $request->input('active_id');
            $Users->role_id = $request->input('role_id');

            if (!empty($request->input('bank_id')))
                $Users->bank_id = $request->input('bank_id');
            if (!empty($request->input('account_Number')))
                $Users->account_Number = $request->input('account_Number');

            $Users->save();

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->edit($id, $request->input('type_id'))->with('error', $e->getPrevious()->getMessage());
        }
        return $this->edit($id, $request->input('type_id'))->with('success', 'Done successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Users = User::find($id);
        // if(auth()->user()->id !== $Users->user_id){
        //    return redirect('/Users')->with('error','Unauthorized');
        // }

        if ($Users->logo != 'noImage.jpg') {
            Storage::delete('public/app/storage' . $Users->logo);
        }
        $Users->delete();

        return redirect('/Users')->with('success', 'Done successfully');
    }

    public function ResetPass($id)
    {

        $User = DB::select('SELECT id,name from users where id=' . $id)[0];
        return view('Users.ResetPass')->with(compact('User'));
    }

    public function SaveResetPass(Request $request)
    {
        try {
            $Users = User::find($request->input('id'));
            $Users->password = bcrypt($request->input('password'));
            $Users->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->ResetPass($request->input('id'))->with('error', $e->getPrevious()->getMessage());
        }
        return $this->ResetPass($request->input('id'))->with('success', 'Done successfully');


    }

    public function ChangePassword()
    {

        $User = DB::select('SELECT id,name from users where id=' . Auth::user()->id)[0];
        return view('Users.ChangePassword')->with(compact('User'));
    }

    public function ChangePasswordSave(Request $request)
    {
        try {
            $Users = User::find(Auth::user()->id);
            $Users->password = bcrypt($request->input('password'));
            $Users->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/ChangePassword')->with('error', $e->getPrevious()->getMessage());
        }
        return redirect('/ChangePassword')->with('success', 'Done successfully');


    }
}
