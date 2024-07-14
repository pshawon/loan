@extends('admin.dashboard')

@section('content')
<div class="flex p-6 mx-auto  ">
        <div class="w-1/2 bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl font-semibold mb-4">Loan Management</h2>
            <form method="POST" action="{{ route('admin.update.loan-type',$loanType->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                <div class="flex">
                        <input type="text" id="loanType" name="loanType" value="{{ $loanType->name }}" class="bg-gray-100 p-2 mt-1 block w-1/2  mr-2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                        <input type="text" id="interestRate" name="interestRate" value="{{ $loanType->interest_rate }}" class="bg-gray-100 p-2 mt-1 block w-1/2  mr-2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                    </div>
                    <!-- <input type="text" id="loanType" name="loanType" value="{{ $loanType->name }}" placeholder="Loan type" class="bg-gray-100 p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300"> -->
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">Update</button>
            </form>
        </div>
    </div>

@endsection