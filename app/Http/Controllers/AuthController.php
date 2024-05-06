<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Drivers;
use Validator;
use JWTAuth;
class AuthController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function testtest()
    {
        # code...
        return 'ghg hgh';
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'iqama' => 'required|email',
            'job_id' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);



        //  dd($validator->validated());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try {
            $user = Drivers::where([
                ['iqama',$request->identity],
                ['job_id',$request->job_id]
            ])->get();
            if(count($user)>0){
                $user = $user->first(); 
                $token = JWTAuth::fromUser($user); 
                // dd($token);
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => 1* 60,
                    'user' => $user
                ]);
                // return $this->createNewToken($token);
                
            }
            
            // $token = JWTAuth::attempt($validator->validated());
            // list($header, $payload, $signature) = explode('.', $token);
            // $jsonToken = base64_decode($payload);
            // $arrayToken = json_decode($jsonToken, true);
            // dd($jsonToken);
            // $res = response()->json(['status' => 'success','token' => $token], 200);
            // dd($token); 
        } catch(Exception $e){
            return response()->json(['error' => $e], 401);
        }
        // dd(Auth::guard('api')->attempt($validator->validated()));
        if (! $token = Auth::guard('jwt')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    public function userProfile() {
        // dd('kkk');
        return response()->json(auth()->user());
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }






}
