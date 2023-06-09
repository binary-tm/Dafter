<?php

namespace App\Http\Controllers;

use App\Http\Resources\customer as ResourcesCustomer;
use App\Models\cus_reimbursement;
use App\Models\customer as ModelsCustomer;
use App\Models\money_customer;
use Illuminate\Http\Request;
use App\Http\Resources\monResorse;

use Illuminate\Validation\Rule;
use Validator;
use App\Http\Resources\riminsResorse;
class customer extends Controller
{
    
    public function addcust(Request $request)
    {


      
        $regestersuccess='';
        $phoneExets='';
        $datadontsave='';

        $users = ModelsCustomer::where('phone', $request->phone)->first();

        # check if email is more than 1

        if( $users){
            # tell user not to duplicate same email
            $phoneExets=true;
            $regestersuccess=false; 
            $datadontsave=false;

            return response()->json(['message' => trans('response.failed'),'stat' => compact('phoneExets','regestersuccess','datadontsave')], 444);
            
        }

        $data= ModelsCustomer::create(
            [
                 'name' => $request->name,
                 'date_' => $request->date_,
                 'address' => $request->address,
                 'phone' => $request->phone,
                 'id_user' => $request->id_user ,
             
                 
                
             ]);



        if (!$data->save()) {
            $regestersuccess=false;
            $phoneExets=false;
            $datadontsave=true;
            return response()->json(['message' => trans('regester.failed'),'stat' => compact('regestersuccess','phoneExets','datadontsave')], 444);

        }

        $data->save();
        $regestersuccess=true; 
         $phoneExets=false;
        $datadontsave=false;

        return response()->json(['data' => 
        ResourcesCustomer::collection(ModelsCustomer::where('phone', $request->phone)->latest()->get()) 
        ,'stat' => compact('regestersuccess','phoneExets','datadontsave')], 200);






    }


    public function addmoney(Request $request)
    {


    
 
        $data= money_customer::create(
            [
                 'id_custmer' => $request->id_custmer,
                 'detels' => $request->detels,
                 'id_user' => $request->id_user,
                 'mone_cunt' => $request->mone_cunt,

             
                 
                
             ]);



        if (!$data->save()) {
            $regestersuccess=false;
            return response()->json(['message' => trans('regester.failed'),'stat' => compact('regestersuccess')], 444);

        }

        $data->save();

        $reimbursement=  cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
             



      $m=  money_customer::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
             
        return response()->json(['data' => 
        ResourcesCustomer::collection(money_customer::where('id_custmer', '=', $request->id_custmer,)->get()) ,
        'reimbursement' => 
        ResourcesCustomer::collection(cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->get()) 
      
        ,'stat' => compact('m','reimbursement')], 200);






    }
  

    public function reimbursement(Request $request)
    {


    
 
        $data= cus_reimbursement::create(
            [
                 'id_custmer' => $request->id_custmer,
                 'detels' => $request->detels,
                 'id_user' => $request->id_user,
                 'mone_proses' => $request->mone_proses,

             
                 
                
             ]);



        if (!$data->save()) {
            $regestersuccess=false;
            return response()->json(['message' => trans('regester.failed'), 'stat' => compact('regestersuccess')], 444);

        }

        $data->save();

      $reimbursement=  cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
      $m=  money_customer::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
        return response()->json(['data' => 
        ResourcesCustomer::collection(money_customer::where('id_custmer', '=', $request->id_custmer,)->get()) ,
        'reimbursement' => 
        ResourcesCustomer::collection(cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->get()) 
        
        ,'stat' => compact('m','reimbursement')], 200);






    }






    public function delet_cus(Request $request){  


                $id_custmer=$request->id_custmer;
                $delet_user='';
                       $delet_1= money_customer::where('id_custmer', '=', $request->id_custmer,)->delete();
                         $delet_2=   cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->delete();
                       
                $delet=  ModelsCustomer::where('id', $id_custmer)->delete();
                if(!$delet){
                     $delet_user=false;        
                                return response()->json(['data' => compact('delet_user') ], 200);
                    
                }
                $delet_user=true;        
                return response()->json(['data' => compact('delet_user') ], 200);
                
               
    }


    public function delet_cus_mon(Request $request){  

$delet_user=''; 
        $id_pro=$request->id_m;
        $id_custmer=$request->id_custmer;
       $delet= money_customer::where('id', $id_pro)->where('id_custmer', '=', $request->id_custmer,)->delete();
                        if(!$delet){
                     $delet_user=false;        
                                return response()->json(['data' => compact('delet_user') ], 200);
                    
                }
                
                $delet_user=true; 
        $reimbursement=  cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
        $m=  money_customer::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
          return response()->json(['data' => 
          ResourcesCustomer::collection(money_customer::where('id_custmer', '=', $request->id_custmer,)->get()) ,
          'reimbursement' => 
          ResourcesCustomer::collection(cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->get()) 
          
          ,'stat' =>  compact('m','reimbursement','delet_user')], 200);
      
      
        }


        public function delet_cus_mony_reimbursement(Request $request){  

$delet_user=''; 
            $id_pro=$request->id_m;
            $id_custmer=$request->id_custmer;
            $delet=   cus_reimbursement::where('id', $id_pro)->where('id_custmer', '=', $request->id_custmer,)->delete();
                                    if(!$delet){
                     $delet_user=false;        
                                return response()->json(['data' => compact('delet_user') ], 200);
                    
                }
                $delet_user=true; 
            $reimbursement=  cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
            $m=  money_customer::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
              return response()->json(['data' => 
              ResourcesCustomer::collection(money_customer::where('id_custmer', '=', $request->id_custmer,)->get()) ,
              'reimbursement' => 
              ResourcesCustomer::collection(cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->get()) 
              
              ,'stat' => compact('m','reimbursement','delet_user')], 200);
        }





