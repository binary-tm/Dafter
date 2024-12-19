<?php
namespace App\Helpers;

use App\Models\User;

class Common{




    public function All($body){

        $users = User::all();
        $title = 'dafter';
        foreach ($users as $user) {
            $token = $user->token;

            $this->send_firebase_notification($token, $title, $body);
        }
        
    }
 

    public static function send_firebase_notification($tokens, $title, $body,$icon = '',$data = [],$action = '', $type = '', $id = '', $notification_type = 'user_notification')
    {

                $api_access_key = 'AIzaSyC6dNNihPqf88CbxscjYTCOxKCkIUVWb8M';

                $notification = [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ];

                $payload = [
                    'registration_ids' => $tokens,
                    'notification' => $notification,
                    'priority' => 'high',
                ];

                if (!empty($icon)) {
                    $payload['notification']['icon'] = $icon;
                }

                if (!empty($data)) {
                    $payload['data'] = $data;
                }


                if (isset($data['image']) && !empty($data['image'])) {
                    $payload['notification']['image'] = $data['image'];
                } else {
                    // $payload['notification']['image'] = '';
                }

                $headers = [
                    'Authorization: key=' . $api_access_key,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                $result = curl_exec($ch);
                curl_close($ch);

                return $result;



    }
    
    public static function apiResponse(bool $success, $message, $data = null, $statusCode = null,)
    {

        if ($success == false && $statusCode == null) {
            $statusCode = 422;
        }

        if ($success == true && $statusCode == null) {
            $statusCode = 200;
        }


        $dataForPaginationCheck = $data;

        if ($data instanceof \Illuminate\Http\Resources\Json\JsonResource) {

            $dataForPaginationCheck = $data->resource;
        }


        return response()->json(
            [
                'success'   => $success,

                'message'   => __($message),

                'data'      => ($data instanceof LengthAwarePaginator) ? $data->items(): $data,
                'paginates' => ($dataForPaginationCheck instanceof LengthAwarePaginator) ? self::paginationData($data) : null,
            ],
            $statusCode
        );
    }



}