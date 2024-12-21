<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Http\Resources\moneyResource;
use App\Http\Resources\ReimbursementResource;
use App\Models\cus_reimbursement;
use App\Models\money_customer;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Models\customer;

class CustomerController extends Controller
{
    public function addcust(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);
        $data= $request->all();
        $data['id_user'] =auth()->user()->id;
        $data['date_'] =request('date');
        $customer = customer::create($data);
        return Common::apiResponse(1, __('message.success'), new CustomerResource($customer), 200);

    }

    public function addmoney(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|integer',
            'detels' => 'required|string',
            'money' => 'required|numeric',
        ]);
        $data= $request->all();
        $data['id_user'] =auth()->user()->id;
        $data['mone_cunt'] =request('money');
        $data['id_custmer']=$data['id_customer'];
        $money = money_customer::create($data);
        if ($money) {
            $data['type']='customer_money';
            $data['amount']=$data['money'];
            $data['transactions_id']=$money->id;
           $transaction= Common::transaction($data);
           if($transaction == false) {
             return Common::apiResponse(0, __('message.transaction_field'), null ,500);
            }
        }
        
        return Common::apiResponse(1, __('message.success'), new moneyResource($money), 200);
    }

    public function reimbursement(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|integer',
            'detels' => 'required|string',
        ]);
        $data= $request->all();
        $data['id_user'] =auth()->user()->id;
        $data['mone_proses'] =request('money');
        $data['id_custmer']=$data['id_customer'];

        $reimbursement = cus_reimbursement::create($data);
            $data['type']='customer_reimbursement';
            $data['amount']=$data['money'];
            $data['transactions_id']=$reimbursement->id;
            $transaction= Common::transaction($data);
            if($transaction == false) {
              return Common::apiResponse(0, __('message.transaction_field'), null ,500);
             }
        return Common::apiResponse(1, __('message.success'), new ReimbursementResource($reimbursement), 200);

    }

    public function delet_cus(Request $request)
    {

        $request->validate(['id_customer' => 'required|integer']);

        $deleted = customer::where('id', $request->id_customer)->where('id_user',auth()->user()->id)->delete();
        if (!$deleted) {
            return Common::apiResponse(0, __('message.samethingwrong'),null,404);
        } else {
            return Common::apiResponse(1, __('message.deleted'), ['deleted' => $deleted], 200);
        }
         

    }

    public function edit_cus(Request $request)
    {
        $request->validate(['id_customer' => 'required|integer']);
        $data= $request->all();
        if (request()->filled('date')) {
            $data['date_'] = request('date');
        }
        $customer = customer::find($request->id_customer);        
        if(!$customer) return Common::apiResponse(0, __('message.notfound'), null,404);
        $customer->update($data);
        
        return  Common::apiResponse(1, __('message.success'), new CustomerResource($customer),200);
    }

    public function getCust(Request $request)
    {
     return   Common::apiResponse(1, __('message.success'), CustomerResource::collection(customer::where('id_user', auth()->user()->id)->latest()->get()),200);

    }

    public function getCus_mony(Request $request)
    {

        $data=$this->money($request->id_customer);
        return   Common::apiResponse(1, __('message.success'),  $data ,200);

    }



    public function delete_money(Request $request){  

                $id_customer=$request->id_customer;
                $id_money=$request->id_money;
                $id_user=auth()->user()->id ;
                $delete= money_customer::where('id', $id_money)->where('id_user', '=', $id_user,)->delete();
                if(!$delete){                   
                       return   Common::apiResponse(0, __('message.field'),  ['delete_money'=>0]  ,404);
                }
                $data=$this->money($id_customer);
                return   Common::apiResponse(1, __('message.success'),  $data ,200);
  
                }
        
        
                public function delet_reimbursement(Request $request){  
        

                    $id_customer=$request->id_customer;
                    $id_reimbursement=$request->id_reimbursement;
                    $id_user=auth()->user()->id ;
                    $delete= cus_reimbursement::where('id', $id_reimbursement)->where('id_user', '=', $id_user,)->delete();
                    if(!$delete){                   
                           return   Common::apiResponse(0, __('message.field'),  ['delete_money'=>0]  ,404);
                    }
                    $data=$this->money($id_customer);
                    return   Common::apiResponse(1, __('message.success'),  $data ,200);
  
                }


                public function search_customer(Request $request)
                {
            
                    $request->validate([
                        'item' => 'required', 
                    ]);
                    $item = $request->item;
                    $id_user = auth()->user()->id;
                
                    $customer = customer::where(function ($query) use ($item) {
                            $query->where('name', 'LIKE', "%{$item}%")
                                  ->orWhere('phone', 'LIKE', "%{$item}%");
                        })
                        ->where('id_user', $id_user) 
                        ->get();
                
                    return Common::apiResponse(1, __('message.success'), CustomerResource::collection($customer), 200);

                }


                static function money($id_customer)  {
                    $total_mon = money_customer::where('id_custmer', $id_customer)->sum('mone_cunt');
                    $reimbursement = cus_reimbursement::where('id_custmer', $id_customer)->sum('mone_proses');
                    $the_difference = $total_mon - $reimbursement;
                    $data = ['total_money'=> moneyResource::collection(money_customer::where('id_custmer', $id_customer)->latest()->get()),
                            'tottal_reimbursement'=> ReimbursementResource::collection(cus_reimbursement::where('id_custmer', $id_customer)->latest()->get()),
                            'total' => compact('total_mon', 'reimbursement', 'the_difference')];
                    
                            return $data;

                }       
        
}
