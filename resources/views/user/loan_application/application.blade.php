@extends('user.dashboard')

@section('content')


<div class="p-6 mx-auto max-w-3xl">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Loan Application</h2>
            <form action="{{ route('user.loan.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">There were some problems with your input.</span>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-1">
                        <label for="amount" class="block text-gray-700 font-medium">Loan Amount</label>
                        <input type="text" id="amount" name="amount" placeholder="Enter loan amount" oninput="calculateInstallment()" class="bg-gray-200 p-2 mt-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="bank" class="block text-gray-700 font-medium">Bank</label>
                        <select id="bank" name="bank" class="bg-gray-200 p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                            <option selected>Select bank</option>
                            @foreach ( $bankNames as $bankName )
                            <option value="{{ $bankName }}">{{ $bankName }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-span-2 sm:col-span-1">
                        <label for="account_no" class="block text-gray-700 font-medium">Account Number</label>
                        <input type="text" id="account_no" name="account_no" placeholder="Enter account number" class="bg-gray-200 p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="loan_type" class="block text-gray-700 font-medium">Loan Type</label>
                        <select id="loan_type" name="loan_type" class="bg-gray-200 p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                            <option selected>Select Loan Type</option>
                            @foreach ( $loan_types as $lt )
                            <option value="{{ $lt->id }}" data-interest-rate="{{ $lt->interest_rate }}"> {{ $lt->name }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="amount" class="block text-gray-700 font-medium">Installment Count</label>
                        <input type="text" id="installment_counts" name="installment_counts" placeholder="Installment Count" oninput="calculateInstallment()" class="bg-gray-200 p-2 mt-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="interest_rate" class="block text-gray-700 font-medium">Interest Rate</label>
                        <input type="text" id="interest_rate" name="interest_rate" value=""  placeholder="Interest Rate"  class="bg-gray-200 p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300" readonly>
                    </div>


                    <div class="col-span-2 sm:col-span-1">
                        <label for="bank" class="block text-gray-700 font-medium">Installment Amount</label>
                        <input type="text" id="installment_amount" name="installment_amount" placeholder="Installment Amount" class="bg-gray-200 p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300" readonly>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="bank" class="block text-gray-700 font-medium">Amount (+ Interest)</label>
                        <input type="text" id="amount_payable" name="amount_payable" placeholder="Amount (+10%)"  class="bg-gray-200 p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300" readonly>
                    </div>
                    <!-- Other input fields ... -->
                </div>
                <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">Submit</button>
            </form>
        </div>
    </div>

@endsection
