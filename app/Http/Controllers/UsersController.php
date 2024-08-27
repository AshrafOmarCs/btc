<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HelperFunctionsController;

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
    public function updateProfilePic(Request $request) {
        $profile_pic = AUTH::user()->id.'.'.$request->profile_pic->extension();
        $request->profile_pic->move(storage_path('app/public/images'), $profile_pic);
        User::where('id', AUTH::user()->id)
       ->update([
            'profile_pic' => $profile_pic
        ]);
        return redirect()->back()->with('success', 'Profile Pic updated successfully');
    }
    public function get_warehouses($id, $name)
    {
        $results = DB::select("SELECT lkp_company.companyName,warehouse.warehouseName,lkp_city.name_en,warehouse.id,users.allowed_warehouse_attendance FROM users_privilege JOIN warehouse ON warehouse.id=users_privilege.warehouseId JOIN lkp_company ON lkp_company.id=warehouse.companyId INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id INNER JOIN users ON users_privilege.user_id=users.id WHERE users_privilege.user_id='$id' AND lkp_company.id<> 6");
        return view('Users.assign_warehouses')->with(compact('results'))->with(compact('id'))->with(compact('name'));

    }
    public function updateUserWarehouses(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        if(isset($request->warehouses)) {
            $warehouses = implode(", ",$request->warehouses);
            $warehouses = '[' .  $warehouses . ']';
            DB::update("UPDATE users SET `allowed_warehouse_attendance` = '$warehouses' WHERE `id` = '$id'");
        } else {
            DB::update("UPDATE users SET `allowed_warehouse_attendance` = NULL WHERE `id` = '$id'");
        }
        $results = DB::select("SELECT lkp_company.companyName,warehouse.warehouseName,lkp_city.name_en,warehouse.id,users.allowed_warehouse_attendance FROM users_privilege JOIN warehouse ON warehouse.id=users_privilege.warehouseId JOIN lkp_company ON lkp_company.id=warehouse.companyId INNER JOIN lkp_city ON warehouse.cityId=lkp_city.id INNER JOIN users ON users_privilege.user_id=users.id WHERE users_privilege.user_id='$id' AND lkp_company.id<> 6");
        return view('Users.assign_warehouses')->with(compact('results'))->with(compact('id'))->with(compact('name'))->with('success', 'Warehouses assignment updated successfully');

    }



    public function index(Request $request)
    {


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
            else if ($request->filter_screenId == 'Supervisors') {
                $Select_db->whereRaw("users.user_type_id in(2,3)");
            }
            if ($request->filter_user_name != '') {
                $Select_db->whereRaw("UPPER(users.name) LIKE '%" . strtoupper($request->filter_user_name) . "%'");
            }
            if ($request->filter_phone != '') {
                $Select_db->whereRaw("UPPER(users.phone) LIKE '%" . $request->filter_phone . "%'");
            }
            if ($request->filter_email != '') {
                $Select_db->whereRaw("UPPER(users.email) LIKE '%" . strtoupper($request->filter_email) . "%'");
            }
            if ($request->filter_screenId == 'Users') {
                $Select_db->where('users.user_type_id', 1);
            }
            if ($request->filter_identityNo != '') {
                $Select_db->whereRaw("UPPER(users.IdentityNo) LIKE '%" . $request->filter_identityNo . "%'");
            }
            if ($request->filter_user_type != '') {
                $Select_db->whereRaw("UPPER(users.user_type_id) = " . $request->filter_user_type);
            }
            if ($request->filter_role_name != '') {
                $Select_db->whereRaw("UPPER(users.role_id) = " . $request->filter_role_name);
            }
            if ($request->filter_status != '') {
                $Select_db->whereRaw("UPPER(users.active_id) = " . $request->filter_status);
            }
            if ($request->filter_created_at != '') {
                $Select_db->whereRaw("users.created_at LIKE '%" . $request->filter_created_at . "%'");
            }
            if ($request->filter_updated_at != '') {
                $Select_db->whereRaw("users.updated_at LIKE '%" . $request->filter_updated_at . "%'");
            }
            // echo $Select_db->tosql();
            return datatables()->of($Select_db)->make(true);
        } //$data = $Select_db->get();
        elseif (Route::getFacadeRoot()->current()->uri() == 'New-Portal/Users')
            $view = "index";
        elseif (Route::getFacadeRoot()->current()->uri() == 'New-Portal/Supervisors')
            $view = "Supervisors";

        $lkp_user_type = DB::select("SELECT * FROM lkp_user_type");
        $lkp_active = DB::select("SELECT * FROM lkp_active");
        $roles = DB::select('SELECT id, role_name from users_role');

        return view('new_porttal.Users.' . $view)->with(compact('lkp_user_type'))->with(compact('lkp_active'))->with(compact('roles'));
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
        return view('new_porttal.Users.create')
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
            return redirect()->back()->with('success', 'Done successfully');
        if ($request->input('type_id') == 2)
            return redirect()->back()->with('success', 'Done successfully');
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
        return view('new_porttal.Users.show')->with('Users', $Users);
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
        return view('new_porttal.Users.edit')->with('Users', $Users)
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
            $action = "";
            $Users = User::find($id);
            if($Users->name != $request->input('name'))
                $action .= "name: " . $Users->name . " to " . $request->input('name') . ", ";
            $Users->name = $request->input('name');
            if($Users->email != $request->input('email'))
                $action .= "email: " . $Users->email . " to " . $request->input('email') . ", ";
            $Users->email = $request->input('email');
            if($Users->IdentityNo != $request->input('IdentityNo'))
                $action .= "IdentityNo: " . $Users->IdentityNo . " to " . $request->input('IdentityNo') . ", ";
            $Users->IdentityNo = $request->input('IdentityNo');
            if($Users->phone != $request->input('phone'))
                $action .= "phone: " . $Users->phone . " to " . $request->input('phone') . ", ";
            $Users->phone = $request->input('phone');
            if($Users->user_type_id != $request->input('user_type_id'))
                $action .= "user_type_id: " . $Users->user_type_id . " to " . $request->input('user_type_id') . ", ";
            $Users->user_type_id = $request->input('user_type_id');
            if($Users->active_id != $request->input('active_id'))
                $action .= "active_id: " . $Users->active_id . " to " . $request->input('active_id') . ", ";
            $Users->active_id = $request->input('active_id');
            if($Users->role_id != $request->input('role_id'))
                $action .= "role_id: " . $Users->role_id . " to " . $request->input('role_id') . ", ";
            $Users->role_id = $request->input('role_id');


            if (!empty($request->input('bank_id'))) {
                if($Users->bank_id != $request->input('bank_id'))
                    $action .= "bank_id: " . $Users->bank_id . " to " . $request->input('bank_id') . ", ";
                $Users->bank_id = $request->input('bank_id');
            }
            if (!empty($request->input('account_Number'))) {
                if($Users->account_Number != $request->input('account_Number'))
                    $action .= "account_Number: " . $Users->account_Number . " to " . $request->input('account_Number') . ", ";
                $Users->account_Number = $request->input('account_Number');
            }
            $Users->save();
            if ($action != '') {
                $made_by = Auth::user()->name;
                $msg = "<b>$made_by</b> updated the user ($id) with these changes : $action";
                HelperFunctionsController::add_log($msg, '', $id);
            }
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
        $made_by = Auth::user()->name;
        $msg = "<b>$made_by</b> deleted the user ($id)";
        HelperFunctionsController::add_log($msg, '', $id);
        return redirect()->back()->with('success', 'Done successfully');
    }

    public function ResetPass($id)
    {

        $User = DB::select('SELECT id,name from users where id=' . $id)[0];
        return view('new_porttal.Users.ResetPass')->with(compact('User'));
    }

    public function SaveResetPass(Request $request)
    {
        try {
            $id = $request->input('id');
            $Users = User::find($request->input('id'));
            $Users->password = bcrypt($request->input('password'));
            $Users->save();
            $made_by = Auth::user()->name;
            $msg = "<b>$made_by</b> updated the password of user ($id)";
            HelperFunctionsController::add_log($msg, '', $id);

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->ResetPass($request->input('id'))->with('error', $e->getPrevious()->getMessage());
        }
        return $this->ResetPass($request->input('id'))->with('success', 'Done successfully');
    }

    public function ChangePassword()
    {
        $User = DB::select('SELECT id,name from users where id=' . Auth::user()->id)[0];
        return view('new_porttal.Users.ChangePassword')->with(compact('User'));
    }

    public function ChangePasswordSave(Request $request)
    {
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        $check = password_validation_rule($password, $password_confirmation);
        if ($check == true) {
            try {
                $Users = User::find(Auth::user()->id);
                $Users->password = bcrypt($request->input('password'));
                $Users->save();
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('error', $e->getPrevious()->getMessage());
            }
            return redirect()->back()->with('success', 'Done successfully');
        } else {
            return redirect()->back()->with('error', 'Your Password does not matching the password criteria, ');
        }

    }
}

function password_validation_rule($password, $password_confirmation) {
    $minLength = 8;
    // password validations
    if (
        $password == $password_confirmation &&
        strlen($password) >= $minLength &&
        preg_match('/[a-z]/', $password) &&
        preg_match('/[A-Z]/', $password) &&
        preg_match('/\d/', $password) &&
        preg_match('/[!@#$%^&*()_+{}\[\]:;<>,.?\/~\\-]/', $password) &&
        !preg_match('/(.)\1\1/', $password) &&
        !preg_match('/(123|234|345|456|567|678|789|890|abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/', $password)
    ) {
        return true;
    }
    return false;
}
