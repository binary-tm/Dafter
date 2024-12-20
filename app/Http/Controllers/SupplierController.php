<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Http\Resources\moneyResource;
use App\Http\Resources\ReimbursementResource;
use App\Models\mored_reimburesment;
use App\Models\money_customer;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Models\supplier;
use App\Models\money_supplier;
class SupplierController extends Controller
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
        $supplier = supplier::create($data);
        return Common::apiResponse(1, __('message.success'), new CustomerResource($supplier), 200);

    }

    public function addmoney(Request $request)
    {
        $request->validate([
            'id_supplier' => 'required|integer',
            'detels' => 'required|string',
            'money' => 'required|numeric',
        ]);
        $data= $request->all();
        $data['id_user'] =auth()->user()->id;
        $data['mone_cunt'] =request('money');
        $data['id_custmer'] =request('id_supplier');
        $money = money_supplier::create($data);
        return Common::apiResponse(1, __('message.success'), new moneyResource($money), 200);
    }

    public function reimbursement(Request $request)
    {
        $request->validate([
            'id_supplier' => 'required|integer',
            'detels' => 'required|string',
        ]);
        $data= $request->all();
        $data['id_user'] =auth()->user()->id;
        $data['mone_proses'] =request('money');
        $data['id_custmer'] =request('id_supplier');
        $reimbursement = mored_reimburesment::create($data);
        return Common::apiResponse(1, __('message.success'), new ReimbursementResource($reimbursement), 200);

    }

    public function delet_cus(Request $request)
    {

        $request->validate(['id_supplier' => 'required|integer']);

        $deleted =supplier::where('id', $request->id_supplier)->where('id_user',auth()->user()->id)->delete();
        if (!$deleted) {
            return Common::apiResponse(0, __('message.samethingwrong'),null,404);
        } else {
            return Common::apiResponse(1, __('message.deleted'), ['deleted' => $deleted], 200);
        }
         

    }

    public function edit_cus(Request $request)
    {
        $request->validate(['id_supplier' => 'required|integer']);
        $data= $request->all();
        if (request()->filled('date')) {
            $data['date_'] = request('date');
        }
        $data['id_customer'] =request('id_supplier');
        $supplier =supplier::find($request->id_supplier);        
        if(!$supplier) return Common::apiResponse(0, __('message.notfound'), null,404);
        $supplier->update($data);
    
        return  Common::apiResponse(1, __('message.success'), new CustomerResource($supplier),200);
    }

    public function getCust(Request $request)
    {
     return   Common::apiResponse(1, __('message.success'), CustomerResource::collection(supplier::where('id_user', auth()->user()->id)->latest()->get()),200);

    }

    public function getCus_mony(Request $request)
    {

        $data=$this->money($request->id_supplier);
        return   Common::apiResponse(1, __('message.success'),  $data ,200);

    }



    public function delete_money(Request $request){  

                $id_supplier=$request->id_supplier;
                $id_money=$request->id_money;
                $id_user=auth()->user()->id ;
                $delete= money_supplier::where('id', $id_money)->where('id_user',  $id_user,)->delete();
                if(!$delete){                   
                       return   Common::apiResponse(0, __('message.field'),  ['delete_money'=>0]  ,404);
                }
                $data=$this->money($id_supplier);
                return   Common::apiResponse(1, __('message.success'),  $data ,200);
  
                }
        
        
                public function delet_reimbursement(Request $request){  
        

                    $id_supplier=$request->id_supplier;
                    $id_reimbursement=$request->id_reimbursement;
                    $id_user=auth()->user()->id ;
                    $delete= mored_reimburesment::where('id', $id_reimbursement)->where('id_user', $id_user,)->delete();
                    if(!$delete){                   
                           return   Common::apiResponse(0, __('message.field'),  ['delete_money'=>0]  ,404);
                    }
                    $data=$this->money($id_supplier);
                    return   Common::apiResponse(1, __('message.success'),  $data ,200);
  
                }


                public function search_supplier(Request $request)
                {
            
                    $request->validate([
                        'item' => 'required', 
                    ]);
                    $item = $request->item;
                    $id_user = auth()->user()->id;
                
                    $supplier = supplier::where(function ($query) use ($item) {
                            $query->where('name', 'LIKE', "%{$item}%")
                                  ->orWhere('phone', 'LIKE', "%{$item}%");
                        })
                        ->where('id_user', $id_user) 
                        ->get();
                
                    return Common::apiResponse(1, __('message.success'), CustomerResource::collection($supplier), 200);

                }

                static function money($id_supplier)  {
                    $total_mon = money_supplier::where('id_custmer', $id_supplier)->sum('mone_cunt');
                    $reimbursement = mored_reimburesment::where('id_custmer', $id_supplier)->sum('mone_proses');
                    $the_difference = $total_mon - $reimbursement;
                    $data = ['total_money'=> moneyResource::collection(money_supplier::where('id_custmer', $id_supplier)->latest()->get()),
                            'tottal_reimbursement'=> ReimbursementResource::collection(mored_reimburesment::where('id_custmer', $id_supplier)->latest()->get()),
                            'total' => compact('total_mon', 'reimbursement', 'the_difference')];
                    
                            return $data;

                }       
}
