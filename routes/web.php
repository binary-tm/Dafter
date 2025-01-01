<?php

use App\Http\Resources\customerResorse;
use App\Mail\sendcoderesetPassword;
use Illuminate\Support\Facades\Route;
use App\Models\users;
use App\Models\customer as ModelsCustomer;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    $email = 'ahmed114747ed@gmail.com';
    $token = 5646;
    
    try {
        // Send the email
        Mail::to($email)->send(new sendcoderesetPassword($email, $token));
        return response()->json([
            'message' => 'Email sent successfully!',
        ], 200);
    } catch (Exception $e) {
        // Log the error and return an error response
        \Log::error('Email sending failed: ' . $e->getMessage());
        return response()->json([
            'error' => 'Failed to send email. Please try again later.',
        ], 500);
}
});




Route::get('/test/{id}', function ( $id) {
 
    $comments  = ModelsCustomer::where('id_user', $id)->latest()->get()->mony_cus;
    // $comments = users::find($id)->cust;


    // return customerResorse::collection( $cus->cus_reimbursement);
   return dd($comments);

});
