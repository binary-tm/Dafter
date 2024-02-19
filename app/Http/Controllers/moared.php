<?php

namespace App\Http\Controllers;

use App\Models\moared as ModelsMoared;
use App\Models\money_moared;
use App\Models\mored_reimburesment;
use Illuminate\Http\Request;
use App\Http\Resources\customer as ResourcesCustomer;
use App\Http\Resources\monResorse;
use App\Http\Resources\riminsResorse;

// use App\Models\cus_reimbursement;
// use App\Models\customer as money_moared;
// use App\Models\money_customer;
// // use Illuminate\Http\Request;


class moared extends Controller
{
     
    public function addcust(Request $request)
    {


    
        $regestersuccess='';
        $emailexets='';
        $users = ModelsMoared::where('phone', $request->phone)->get();

        # check if email is more than 1

        if(sizeof($users) > 0){
            # tell user not to duplicate same email
            $emailexets=true;
            return response()->json(['message' => trans('response.failed'),'stat' =>  compact('emailexets')], 444);
            
        }

        $data= ModelsMoared::create(
            [
                 'name' => $request->name,
                 'date_' => $request->date,
                 'address' => $request->address ,
                 'phone' => $request->phone ,
                 'id_user' => $request->id_user ,
             
                 
                
             ]);



        if (!$data->save()) {
            $regestersuccess=false;
            return response()->json(['message' => trans('regester.failed'),'stat' => compact('regestersuccess')], 444);

        }

        $data->save();
        $regestersuccess=true;        
        return response()->json(['data' => 
        ResourcesCustomer::collection(ModelsMoared::where('phone', $request->id_user)->latest()->get()) 
        ,'stat' => compact('regestersuccess')], 200);






    }


    public function addmoney(Request $request)
    {


    
 
        $data= money_moared::create(
            [
                 'id_custmer' => $request->id_custmer,
                 'detels' => $request->detels,
                 'id_user' => $request->id_user,
                 'mone_cunt' => $request->mone_cunt,
                 'D' => $request->d,
                 'M' => $request->m,
                 'Y' => $request->y,

             
                 
                
             ]);



        if (!$data->save()) {
            $regestersuccess=false;
            return response()->json(['message' => trans('regester.failed'),'stat' =>  compact('regestersuccess')], 444);

        }

        $data->save();

        $reimbursement=  mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
             



      $m=  money_moared::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
             
        return response()->json(['data' => 
        ResourcesCustomer::collection(money_moared::where('id_custmer', '=', $request->id_custmer,)->get()) ,
        'reimbursement' => 
        ResourcesCustomer::collection(mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->get()) 
      
        ,'stat' => compact('m','reimbursement')], 200);






    }
  

    public function reimbursement(Request $request)
    {


    
 
        $data= mored_reimburesment::create(
            [
                 'id_custmer' => $request->id_custmer,
                 'detels' => $request->detels,
                 'id_user' => $request->id_user,
                 'mone_proses' => $request->mone_proses,
                 'D' => $request->d,
                 'M' => $request->m,
                 'Y' => $request->y,
             
                
             ]);



        if (!$data->save()) {
            $regestersuccess=false;
            return response()->json(['message' => trans('regester.failed'),'stat' => compact('regestersuccess')], 444);

        }

        $data->save();

      $reimbursement=  mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
      $m=  money_moared::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
        return response()->json(['data' => 
        ResourcesCustomer::collection(money_moared::where('id_custmer', '=', $request->id_custmer,)->get()) ,
        'reimbursement' => 
        ResourcesCustomer::collection(mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->get()) 
        
        , 'stat' => compact('m','reimbursement')], 200);






    }






