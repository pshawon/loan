<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanTypes;

class LoanTypesController extends Controller
{
    public function allLoanTypes (){
        $loan_type= LoanTypes::all();

        return view('admin.loan_type.all_loan_type',compact('loan_type'));       
    }

    public function addLoanTypes( Request $request){
        $validateData= $request->validate([
            'loanType' => 'required',
            'interestRate' => 'required',
        ]);
        $loan_type= new LoanTypes();
        $loan_type-> insert ([
            'name' => $validateData['loanType'],
            'interest_rate' => $validateData['interestRate'],
            'created_at' => now(),
            'updated_at' => now(),

        ]);      
        toastr()->success('Loan Type has been added successfully!');
        return redirect()->back();


    }

    public function deleteLoanType (LoanTypes $loan_type){
        
        $loan_type->delete();
        toastr ()->success('Loan Type Deleted Successfully');
        return redirect()->back();
    }


    public function editLoanType ($id){
        $loanType= LoanTypes::findOrFail($id);
        return view('admin.loan_type.edit',compact('loanType'));

    }

    public function updateLoanType(Request $request, $id){
        $loanType= LoanTypes::findOrFail($id);
        $validateData= $request->validate([
            'loanType' => 'required',
            'interestRate' => 'required',
        ]);

        $loanType-> update ([
            'name' => $validateData['loanType'],
            'interest_rate' => $validateData['interestRate'],
        ]);
        
        toastr()->success('Loan Type has been updated successfully!');
        return redirect()->route('admin.all.loan-types');
    }
}
