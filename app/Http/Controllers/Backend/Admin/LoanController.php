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
    // public function allLoanApplications (){

    //     // $loan= DB::table('loan_applications')->where('status','not_approved')->get();
    //     $loan= DB::table('loan_applications')->get();
    //     return view('admin.loan_application.all',compact('loan'));
    // }

    // public function allLoanApplications(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $columns = ['id', 'name', 'email', 'amount', 'bank', 'account', 'status'];

    //         $totalData = LoanApplication::count();
    //         $totalFiltered = $totalData;

    //         $limit = $request->input('length');
    //         $start = $request->input('start');
    //         $order = $columns[$request->input('order.0.column')];
    //         $dir = $request->input('order.0.dir');

    //         if (empty($request->input('search.value'))) {
    //             $loans = LoanApplication::offset($start)
    //                 ->limit($limit)
    //                 ->orderBy($order, $dir)
    //                 ->get();
    //         } else {
    //             $search = $request->input('search.value');

    //             $loans = LoanApplication::where(function($query) use ($search) {
    //                 $query->where('name', 'LIKE', "%{$search}%")
    //                       ->orWhere('email', 'LIKE', "%{$search}%")
    //                       ->orWhere('amount', 'LIKE', "%{$search}%")
    //                       ->orWhere('bank', 'LIKE', "%{$search}%")
    //                       ->orWhere('account', 'LIKE', "%{$search}%");

    //             })
    //             ->offset($start)
    //             ->limit($limit)
    //             ->orderBy($order, $dir)
    //             ->get();

    //             $totalFiltered = LoanApplication::where(function($query) use ($search) {
    //                 $query->where('name', 'LIKE', "%{$search}%")
    //                       ->orWhere('email', 'LIKE', "%{$search}%")
    //                       ->orWhere('amount', 'LIKE', "%{$search}%")
    //                       ->orWhere('bank', 'LIKE', "%{$search}%")
    //                       ->orWhere('account', 'LIKE', "%{$search}%");

    //             })->count();
    //         }

    //         $data = [];
    //         if (!empty($loans)) {
    //             foreach ($loans as $loan) {
    //                 $nestedData['id'] = $loan->id;
    //                 $nestedData['name'] = $loan->name;
    //                 $nestedData['email'] = $loan->email;
    //                 $nestedData['amount'] = $loan->amount;
    //                 $nestedData['bank'] = $loan->bank;
    //                 $nestedData['account'] = $loan->account;
    //                 // $nestedData['status'] = $loan->status;
    //                 $nestedData['status'] = $this->formatStatus($loan->status);

    //                 $viewBtn = '<a href="'.route('loan.detail', $loan->id).'" class="bg-blue-500 text-white py-1 px-3 rounded-md hover:bg-blue-600 transition duration-200">View Details</a>';
    //                 $deleteBtn = '<button type="submit" onclick="confirmDeleteLoanType('.$loan->id.')" class="bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 transition duration-200 ml-2">Delete</button>';
    //                 $deleteForm = '<form id="delete-form-'.$loan->id.'" action="'.route('delete.loan.application', $loan->id).'" method="POST" style="display:none;">'.csrf_field().method_field('DELETE').'</form>';
    //                 $nestedData['action'] = $viewBtn . $deleteBtn . $deleteForm;

    //                 $checked = ($loan->status === 'approved') ? 'checked' : '';
    //                 $nestedData['approve'] = '<form action="'.route('loan.toggle-status', $loan->id).'" method="POST">'.csrf_field().'<label class="switch"><input type="checkbox" name="status" onchange="this.form.submit()" '.$checked.'><span class="slider"></span></label></form>';

    //                 $data[] = $nestedData;
    //             }
    //         }


    //         $json_data = [
    //             "draw" => intval($request->input('draw')),
    //             "recordsTotal" => intval($totalData),
    //             "recordsFiltered" => intval($totalFiltered),
    //             "data" => $data
    //         ];

    //         return response()->json($json_data);
    //     }



    //     return view('admin.loan_application.all');
    // }

    public function allLoanApplications(Request $request){

    if ($request->ajax()) {
        $columns = ['id', 'name', 'email', 'amount', 'bank', 'account', 'status'];

        $totalData = LoanApplication::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $column = $request->input('column');
        $search = $request->input('search');
        $status= $request -> input('status');



        $query = LoanApplication::query();

        if ($status !== 'all') {
            $query->where('status', $status === 'approved' ? 'approved' : 'not_approved');
        }

        if (!empty($search)) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('amount', 'LIKE', "%{$search}%")
                      ->orWhere('bank', 'LIKE', "%{$search}%")
                      ->orWhere('account', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $loans = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        $serialNumber = $start + 1;

        if (!empty($loans)) {
            foreach ($loans as $key => $loan) {

                $nestedData['id'] = $serialNumber++ ;
                $nestedData['name'] = $loan->name;
                $nestedData['email'] = $loan->email;
                $nestedData['amount'] = $loan->amount;
                $nestedData['bank'] = $loan->bank;
                $nestedData['account'] = $loan->account;
                $nestedData['status'] = $this->formatStatus($loan->status);

                $viewBtn = '<a href="'.route('loan.detail', $loan->id).'" class="bg-blue-500 text-white py-1 px-3 rounded-md hover:bg-blue-600 transition duration-200">View Details</a>';
                $deleteBtn = '<button type="submit" onclick="confirmDeleteLoanType('.$loan->id.')" class="bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 transition duration-200 ml-2">Delete</button>';
                $deleteForm = '<form id="delete-form-'.$loan->id.'" action="'.route('delete.loan.application', $loan->id).'" method="POST" style="display:none;">'.csrf_field().method_field('DELETE').'</form>';
                $nestedData['action'] = $viewBtn . $deleteBtn . $deleteForm;

                $checked = ($loan->status === 'approved') ? 'checked' : '';
                $nestedData['approve'] = '<form action="'.route('loan.toggle-status', $loan->id).'" method="POST">'.csrf_field().'<label class="switch"><input type="checkbox" name="status" onchange="this.form.submit()" '.$checked.'><span class="slider"></span></label></form>';

                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }

    return view('admin.loan_application.all');
}



    private function  formatStatus($status){
        if ($status === 'approved') {
            return '<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.1 rounded-full dark:bg-green-900 dark:text-green-300"><span class="w-2 h-2 bg-green-500 rounded-full"></span> Approved</span>';
        } elseif ($status === 'not_approved') {
            return '<span class="inline-flex items-center bg-yellow-100 text-green-800 text-xs font-medium px-2.5 py-0.1 rounded-full dark:bg-green-900 dark:text-green-300"><span class="w-2 h-2 bg-green-500 rounded-full"></span> Pending</span>';
        }
        return $status;

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
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank' => 'required',
            'account_no' => 'required|integer|min:1',
            'installment_counts' => 'required|integer|min:1',
            'installment_amount' => 'required|numeric',
            'amount_payable' => 'required|numeric',
        ]);

        $loan_type = LoanTypes :: findOrFail($request->loan_type);
        if ( $request -> interest_rate != $loan_type -> interest_rate) {
            return redirect()->back()->withErrors(['interest_rate' => 'Interest rate is invalid.']);

        }

        $amount = $request->amount;
        $installmentCounts = $request->installment_counts;
        $interestRate = $loan_type->interest_rate;

        $expectedInstallmentAmount = ($amount * (1 + $interestRate / 100)) / $installmentCounts;
        $expectedAmountPayable = $amount * (1 + $interestRate / 100);

        if (abs($request->installment_amount - $expectedInstallmentAmount) > 0.01 ||
            abs($request->amount_payable - $expectedAmountPayable) > 0.01) {
            return redirect()->back()->withErrors(['calculation' => 'Calculated values are invalid.']);
        }



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
        $loanType= LoanTypes::findOrFail($loan->loan_type);
        $interest_rate= $loanType->interest_rate;
        return view('admin.loan_application.detail',compact('loan','interest_rate'));


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

    public function deleteLoanApplication($loan){
        $loan= LoanApplication::findOrFail($loan);
        $loan->delete();
        // toastr ()->success('Loan Application Deleted Successfully','Congrats');
        // return redirect()->back();
        return response()->json(['success' => 'Loan Application deleted successfully.']);

    }

    public function search(Request $request)
{
    $column = $request->column;
    $value = $request->value;

    $loans = LoanApplication::where($column, 'LIKE', "%$value%")->get();

    return response()->json(['loans' => $loans]);
}
}