    public function delet_cus(Request $request){  



        $id_custmer=$request->id_custmer;
        $delet_user='';
               $delet_1= money_moared::where('id_custmer', '=', $request->id_custmer,)->delete();
                 $delet_2=   mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->delete();
               
        $delet=  ModelsMoared::where('id', $id_custmer)->delete();
        if(!$delet){
             $delet_user=false;        
                        return response()->json(['data' => compact('delet_user') ], 200);
            
        }
        $delet_user=true;        
        return response()->json(['data' => compact('delet_user') ], 200);

                // $id_custmer=$request->id_custmer;

                // ModelsMoared::where('id', $id_custmer)->delete();

                // $delet_user=true;        
                // return response()->json(['data' => 
                // ResourcesCustomer::collection(ModelsMoared::where('phone', $request->id_user)->latest()->get()) 
                // ,'stat' => compact('delet_user')], 200);
                
               
    }


    public function delet_cus_mon(Request $request){  


        $id_pro=$request->id_m;
        $id_custmer=$request->id_custmer;
        money_moared::where('id', $id_pro)->where('id_custmer', '=', $request->id_custmer,)->delete();
        
        $reimbursement=  mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
        $m=  money_moared::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
          return response()->json(['data' => 
          ResourcesCustomer::collection(money_moared::where('id_custmer', '=', $request->id_custmer,)->get()) ,
          'reimbursement' => 
          ResourcesCustomer::collection(mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->get()) 
          
          ,'stat' => compact('m','reimbursement')], 200);
      
      
        }


        public function delet_cus_mony_reimbursement(Request $request){  


            $id_pro=$request->id_m;
            $id_custmer=$request->id_custmer;
            mored_reimburesment::where('id', $id_pro)->where('id_custmer', '=', $request->id_custmer,)->delete();
            
            $reimbursement=  mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
            $m=  money_moared::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
              return response()->json(['data' => 
              ResourcesCustomer::collection(money_moared::where('id_custmer', '=', $request->id_custmer,)->get()) ,
              'reimbursement' => 
              ResourcesCustomer::collection(mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->get()) 
              
              ,'stat' => compact('m','reimbursement')], 200);
        }





        public function edit_cus(Request $request){

            // $id_custmer=$request->id_custmer;


            // if ($request->name > 0) {
            //     money_moared::where('id', '=', $id_custmer)->update(
            //         [
            //             'name' => $request->name,
            //         ]);
            // }



            // if ($request->date > 0) {
            //     money_moared::where('id', '=', $id_custmer)->update(
            //         [
            //             'date_' => $request->date,

            //         ]);
            // }



            // if ($request->address > 0) {
            //     money_moared::where('id', '=', $id_custmer)->update(
            //         [
            //             'address' => $request->address ,
            //         ]);
            // }



            // if ($request->phone > 0) {
            //     money_moared::where('id', '=', $id_custmer)->update(
            //         [
            //             'phone' => $request->phone ,
            //         ]);
            // }

         


            // $edit_user=true;        
            // return response()->json(['data' => 
            // ResourcesCustomer::collection(ModelsMoared::where('phone', $request->id_user)->latest()->get()) 
            // ,'stat' => compact('edit_user')], 200);
            
     
            

            $id_custmer=$request->id_custmer;
            $regestersuccess='';
           $phoneExets='';
           $datadontsave='';

          if ($request->name > 0) {
              ModelsMoared::where('id', '=', $id_custmer)->update(
                  [
                      'name' => $request->name,
                  ]);
          }



          if ($request->date > 0) {
            ModelsMoared::where('id', '=', $id_custmer)->update(
                  [
                      'date_' => $request->date_,

                  ]);
          }



          if ($request->address > 0) {
            ModelsMoared::where('id', '=', $id_custmer)->update(
                  [
                      'address' => $request->address ,
                  ]);
          }



          if (@$request->phone > 0) {
              
              
        

      $users = ModelsMoared::where('phone', $request->phone)->first();

      # check if email is more than 1

      if( $users){
          # tell user not to duplicate same email
          $phoneExets=true;
          $regestersuccess=false; 
          $datadontsave=false; 

          return response()->json(['message' => trans('response.failed'),'stat' => compact('phoneExets','regestersuccess','datadontsave')], 444);
          
      }
      
      
      ModelsMoared::where('id', '=', $id_custmer)->update(
                  [
                      'phone' => $request->phone ,
                  ]);
          }

       


          // $edit_user=true;        
          // return response()->json(['data' => 
          // ResourcesCustomer::collection(money_moared::latest()->get()) 
          // ,'stat' => compact('edit_user')], 200);
          
          
      $regestersuccess=true; 
      $phoneExets=false;
      $datadontsave=false;

      return response()->json(['data' => 
      ResourcesCustomer::collection(ModelsMoared::where('id_user', $request->id_user)->latest()->get()) 
      ,'stat' => compact('regestersuccess','phoneExets','datadontsave')], 200);
   
          

        }


