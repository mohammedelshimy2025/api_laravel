<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Traits\genralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  use genralTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    // public function login(Request $request)
    // {
    //   try {
    //
    //
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);
    //
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
    //
    //     // Login
    //   $credentials = $request->only(['email' , 'password']);
    //   $token = Auth::guard('api')->attempt($credentials);
    //
    //   if(!$token)
    //     return $this->returnError('E001' , 'بيانات الدخول غير صحيحه');
    //     return $this->returnData('user' , $token);
    //
    //     return $this->respondWithToken($token);
    //
    //   } catch (\Exception $e) {
    //       return $this->returnError($e->getCode(), $e->getMessage());
    //   }
    // }


    // public function login(Request $request)
    //     {
    //         $validator = Validator::make($request->all(), [
    //             'email' => 'required|email',
    //             'password' => 'required|string|min:6',
    //         ]);
    //
    //         if ($validator->fails()) {
    //             return response()->json($validator->errors(), 422);
    //         }
    //
    //         $credentials = $request->only(['email' , 'password']);
    //         $token = Auth::guard('api')->attempt($credentials);
    //
    //         if (!$token)
    //             return response()->json(['error' => 'Unauthorized'], 401);
    //             return response()->json(['status' => true,'errNum' => "5000",'msg'=>$token ]);
    //
    //           return $this->respondWithToken('token is' , $token);
    //     }

    public function login(Request $request){

      $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required|string|min:6',
      ]);

      if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
      }

      if (!$token = Auth::guard('api')->attempt($validator->validated())) {
          return response()->json(['error' => 'Unauthorized'], 401);
      }

      return $this->respondWithToken($token);
  }



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }

    /**
         * Get the token array structure.
         *
         * @param  string $token
         *
         * @return \Illuminate\Http\JsonResponse
         */
    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }



}
