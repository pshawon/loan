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
        border-radius: 17px;
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
        border-radius: 50%;
        transition: 0.4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    /* Align search and show entries in the same line */
    .dataTables_wrapper .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .dataTables_wrapper .top .dataTables_length,
    .dataTables_wrapper .top .dataTables_filter {
        display: inline-block;
        margin: 0;
    }
</style>

<!-- Include jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<div class="p-6">
    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-2xl font-semibold mb-4">Loan Application Management</h2>
        <div class="overflow-x-auto">
            <div id="loanTable_wrapper" class="dataTables_wrapper">
                <div class="dataTables_filter" id="column_search">
                    <label for="status-select">Status:
                        <select id="status-select" class="border border-gray-300 rounded p-1 ml-2">
                            <option value="all">All</option>
                            <option value="approved">Approved</option>
                            <option value="not_approved">Pending</option>
                        </select>
                    </label>
                    <label><input type="text" id="search-input" class="border border-gray-300 rounded p-1 ml-2" placeholder="Search..."></label>
                </div>
                <table id="loanTable" class="min-w-full table-auto border">
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
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#loanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.all.loan-applications') }}",
                type: "GET",
                data: function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.search = $('#search-input').val();
                    d.status = $('#status-select').val(); // Add status filter
                }
            },
            dom: '<"top"l>rt<"bottom"ip><"clear">',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'amount', name: 'amount' },
                { data: 'bank', name: 'bank' },
                { data: 'account', name: 'account' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
                { data: 'approve', name: 'approve', orderable: false, searchable: false },
            ]
        });

        $('#search-input').on('keyup', function() {
            table.ajax.reload();
        });

        $('#status-select').on('change', function() {
            table.ajax.reload();
        });

        window.confirmDeleteLoanType = function(ltId) {
            Swal.fire({
                title: "Confirm Delete",
                text: "Are you sure you want to delete this loan type?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('delete.loan.application', '') }}/' + ltId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            table.ajax.reload(null, false); // false to keep the current paging
                            Swal.fire({
                                title: "Deleted!",
                                text: "Loan Type has been deleted.",
                                icon: "success"
                            });
                        }
                    });
                }
            });
        }
    });
</script>
@endsection