        public function edit_reimbursement(Request $request){

            $id_custmer=$request->id_custmer;
            $id_m=$request->id_m;


            if ($request->mone_proses > 0) {
                mored_reimburesment::where('id_custmer', '=', $id_custmer)->where('id', '=', $id_m)->update(
                    [
                        'mone_proses' => $request->mone_proses,
                    ]);
                }


            if ($request->detels > 0) {
                mored_reimburesment::where('id_custmer', '=', $id_custmer)->where('id', '=', $id_m)->update(
                            [
                                'detels' => $request->detels,
                  ]);
                 
            }
           
            $reimbursement=  mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
            $m=  money_moared::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
              return response()->json(['data' => 
              ResourcesCustomer::collection(money_moared::where('id_custmer', '=', $request->id_custmer,)->get()) ,
              'reimbursement' => 
              ResourcesCustomer::collection(mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->get()) 
              
              ,'stat' => compact('m','reimbursement')], 200);
       
    }




            public function edit_cus_mon(Request $request){

                $id_custmer=$request->id_custmer;
                $id_m=$request->id_m;


                if ($request->mone_proses > 0) {
                    money_moared::where('id_custmer', '=', $id_custmer)->where('id', '=', $id_m)->update(
                        [
                            'mone_proses' => $request->mone_proses,
                        ]);

                    }


                if ($request->detels > 0) {
                    money_moared::where('id_custmer', '=', $id_custmer)->where('id', '=', $id_m)->update(
                                [
                                    'detels' => $request->detels,
                    ]);
                    
                }


                $reimbursement=  mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
                $m=  money_moared::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
                  return response()->json(['data' => 
                  ResourcesCustomer::collection(money_moared::where('id_custmer', '=', $request->id_custmer,)->get()) ,
                  'reimbursement' => 
                  ResourcesCustomer::collection(mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->get()) 
                  
                  ,'stat' =>  compact('m','reimbursement')], 200);
              
            
           
        }



        public function getCust(Request $request)
        {
    
    
    
            return response()->json(['data' =>  ResourcesCustomer::collection(ModelsMoared::where('id_user', $request->id_user)->latest()->get())  ], 200);
    
    
        }
    
    
        public function getCus_mony(Request $request)
        {
    
    
            $total_mon=  money_moared::where('id_custmer', '=', $request->id_custmer,)->sum('mone_cunt');
        
            $reimbursement=  mored_reimburesment::where('id_custmer', '=', $request->id_custmer,)->sum('mone_proses');
            
            $the_difference= $total_mon - $reimbursement ;
    
             return response()->json([
                 'money' =>  monResorse::collection(money_moared::where('id_custmer', $request->id_custmer)->latest()->get()) ,
             'reimbursement' =>  riminsResorse::collection(mored_reimburesment::where('id_custmer', '=', $request->id_custmer)->latest()->get()) ,
             'total' => compact('total_mon','reimbursement','the_difference') ], 200);
             
            // return response()->json(['data' =>  ResourcesCustomer::collection(money_moared::where('id_custmer', $request->id_custmer)->latest()->get())  ], 200);
    
    
        }
    
        public function getCus_reimbursement(Request $request)
        {
    
    
    
            return response()->json(['data' =>  ResourcesCustomer::collection(mored_reimburesment::where('id_custmer', '=', $request->id_custmer)->latest()->get())  ], 200);
    
    
        }
}
