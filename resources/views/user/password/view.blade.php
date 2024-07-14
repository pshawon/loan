@extends('user.dashboard')

@section('content')

<div class="p-6">
    <div class="bg-white shadow-md rounded-lg p-4">
      <h2 class="text-2xl font-semibold mb-4">Update Password</h2>
      
      <form class="mt-6" method="POST" action="{{ route('user.password.store') }}">
        @csrf

        @if ( $errors->has('current_password') || $errors->has('password') )
        <div>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul>
                    @if ( $errors->has('current_password') )
                        <li>{{ $errors->first('current_password') }}</li>
                    @endif
                    @if ( $errors->has('password') )
                        <li>{{ $errors->first('password') }}</li>
                    @endif
                </ul>
            </div>
        </div>
            
        @endif

        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-medium">Current Password</label>
          <input type="password" id="password"  name="current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 bg-gray-200 p-2">
        </div>
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-medium">New Password</label>
          <input type="password" id="password"  name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 bg-gray-200 p-2">
        </div>

        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-medium">Confirm Password</label>
          <input type="password" id="password_confirmation"  name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 bg-gray-200 p-2">
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50">Save Changes</button>
      </form>
    </div>
  </div>


@endsection