@extends('admin.dashboard')

@section('content')

<div class="flex p-6 mx-auto  ">
        <div class="w-1/2 bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl font-semibold mb-4">Loan Management</h2>
            <form method="POST" action="{{ route('admin.add.loan-types') }}">
                @csrf
                <div class="mb-4">
                    <div class="flex">
                        <input type="text" id="loanType" name="loanType" placeholder="Loan type" class="bg-gray-100 p-2 mt-1 block w-1/2  mr-2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                        <input type="text" id="interestRate" name="interestRate" placeholder="Interest Rate" class="bg-gray-100 p-2 mt-1 block w-1/2  mr-2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300">
                    </div>
                </div>

                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">Submit</button>
            </form>
        </div>
        <div class="w-1/2 ml-4 bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl font-semibold mb-4">Loan Type Records</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-center">S/L</th>
                        <th class="px-4 py-2 text-center">Loan Type</th>
                        <th class="px-4 py-2 text-center">Interest</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loan_type as $key => $lt )
                    @csrf

                    <!-- Loop through the records and display them in the table -->
                    <tr>
                        <td class="px-4 py-2 text-center">{{ $key + 1}}</td>
                        <td class="px-4 py-2 text-center">{{ $lt -> name}}</td>
                        <td class="px-4 py-2 text-center">{{ $lt -> interest_rate}}</td>
                        <td class="px-4 py-2 text-center">
                        <a href="{{ route('admin.edit.loan-type', $lt->id)}}" class="bg-blue-500 text-white py-1 px-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50">Update</a>



                            <button type="submit" onclick="confirmDeleteLoanType({{ $lt->id}})" class="bg-red-500 text-white py-1 px-2 rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-200 focus:ring-opacity-50">Delete</button>
                                <form id="delete-form-{{ $lt->id }}" action="{{ route('delete.loan_type', $lt->id)}}" method="POST" >
                                    @csrf
                                    @method('DELETE')
                                </form>
                        </td>
                    </tr>
                    @endforeach

                    <!-- Add more records as needed -->
                </tbody>
            </table>
        </div>
    </div>


@endsection
