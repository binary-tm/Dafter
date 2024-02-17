<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\customerResorse;
use App\Http\Resources\stdResorse;
use App\Http\Resources\userResource;

use App\Models\customer;
use App\Models\moared;
use App\Models\resetpassword;
use App\Models\std_std;
use App\Models\users;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Mail\sendcoderesetPassword;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\JsonResponse;

class user extends Controller
{
   

    public function regester(Request $request)
    {


    

        $regestersuccess='';
        $emailexets='';
        $users = users::where('email', $request->email)->get();

        # check if email is more than 1

        if(sizeof($users) > 0){
            # tell user not to duplicate same email
            $emailexets=true;
            return response()->json(['message' => trans('response.failed'),compact('emailexets')], 444);
            
        }


   

       
   


        $data= users::create(
            [
                 'name' => $request->name,
                 'email' => $request->email,
                 'password_' =>Hash::make( $request->password ),
                 'notification_id'=>$request->notification_id??null,
                 
                
             ]);



        if (!$data->save()) {
            $regestersuccess=false;
            return response()->json(['message' => trans('regester.failed'),compact('regestersuccess')], 444);

        }



        $data->save();
        $regestersuccess=true;

        
        return response()->json(['data' => 
        userResource::collection(users::where('email', '=', $request->email,)->get()) 
        ,'stat' => compact('regestersuccess')], 200);






    }











    public function login(Request $request)
    {



     


                $loginsuccess='';
                $request->validate([

                    'email' => 'required',
                    'password' => 'required',
                ]);

                $userinfo = users::where('email', '=', $request->email)->first();

                if (!$userinfo) {

                            return response()->json(['message' => trans('nooo')], 404);
                }else{

                    if (Hash::check($request->password, $userinfo->password_)) {
       
                        if(isset($request->notification_id)){
                            users::where('email',$request->email)->update([
                                'notification_id'=>$request->notification_id
                            ]);
                        }

                        $loginsuccess=true;
                        return response()->json(['data' => 
                        userResource::collection(users::where('email', '=', $request->email,)->get()) 
                        , 'stat' => compact('loginsuccess')], 200);


                    } else {
                        $loginsuccess=false;

                        return response()->json(['message' => trans('411111') , 'stat' => compact('loginsuccess')], 404);
                    }
                
                }


 


    }



        public function resetpassword(Request $request){

            $userinfo = users::where('email', '=', $request->email)->first();
            if (!$userinfo) {

                return response()->json(['message' => trans('nooo')], 404);
            }else{


                    $token =rand(1000,9999);



        $data= resetpassword::create(
            [
                 'id_user' => $userinfo->id,
                 'code_' =>Hash::make( $token ),
             
                 
                
             ]);

                    
                    
                    if ($data) {
                        
                        $email=$request->email;
                        $code=rand(1000, 9999);
                    Mail::to($email)->send(new sendcoderesetPassword($email ,$code));
                        return new JsonResponse(
                            [

                                'success' => true, 
                                'regester' => true, 
                                'emailexets' => false, 
                                'message' => "Thank you for subscribing to our email, please check your inbox"
                            , 
                            // userResource::collection(users::where('email', '=', $request->email,)->get()) 
                        ],
                            200);
                    }


            }

        }





    public function valdatecode(Request $request)
    {



     


         
                $userinfo = users::where('email', '=', $request->email)->first();
                $userinfo_reset = resetpassword::where('id_user' ,'=' ,$userinfo->id)->first();

                if (!$userinfo || !$userinfo_reset) {

                            return response()->json(['message' => trans('no')], 404);
                }else{

                    if (Hash::check($request->code, $userinfo_reset->code)) {


       
                        // users::where('id', '=', $userinfo->id)->where('email', '=', $userinfo->email)->update(
                        //     [
                        //         'password_' => $request->password,
                        //     ]);
                        $codeexet=true;
                        return response()->json(['data' => 
                        userResource::collection(users::where('email', '=', $request->email,)->get()) 
                        , 'stat' => compact('codeexet')], 200);

                    } else {
                        $resetepass=false;

                        return response()->json(['message' => trans('411111') , 'stat' => compact('resetepass')], 404);
                    }
                
                }


 


    }


    public function setNewPassword(Request $request)
    {

        $userinfo = users::where('id', '=', $request->id)->first();

        if (!$userinfo ) {

            return response()->json(['message' => trans('no')], 404);


            }else{

                users::where('id', '=', $userinfo->id)->where('email', '=', $userinfo->email)->update(
                    [
                        'password_' => $request->password,
                    ]);

                    $resetepass=true;
                    return response()->json(['data' => 
                    userResource::collection(users::where('email', '=', $request->email,)->get()) 
                    , 'stat' => compact('resetepass')], 200);
                
            }
    }




    public function serch_cus(Request $request)
    {

        $serch =$request->serch;
        $item =$request->item;
        $id_user = $request->id;

 
          


        switch ($serch) {
            case 'name':
              

                      return  customerResorse::collection( customer::where('name', 'LIKE', "%{$item}%")->where('id', '=', "%{$id_user}%")->get());

                break;


            case 'phone':
                    
                    return  customerResorse::collection( customer::where('phone', 'LIKE', "%{$item}%")->where('id', '=', "%{$id_user}%")->get());




                    break;
              

    }



    }



    public function serch_mor(Request $request)
    {

        $serch =$request->serch;
        $item =$request->item;
        $id_user = $request->id;


        


        switch ($serch) {
            case 'name':
            

                    return  customerResorse::collection( moared::where('name', 'LIKE', "%{$item}%")->where('id', '=', "%{$id_user}%")->get());

                break;


            case 'phone':
                    
                    return  customerResorse::collection( moared::where('phone', 'LIKE', "%{$item}%")->where('id', '=', "%{$id_user}%")->get());




                    break;
            

    }



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


}


