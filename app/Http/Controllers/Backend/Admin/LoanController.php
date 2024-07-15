<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\LoanTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function allLoanApplications (){

        $loan= DB::table('loan_applications')->where('status','not_approved')->get();
        return view('admin.loan_application.all',compact('loan'));
    }

    public function allApprovedLoans(){
        $loan= DB::table('loan_applications')->where('status','approved')->get();
        return view('admin.loan_application.approved',compact('loan'));

    }

    public function loanApplication (){

        $loan_types= LoanTypes::all();
                $jsonPath = storage_path('app/banks_in_bangladesh.json');

                if (!file_exists($jsonPath)) {
                    abort(404, 'File not found');
                }

                $jsonContent = file_get_contents($jsonPath);
                $dataArray = json_decode($jsonContent, true);
                $bankNames = array_column($dataArray, 'BankName');

        return view ('user.loan_application.application',compact('loan_types','bankNames'));
    }

    public function loanStore (Request $request){
        $id= Auth::user()->id;
        $data= User::find ($id);
        $today= Carbon::now();
        $formateDate= $today->format('Y-m-d');
        LoanApplication:: insert ([
            'name'=> $data->name,
            'email'=> $data->email,
            'amount'=> $request->amount,
            'bank'=> $request->bank,
            'account'=> $request->account_no,
            'loan_type'=> $request->loan_type,
            'installment_count'=> $request->installment_counts,
            'installment_amount'=> $request->installment_amount,
            'amount_payable'=> $request->amount_payable,
            'date_applied'=> $formateDate,
            'status'=> 'not_approved',
        ]);

        toastr ()->success('Loan Applied successfully!');
        return redirect()->back();
    }

    public function loanDetail($id){

        $loan= LoanApplication::findOrFail($id);
        return view('admin.loan_application.detail',compact('loan'));


    }

    public function toggleStatus(Request $request,$id){

        $loan= LoanApplication::findOrFail($id);
        $loan->status= ($request->has('status')) ? 'approved' : 'not_approved';
        $loan->save();
        toastr ()->success('Loan Status Updated Successfully','Congrats');
        return redirect()->back();

    }

    public function approvedLoan(){

        $email= Auth::user()->email;
        $loan= DB::table('loan_applications')->where('email',$email)->where('status','approved')->get();
        return view('user.loan_application.approved',compact('loan'));

    }
}
