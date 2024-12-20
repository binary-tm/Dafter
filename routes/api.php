<?php

use App\Http\Controllers\customer;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\moared;
use App\Http\Controllers\UserController;
use App\Models\users;
use App\Models\money_customer;
use App\Http\Resources\customer as ResourcesCustomer;
use App\Http\Resources\customerResorse;
use App\Http\Resources\totalcusResorse;
use App\Models\customer as ModelsCustomer;
use App\Models\updat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Route::get('/test/{id}', function ( $id) {
//     $comments = users::find($id)->cust;
//     $comments_='';
//  foreach ($comments as $value) {
//     $comments_ = money_customer::select('id_custmer','mone_cunt')->where('id_user', $value->id_user)->get();
//  }
//  foreach ($comments_ as  $value) {
//     // $end = array_push($value->id_custmer => $value->mone_cunt);
//     $thing1=$value->id_custmer;
//     $thing2=$value->mone_cunt;  
//     $newstuff[] = array($thing1 => $thing2);
//     $key = $value->id_custmer;
//     $sum = array_sum(array_column($newstuff,$key));
//     $end=array();;
// if (!array_key_exists($thing1, $end)) { 
//     $end[] = array ( $thing1 => $thing1,'cunt' => $thing2 ,'total'=> $sum);
// }
//  }
//     // return response()->json($end);
//     return response()->json(['data' => 
//     ResourcesCustomer::collection($comments) ,  
//     'total' => $end ], 200);
// });
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::get('update', function () {

   $chik=updat::where('id','=',1)->first();
    if ($chik->VALUE_ == "1"){
    return response()->json([
        "status" => "update naw"
    ]);
    }
    return response()->json([
        "status" =>  "No update "
    ]);
});


        Route::post('regester', [UserController::class, 'regester'])->name('regester');
        Route::post('login', [UserController::class, 'login'])->name('login');
        Route::post('notification_id', [UserController::class, 'set_notification_id'])->name('notification_id');
        Route::post('reset-password', [UserController::class, 'resetpassword'])->name('resetpassword');
        Route::post('valdate-code', [UserController::class, 'valdatecode'])->name('valdatecode');
        Route::post('setNewPassword', [UserController::class, 'setNewPassword'])->name('setNewPassword');
Route::middleware('auth:sanctum')->group(function () {

    
    Route::prefix('user')->group(function () {
        Route::get('/last-transactions', [UserController::class, 'transactions']);

    });

    Route::prefix('customers')->group(function () {
        Route::post('/add', [CustomerController::class, 'addcust']);
        Route::post('/money/add', [CustomerController::class, 'addmoney']);
        Route::post('/reimbursement/add', [CustomerController::class, 'reimbursement']);
        Route::delete('/delete', [CustomerController::class, 'delet_cus']);
        Route::post('/edit', [CustomerController::class, 'edit_cus']);
        Route::get('/', [CustomerController::class, 'getCust']);
        Route::get('/money', [CustomerController::class, 'getCus_mony']);
        Route::delete('/money/delete', [CustomerController::class, 'delete_money']);
        Route::delete('/reimbursement/delete', [CustomerController::class, 'delet_reimbursement']);
        Route::get('search-customer', [CustomerController::class, 'search_customer'])->name('search_customer');

    });
    Route::prefix('supplier')->group(function () {
        Route::post('/add', [SupplierController::class, 'addcust']);
        Route::post('/money/add', [SupplierController::class, 'addmoney']);
        Route::post('/reimbursement/add', [SupplierController::class, 'reimbursement']);
        Route::delete('/delete', [SupplierController::class, 'delet_cus']);
        Route::post('/edit', [SupplierController::class, 'edit_cus']);
        Route::get('/', [SupplierController::class, 'getCust']);
        Route::get('/money', [SupplierController::class, 'getCus_mony']);
        Route::delete('/money/delete', [SupplierController::class, 'delete_money']);
        Route::delete('/reimbursement/delete', [SupplierController::class, 'delet_reimbursement']);
        Route::get('search-supplier', [SupplierController::class, 'search_supplier'])->name('serch_supplier');

    });
   
});





// Route::post('addcust', [customer::class, 'addcust'])->name('addcust');
// Route::post('cust_mon', [customer::class, 'addmoney'])->name('cust_mon');
// Route::post('cus_reimbursement', [customer::class, 'reimbursement'])->name('cus_reimbursement');
// // /*delet*/
// Route::post('delet_cus_mony_reimbursement', [customer::class, 'delet_cus_mony_reimbursement'])->name('delet_cus_mony_reimbursement');
// Route::post('delet_cus_mon', [customer::class, 'delet_cus_mon'])->name('delet_cus_mon');
// Route::post('delet_cus', [customer::class, 'delet_cus'])->name('delet_cus');
// //edit
// Route::post('edit_cus_mony_reimbursement', [customer::class, 'edit_cus_mony_reimbursement'])->name('edit_cus_mony_reimbursement');
// Route::post('edit_cus_mon', [customer::class, 'edit_cus_mon'])->name('edit_cus_mon');
// Route::post('edit_cus', [customer::class, 'edit_cus'])->name('edit_cus');
// // Route::post('regester', [user::class, 'regester'])->name('regester');
// // Route::post('login', [user::class, 'login'])->name('login');
// Route::post('addmord', [moared::class, 'addcust'])->name('addmord');
// Route::post('mord_mon', [moared::class, 'addmoney'])->name('mord_mon');
// Route::post('mord_reimbursement', [moared::class, 'reimbursement'])->name('mord_reimbursement');
// /*delet*/
// Route::post('delet_mord_mony_reimbursement', [moared::class, 'delet_cus_mony_reimbursement'])->name('delet_mord_mony_reimbursement');
// Route::post('delet_mord_mon', [moared::class, 'delet_cus_mon'])->name('delet_mord_mon');
// Route::post('delet_mord', [moared::class, 'delet_cus'])->name('delet_mord');
// //edit
// Route::post('edit_mord_mony_reimbursement', [moared::class, 'edit_reimbursement'])->name('edit_mord_mony_reimbursement');
// Route::post('edit_mord_mon', [moared::class, 'edit_cus_mon'])->name('edit_mord_mon');
// Route::post('edit_mord', [moared::class, 'edit_cus'])->name('edit_mord');
// get
// Route::get('getAllcus', [customer::class, 'getCust'])->name('getAllcus');
// Route::get('getcus_mon', [customer::class, 'getCus_mony'])->name('getcus_mon');
// // Route::get('getcus_reim', [customer::class, 'getCus_reimbursement'])->name('getcus_reim');
// Route::get('getAllmor', [moared::class, 'getCust'])->name('getAllmor');
// Route::get('getmor_mon', [moared::class, 'getCus_mony'])->name('getmor_mon');
// // Route::get('getmor_reim', [moared::class, 'getCus_reimbursement'])->name('getmor_reim');