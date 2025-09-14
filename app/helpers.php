<?php

use App\Mail\EmailNotification;
use App\Mail\SendOtp;
use App\Models\CustomOption;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTruck;
use App\Models\OrderTruckDriver;
use App\Models\Truck;
use Illuminate\Http\Request;
use App\Models\Right;
use App\Models\RoleRight;
use App\Models\Setting;
use App\Models\Otp;
use App\Models\Translation;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Helper
{
    public static function hasRight($right, $role_id = null)
    {
        if ($role_id != null) {
            $role = $role_id;
        } else {
            $role = \Auth::user()->role;
        }
        $right = Right::where('name', $right)->first();
        if ($right) {
            if (RoleRight::where('role_id', $role)->where('right_id', $right->id)->where('permission', 1)->exists()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function getSettings($key)
    {
        $settings = Setting::where('key', $key)->first();
        if (!is_null($settings)) {
            return $settings->value;
        } else {
            return false;
        }
    }
    public static function generateUsername($string)
    {
        $user_name = str_replace(' ', '', $string);
        if (!User::where('user_name', $user_name)->exists()) {
            return strtolower($user_name);
        }
        $number = 1;
        do {
            $number++;
            $user_name = $string . $number;
        } while (User::where('user_name', $user_name)->exists());

        return strtolower($user_name);
    }
 
    public static function sendEmail($email, $subject, $data, $template = 'default')
	{
		Mail::send('emails.' . $template, ['data' => $data], function ($message) use ($email, $subject) {
			$message->from(env('MAIL_FROM_ADDRESS'), $subject);
			$message->to($email)->subject($subject);
		});
	}

    public static function sendPushNotification($device_token, $title, $body, $image)
    {
        $data = [
            'to' => $device_token,
            'content_available' => true,
            "sticky" => true,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'style' => 'picture',
                "image" => env("APP_URL") . $image,
            ],
            'data' => [
                'title' => $title,
                'body' => json_encode($body),
                'status' => 'done',
                "image" => env("APP_URL") . $image,
            ],
        ];
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: key=AAAAIZKFubk:APA91bEy2Vc3H0-f6OO6ZggCJ8fuz8PRZjIlbYQgZc2HY7ctVdgJ88zOtfTHW1GjxHVCajpztOG-dPQOWmq4rvambuX8nXTHCgs7v9xU9KjR9Jdf3TBSt4V1SkU1yg73rPoVx66fGGJ7",
                    "Content-Type: application/json"
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public static function storeNotification($user_id, $order_id, $notification_title, $notification_description, $receiver_id = null, $click_action = null, $status = null , $receiver_role = null)
    {
        $notification = new Notification();
        $notification->user_id = $user_id;
        $notification->order_id = $order_id;
        $notification->title = $notification_title;
        $notification->description = $notification_description;
        $notification->receiver_id = $receiver_id;
        $notification->click_action = $click_action;
        $notification->status = $status;
        $notification->receiver_role = $receiver_role ? $receiver_role : null;
        $notification->save();
    }


}