        public function edit_cus(Request $request){

            $id_custmer=$request->id_custmer;
              $regestersuccess='';
             $phoneExets='';
             $datadontsave='';

            if ($request->name > 0) {
                ModelsCustomer::where('id', '=', $id_custmer)->update(
                    [
                        'name' => $request->name,
                    ]);
            }



            if ($request->date > 0) {
                ModelsCustomer::where('id', '=', $id_custmer)->update(
                    [
                        'date_' => $request->date_,

                    ]);
            }



            if ($request->address > 0) {
                ModelsCustomer::where('id', '=', $id_custmer)->update(
                    [
                        'address' => $request->address ,
                    ]);
            }



            if ($request->phone > 0) {
                
                
          

        $users = ModelsCustomer::where('phone', $request->phone)->first();

        # check if email is more than 1

        if( $users){
            # tell user not to duplicate same email
            $phoneExets=true;
            $regestersuccess=false; 
            $datadontsave=false; 

            return response()->json(['message' => trans('response.failed'),'stat' => compact('phoneExets','regestersuccess','datadontsave')], 444);
            
        }
        
        
                ModelsCustomer::where('id', '=', $id_custmer)->update(
                    [
                        'phone' => $request->phone ,
                    ]);
            }

         


            // $edit_user=true;        
            // return response()->json(['data' => 
            // ResourcesCustomer::collection(ModelsCustomer::latest()->get()) 
            // ,'stat' => compact('edit_user')], 200);
            
            
        $regestersuccess=true; 
        $phoneExets=false;
        $datadontsave=false;

        return response()->json(['data' => 
        ResourcesCustomer::collection(ModelsCustomer::where('phone', $request->phone)->latest()->get()) 
        ,'stat' => compact('regestersuccess','phoneExets','datadontsave')], 200);
     
            

        }


        public function edit_cus_mony_reimbursement(Request $request){

            $id_custmer=$request->id_custmer;
            $id_m=$request->id_m;


            if ($request->mone_proses > 0) {
                cus_reimbursement::where('id_custmer', '=', $id_custmer)->where('id', '=', $id_m)->update(
                    [
                        'mone_proses' => $request->mone_proses,
                    ]);
                }


            if ($request->detels > 0) {
                     cus_reimbursement::where('id_custmer', '=', $id_custmer)->where('id', '=', $id_m)->update(
                            [
                                'detels' => $request->detels,
                  ]);
                 
            }
           
            $reimbursement=  cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
            $m=  money_customer::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
              return response()->json(['data' => 
              ResourcesCustomer::collection(money_customer::where('id_custmer', '=', $request->id_custmer,)->get()) ,
              'reimbursement' => 
              ResourcesCustomer::collection(cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->get()) 
              
              ,'stat' =>  compact('m','reimbursement')], 200);
       
    }




            public function edit_cus_mon(Request $request){

                $id_custmer=$request->id_custmer;
                $id_m=$request->id_m;


                if ($request->mone_proses > 0) {
                    money_customer::where('id_custmer', '=', $id_custmer)->where('id', '=', $id_m)->update(
                        [
                            'mone_proses' => $request->mone_proses,
                        ]);

                    }


                if ($request->detels > 0) {
                    money_customer::where('id_custmer', '=', $id_custmer)->where('id', '=', $id_m)->update(
                                [
                                    'detels' => $request->detels,
                    ]);
                    
                }


                $reimbursement=  cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
                $m=  money_customer::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
                  return response()->json(['data' => 
                  ResourcesCustomer::collection(money_customer::where('id_custmer', '=', $request->id_custmer,)->get()) ,
                  'reimbursement' => 
                  ResourcesCustomer::collection(cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->get()) 
                  
                  ,'stat' => compact('m','reimbursement')], 200);
              
            
           
        }



         
    public function getCust(Request $request)
    {



        return response()->json(['data' =>  ResourcesCustomer::collection(ModelsCustomer::where('id_user', $request->id_user)->latest()->get())  ], 200);


    }


    public function getCus_mony(Request $request)
    {


        $total_mon=  money_customer::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
        
        $reimbursement=  cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
        
        $the_difference= $total_mon - $reimbursement ;

         return response()->json([
             'money' =>  monResorse::collection(money_customer::where('id_custmer', $request->id_custmer)->latest()->get()) ,
         'reimbursement' =>  riminsResorse::collection(cus_reimbursement::where('id_custmer', '=', $request->id_custmer)->latest()->get()) ,
         'total' => compact('total_mon','reimbursement','the_difference') ], 200);
         

    //   $total_mon=  money_customer::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
    //     return response()->json(['data' =>  monResorse::collection(money_customer::where('id_custmer', $request->id_custmer)->latest()->get()) ,'total' => compact('total_mon') ], 200);


    // }

    // public function getCus_reimbursement(Request $request)
    // {

//  $reimbursement=  cus_reimbursement::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
               

//         return response()->json(['data' =>  riminsResorse::collection(cus_reimbursement::where('id_custmer', '=', $request->id_custmer)->latest()->get()) ,'total' => compact('reimbursement') ], 200);


    }


   
  
}

