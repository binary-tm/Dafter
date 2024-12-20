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
            'id_custmer' => 'required|integer',
            'detels' => 'required|string',
            'money' => 'required|numeric',
        ]);
        $data= $request->all();
        $data['id_user'] =auth()->user()->id;
        $data['mone_cunt'] =request('money');
        $money = money_customer::create($data);
        return Common::apiResponse(1, __('message.success'), new moneyResource($money), 200);
    }

    public function reimbursement(Request $request)
    {
        $request->validate([
            'id_custmer' => 'required|integer',
            'detels' => 'required|string',
        ]);
        $data= $request->all();
        $data['id_user'] =auth()->user()->id;
        $data['mone_proses'] =request('money');

        $reimbursement = cus_reimbursement::create($data);
        return Common::apiResponse(1, __('message.success'), new ReimbursementResource($reimbursement), 200);

    }

    public function delet_cus(Request $request)
    {

        $request->validate(['id_custmer' => 'required|integer']);

        $deleted = customer::where('id', $request->id_custmer)->where('id_user',auth()->user()->id)->delete();
        if (!$deleted) {
            return Common::apiResponse(0, __('message.samethingwrong'),null,404);
        } else {
            return Common::apiResponse(1, __('message.deleted'), ['deleted' => $deleted], 200);
        }
         

    }

    public function edit_cus(Request $request)
    {
        $request->validate(['id_custmer' => 'required|integer']);
        $data= $request->all();
        if (request()->filled('date')) {
            $data['date_'] = request('date');
        }
        $customer = customer::find($request->id_custmer);        
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

        $data=$this->money($request->id_custmer);
        return   Common::apiResponse(1, __('message.success'),  $data ,200);

    }



    public function delete_money(Request $request){  

                $id_custmer=$request->id_custmer;
                $id_money=$request->id_money;
                $id_user=auth()->user()->id ;
                $delete= money_customer::where('id', $id_money)->where('id_user', '=', $id_user,)->delete();
                if(!$delete){                   
                       return   Common::apiResponse(0, __('message.field'),  ['delete_money'=>0]  ,404);
                }
                $data=$this->money($id_custmer);
                return   Common::apiResponse(1, __('message.success'),  $data ,200);
  
                }
        
        
                public function delet_reimbursement(Request $request){  
        

                    $id_custmer=$request->id_custmer;
                    $id_reimbursement=$request->id_reimbursement;
                    $id_user=auth()->user()->id ;
                    $delete= cus_reimbursement::where('id', $id_reimbursement)->where('id_user', '=', $id_user,)->delete();
                    if(!$delete){                   
                           return   Common::apiResponse(0, __('message.field'),  ['delete_money'=>0]  ,404);
                    }
                    $data=$this->money($id_custmer);
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


                static function money($id_custmer)  {
                    $total_mon = money_customer::where('id_custmer', $id_custmer)->sum('mone_cunt');
                    $reimbursement = cus_reimbursement::where('id_custmer', $id_custmer)->sum('mone_proses');
                    $the_difference = $total_mon - $reimbursement;
                    $data = ['total_money'=> moneyResource::collection(money_customer::where('id_custmer', $id_custmer)->latest()->get()),
                            'tottal_reimbursement'=> ReimbursementResource::collection(cus_reimbursement::where('id_custmer', $id_custmer)->latest()->get()),
                            'total' => compact('total_mon', 'reimbursement', 'the_difference')];
                    
                            return $data;

                }       
        
}
