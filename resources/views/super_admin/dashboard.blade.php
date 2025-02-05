<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css" rel="stylesheet">




</head>
<body>
    <div class="flex flex-col h-screen bg-gray-100">


        <!-- Header -->
        @include('super_admin.sections.header')

        <!-- Main Content -->
        <div class="flex-1">
            <div class="flex h-full">

                <!-- Sidebar -->
               @include('super_admin.sections.sidebar')

                <!-- Page content -->
                <div class="flex-1 p-10">
                    <!-- Page content goes here -->
                     @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('super_admin.sections.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>



    <script>
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        profileButton.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
        });

        window.addEventListener('click', (event) => {
            if (!profileDropdown.contains(event.target) && !profileButton.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
    </script>

<script>
    function previewImage() {
    const fileInput = document.getElementById('profileImage');
    const imagePreview = document.getElementById('selectedImage');
    const profilePreview = document.getElementById('profilePreview');

    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = (e) => {
        imagePreview.src = e.target.result;
        profilePreview.src = e.target.result;
        };

        reader.readAsDataURL(file);
        }
    }
</script>


<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#loanTable').DataTable();
    });

    function confirmDelete(userId) {
        Swal.fire({
            title: "Confirm Delete",
            text: "Are you sure you want to delete this user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {


                document.getElementById('delete-form-' +userId).submit();

                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
                });
            }
            });

    }
</script>

<script>
    function confirmDeleteLoanType(ltId) {
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


                document.getElementById('delete-form-' +ltId).submit();

                Swal.fire({
                title: "Deleted!",
                text: "Loan Type has been deleted.",
                icon: "success"
                });
            }
            });

    }




</script>

</body>
</html>
