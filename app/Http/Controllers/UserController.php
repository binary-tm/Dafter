<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\customerResorse;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\stdResorse;
use App\Http\Resources\userResource;

use App\Models\customer;
use App\Models\money_customer;
use App\Models\supplier;
use App\Models\resetpassword;
use App\Models\std_std;
use App\Models\users;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Mail\sendcoderesetPassword;
use App\Models\money_supplier;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
   

    public function regester(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Ensure the email is unique
            'password' => 'required|min:6',
            'notification_id' => 'required|string',
        ]);
        
        $existingUser = users::where('email', $request->email)->first();
    
        if ($existingUser) {
            return Common::apiResponse(0,__('validation.emailexists'),  $emailexists =1 ,404);
         
        }
    
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'notification_id' => $request->notification_id ?? null,
        ];
    
        $newUser = users::create($userData);
        $newUser['token'] = $newUser->createToken('dafter')->plainTextToken;

        if (!$newUser) {
        
            return Common::apiResponse(0,__('validation.register_failed'),  $regestersuccess = 0 ,500);
        }
        return Common::apiResponse(1,__('validation.regestersuccess'),  new userResource($newUser) ,200);

    }


    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = Users::where('email', $request->email)->first();

        if (!$user) {
            return Common::apiResponse(0,__('validation.user_not_exit'), null,404);

        }

        if (Hash::check($request->password, $user->password)) {
            if ($request->filled('notification_id')) {
                $user->update(['notification_id' => $request->notification_id]);
            }
            $user['token'] = $user->createToken('dafter')->plainTextToken;
            return Common::apiResponse(1,__('validation.login_success'), new UserResource($user),200);
        }
        return Common::apiResponse(0,__('validation.login_failed'), null,404);

    }



        public function resetpassword(Request $request){

            $request->validate([
                'email' => 'required|email',
            ]);
            $user = Users::where('email', $request->email)->first();
            if (!$user) {
                return Common::apiResponse(0, __('validation.login_failed'), null, 404);
            }
        
            $token = rand(1000, 9999);
            $resetPasswordData = ResetPassword::create([
                'id_user' => $user->id,
                'code_' => Hash::make($token),
            ]);
        
            if ($resetPasswordData) {
                $email = $request->email;
                // Mail::to($email)->send(new SendCodeResetPassword($email, $token));
                $data=[ 'success' => true,'registered' => true, 'email_exists' => true];
                return Common::apiResponse(1, __('validation.masseg_send_code'), $data, 200);

            }
        
            return Common::apiResponse(0, __('validation.unexpected_error'), null, 500);
        }





    public function valdatecode(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string', 
        ]);
    
        $userInfo = Users::where('email', $request->email)->first();
    
        if (!$userInfo) {
            return Common::apiResponse(0, __('validation.user_not_found'), null, 404);
        }
    
        $userInfoReset = ResetPassword::where('id_user', $userInfo->id)->first();
    
        if (!$userInfoReset) {
            return Common::apiResponse(0, __(key: 'validation.reset_code_not_found'), null, 404);
        }
        if (Hash::check($request->code, $userInfoReset->code_)) {
            return response()->json([
                'data' => UserResource::collection($userInfo),
                'stat' => ['codeExists' => true],
            ], 200);
        }
        return Common::apiResponse(0, __('validation.invalid_reset_code'), null, 404);


 


    }


    public function setNewPassword(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:users,id', // Ensures the user ID exists in the database
            'password' => 'required|string|min:6', // Minimum password length for security
        ]);
    
        $userInfo = Users::find($request->id);
    
        if (!$userInfo) {
            return Common::apiResponse(0, __('validation.user_not_found'), null, 404);
        }
        $userInfo->update(['password_' => Hash::make($request->password)]); // Use Hash::make for security
        return Common::apiResponse(0, __('validation.success'), UserResource::collection($userInfo), 200);

    }


    public function set_notification_id(Request $request){

      $add=  users::where('id',$request->user_id)->update([
            'notification_id'=>$request->notification_id
        ]);

        if(!$add){
            $AddSuccess=false;
            return response()->json(['message' => trans('404') , 'stat' => compact('AddSuccess')], 404);
        }else{
            return response()->json(['message' => trans('200') , 'stat' => compact('AddSuccess')], 200);

        }

    }


    public function transactions(Request $request){

         $id_user=auth()->user()->id;
         $total_customer=customer::where('id_user',$id_user)->count();
         $total_supplier=supplier::where('id_user',$id_user)->count();
         $total_money_supplier=money_supplier::where('id_user',$id_user)->sum('mone_cunt');
         $total_money_customer=money_customer::where('id_user',$id_user)->sum('mone_cunt');

         dd($total_customer,$total_supplier,$total_money_customer,$total_money_supplier );
    }

    


}


