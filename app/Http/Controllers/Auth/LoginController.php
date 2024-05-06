<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Otp_code;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    } 
    public function login(Request $request)
    {
        
        $this->validateLogin($request);
      
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        
       
        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted(); 
            
            $dots_phone_number = "5*****".$user->phone[6]."".$user->phone[7]."".$user->phone[8];
            // dd($dots_phone_number);
            $user_payload = array("email"=>$user->email,"phone"=>$user->phone,"password"=>$request->password,'dots_phone_number'=>$dots_phone_number,'msg'=>null);
            $user1 = User::where('email',$request->email)->get();
            
            // if(!isset($request->otp_code)){ 
            //     // send sms msg here 
            //     $this->send_sms($user1,$request->getClientIp());
            //     return view('otp',compact('user_payload'));
            // }else{ 
            //     // check the code and iqama ; 
            //     $check_if_exist = Otp_code::where([
            //         ['user_id',$user1[0]->id],
            //         ['code',$request->otp_code]
            //     ])->get();
            //     if(count($check_if_exist)>0){
            //         if($user1[0]->IdentityNo != $request->identity_no){
            //             // return error
            //             // faild attemp
            //             $user_payload['msg'] = 'Identity not matched out records check you identity ';
            //             return view('otp',compact('user_payload'));
            //         }
            //     }else{
            //         // return error 
            //         $user_payload['msg'] = 'Please check OTP code ';
                     
            //         return view('otp',compact('user_payload'));
            //     }
            // }
            
            // Make sure the user is active
            if ($user->active_id == 1 && $this->attemptLogin($request)) {
                //session(['variableName'=>'atifaaa']);
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'You must be active to login.']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    //*******************************************************************************************
    function authenticated(Request $request, $user)
    {
        // dd($user);
        DB::table('users_login')->insert(
            [
                'user_id' => $user->id,
                'ip' => $request->getClientIp(),
                'dt' => date("Y-m-d H:i:s"), 
            ]
        );
        $users_privilege = DB::select('SELECT user_id,warehouseId,companyId from users_privilege
        inner join warehouse on warehouse.id=users_privilege.warehouseId
        where user_id=' . $user->id);
        foreach ($users_privilege as $users_privilegee) {
            if ($users_privilegee->companyId == 6) {
                session(['Session_DriversJahiz' => 'yes']);
            }
            elseif ($users_privilegee->companyId == 8) {
                session(['Session_DriversCarrefour' => 'yes']);
            }
            else
                session(['Session_Drivers' => 'yes']);

        }
        //***********************************************************************************************************************
        //***********************************************************************************************************************
        $users_role_privilege = DB::select('select lkp_menu.id as menu_id,group_name,menu_name,
                    `read`,`create`,`update`,users_role_privilege.`delete`,`post`
                    from lkp_menu
                    inner JOIN users_role_privilege  on lkp_menu.id=users_role_privilege.menu_id
                    inner join users_role on users_role.id=users_role_privilege.role_id
                    INNER JOIN users on users.role_id=users_role_privilege.role_id
                    where users_role.active_id=1
                    And users.id=' . $user->id);
        foreach ($users_role_privilege as $users_role_privilegee) {

            if ($users_role_privilegee->read == 1)
                session(['Read_' . $users_role_privilegee->menu_id => '1']);
            if ($users_role_privilegee->create == 1)
                session(['Create_' . $users_role_privilegee->menu_id => '1']);
            if ($users_role_privilegee->update == 1)
                session(['Update_' . $users_role_privilegee->menu_id => '1']);
            if ($users_role_privilegee->delete == 1)
                session(['Delete_' . $users_role_privilegee->menu_id => '1']);
            if ($users_role_privilegee->post == 1)
                session(['Post_' . $users_role_privilegee->menu_id => '1']);


        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->flush();
        return redirect('/login');
    }
    protected function guard()
    {
        return Auth::guard('web');
    }
    public function send_sms($data,$ip){ 
        $code = $this->generateNumericOTP(6); 
        $recp_name = explode(" ", $data[0]->name); 
        $recp_name = $recp_name[0];
        // dd($recp_name);
        // $this->generateNumericOTP(4); 
        $date=date("Y-m-d");
        $otp_res = Otp_code::where("user_id",$data[0]->id) ->orWhere('created_at','like',"%{$date}%")->get();  
        Otp_code::create([
            "code"=>$code,
            "user_id"=>$data[0]->id,
            "ip_addess"=>$ip
        ]);
        $data = array(
            "api_id" => "API85085034640",
            "api_password" =>"As@050987",
            "sms_type" => "T",
            "encoding" => "U",
            "sender_id" => "BTC.sa",
            "phonenumber" => "966".$data[0]->phone,
            "templateid" => "1973",
            "V1"=>$recp_name,
            "V2"=>$code
          );  
          $data_string = json_encode($data); 
          $ch =
          curl_init('http://api.smsala.com/api/SendSMS');
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($data_string))
          );
          $result = curl_exec($ch);
        //   dd($result); 
    }
     
// Function to generate OTP
public function generateNumericOTP($n) {
      
    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468"; 
    $result = ""; 
    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    } 
    // Return result
    return $result;
} 
}
