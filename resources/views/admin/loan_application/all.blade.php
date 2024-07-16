@extends('admin.dashboard')

@section('content')


<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input {
  display: none;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  border-radius: 17px; /* Make the slider rounded */
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  border-radius: 50%; /* Make the circle rounded */
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

</style>

<div class="p-6">
    <div class="bg-white shadow-md rounded-lg p-4">
      <h2 class="text-2xl font-semibold mb-4">Loan Application Management</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border">
          <thead>
            <tr class="bg-gray-200">
              <th class="py-2 px-4 text-center">S/N</th>
              <th class="py-2 px-4 text-center">Name</th>
              <th class="py-2 px-4 text-center">Email</th>
              <th class="py-2 px-4 text-center">Amount</th>
              <th class="py-2 px-4 text-center">Bank</th>
              <th class="py-2 px-4 text-center">AC Number</th>
              <th class="py-2 px-4 text-center">Status</th>
              <th class="py-2 px-4 text-center">Action</th>
              <th class="py-2 px-4 text-center">Approve</th>

            </tr>
          </thead>
          <tbody>

            @foreach ($loan as $key => $ln)

                <tr>
                  <td class="py-2 px-4 text-center">{{ $key+1 }}</td>
                  <td class="py-2 px-4 text-center">{{ $ln->name }}</td>
                  <td class="py-2 px-4 text-center">{{ $ln->email }}</td>
                  <td class="py-2 px-4 text-center">{{ $ln->amount }}</td>
                  <td class="py-2 px-4 text-center">{{ $ln->bank }}</td>
                  <td class="py-2 px-4 text-center">{{ $ln->account }}</td>

                  @if ($ln->status == 'approved')
                    <td class="py-2 px-4 text-center">
                        <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                            Approved
                        </span>
                    </td>
                  @endif

                  @if ($ln->status == 'not_approved')
                    <td class="py-2 px-4 text-center">
                        <span class="inline-flex items-center bg-yellow-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                            Pending
                        </span>
                    </td>
                  @endif




                  {{-- <td class="py-2 px-4 text-center">
                    <form action="{{ route('user.toggle-role',$ln->id)}}" method="POST">
                        @csrf
                        <label class="switch">
                          <input type="checkbox" name="role" onchange="this.form.submit()" {{ ($ln->status == 'admin')  ? 'checked' : '' }}>
                          <span class="slider"></span>
                        </label>
                      </form>
                  </td> --}}

                  <td class="text-center" style="display: flex; justify-content: center; align-items: center;">
                 <a href="{{ route('loan.detail', $ln->id) }}" class="bg-blue-500 text-white py-1 px-3 rounded-md hover:bg-blue-600 transition duration-200">View Details</a>

                    <button type="submit" onclick="confirmDelete({{ $ln->id}})" class="bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 transition duration-200 ml-2">Delete</button>
                    <form id="delete-form-{{ $ln->id }}" action="{{ route('delete.loan.application', $ln->id)}}" method="POST" >
                      @csrf
                      @method('DELETE')
                    </form>


                        {{-- <a href="{{ route('loan.detail', $ln->id) }}" style="display: flex; justify-content: center; align-items: center; padding: 5px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="19" height="19">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>

                        </a>

                    <button type="submit" onclick="confirmDelete({{ $ln->id}})" class="bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 transition duration-200 ml-2">Delete</button>
                    <form id="delete-form-{{ $ln->id }}" action="{{ route('delete.user', $ln->id)}}" method="POST" >
                        @csrf
                        @method('DELETE')
                      </form>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="19" height="19">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                              </svg>

                        </a>  --}}

                  </td>

                  <td class="text-center">
                    <form action="{{ route('loan.toggle-status',$ln->id)}}" method="POST">
                        @csrf
                        <label class="switch">
                          <input type="checkbox" name="status" onchange="this.form.submit()" {{ ($ln->status === 'approved')  ? 'checked' : '' }}>
                          <span class="slider"></span>
                        </label>
                  </form>
                  </td>
                </tr>
            @endforeach



            <!-- Add more rows as needed -->
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection
