<?php

namespace App\Http\Controllers\Backend\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LoanApplication;
use App\Models\LoanTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class SuperAdminLoanController extends Controller
{
    public function allLoanApplications (){

        // $loan= DB::table('loan_applications')->where('status','not_approved')->get();
        $loan= DB::table('loan_applications')->get();
        return view('super_admin.loan_application.all',compact('loan'));
    }

}
