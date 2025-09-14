<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Helper;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration()
    {
        return view('auth.pages.registration');
    }

    public function login()
    {
        return view('auth.pages.login');
    }

    public function forgotPassword()
    {
        App::setLocale(Session::get('language'));
        return view('auth.pages.forgot-password');
    }

    public function resetOtpSend(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            $user = User::where('email', $request->email)->first();

            $otps = random_int(100000, 999999);

            $user->otp = $otps;
            $user->otp_expiry = Carbon::now(Helper::getSettings('application_timezone'))->addMinutes(4)->format('Y-m-d H:i:s');
            $user->otp_status = 1;
            $user->save();

            $email = $request->email;
            $data['subject'] = 'Forgot Password Reset';
            $data['email'] = $email;
            $data['template'] = 'resetpassword';
            $data['user'] = $user;
            $data['otp'] = $otps;
            $data['message'] = 'Your confirmation code is below — enter it in your open browser window and we will help you get reset password. Please do not share the code others';
            Helper::sendOtpEmail($data);

            $email = $request->email;

            return view('auth.pages.otp', compact('email'));
        } else {
            return redirect()->back()->withErrors(['message' => 'There is no account with this email!']);
        }
    }

    public function otp(Request $request)
    {
        App::setLocale(Session::get('language'));
        if ($request->email && $request->otp) {
            Validator::make($request->all(), [
                'email' => 'required',
                'otp' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required_with:password|same:password|min:6',
            ]);

            $email = $request->email;

            $otp_response = Helper::checkotp($request->email, $request->otp);
            if ($otp_response['status'] == 1) {
                $user = User::where('email', $request->email)->first();
                $user->password = Hash::make($request->password);
                $user->save();

                return redirect()->route('admin')->with(['message' => 'Password changed successfully!']);
            } else {
                return view('auth.pages.otp', compact('email'))->withErrors(['message' => $otp_response['msg']]);
            }
        } else {
            return view('auth.pages.otp');
        }
    }

    public function pages($slug)
    {
        App::setLocale(Session::get('language'));
        $content = '';
        if ($slug == 'terms-and-conditions') {
            $content = Helper::getSettings('terms_and_conditions');
        } else if ($slug == 'privacy-policy') {
            $content = Helper::getSettings('privacy_policy');
        } else if ($slug == 'return-policy') {
            $content = Helper::getSettings('return_policy');
        }
        return view('frontend.pages.page', compact('slug', 'content'));
    }

    public function changeLanguage(Request $request)
    {

        $language = $request->input('language');

        Session::put('language', $language);

        return true;
    }
}
