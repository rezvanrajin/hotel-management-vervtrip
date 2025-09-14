<?php


use App\Models\Right;
use App\Models\RoleRight;
use App\Models\Setting;
use App\Models\User;
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

  


}
