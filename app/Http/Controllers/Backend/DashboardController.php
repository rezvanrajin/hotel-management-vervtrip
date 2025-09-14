<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Approved;
use App\Models\Job;
use App\Models\JobParticipant;
use App\Models\Order;
use App\Models\RequisitionModel;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Helper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function home() {
        if (Auth::user()) {
            return redirect(route('admin.index'));
        } else {
            return redirect(route('login'));
        }
    }

    public function index()
    {

        // return $data;
        return view('backend.pages.dashboard.index');
    }

   
}
