<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Perpus</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Styles -->
        <style>
        </style>    
          @vite('resources/css/app.css')
    </head>
    <body class="bg-white">
        <nav class="flex items-center justify-between py-6 bg-white drop-shadow-md">
            <!-- Empty div for balancing the right side -->

                   @php
            $user = auth()->user();
            @endphp
            
            @if ($user)
                <div class="w-[200px]">
                    <div class="px-5">
                        {{ $user->points }} Points
                    </div>
                </div>
            @else
                <div class="w-[200px]">
                   <div class="px-5">
                        Guest (No Points)
                    </div>
                </div>
            @endif
            <!-- Home link, perfectly centered -->
            <div class="flex items-center gap-16 px-6 ">
                <div class="relative">

                    <a href="/admin/user" class="mx-auto font-bold text-gray-800 active text-md hover:text-gray-800/70 hover:text-gray-900">
                        Users
                    </a>
                </div>
                <div class="relative">

                <a href="/admin/books" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
                    Books
                </a>
            </div>

                <div class="relative">

                    <a href="/admin/dashboard" class="mx-auto font-bold text-center text-gray-800 text-md hover:text-gray-900">
                        Dashboard
                    </a>
                </div>
                <div class="relative">

                <a href="/admin/loans" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
                    Loans
                </a>                
            </div>
   <div class="relative">

                <a href="/admin/kategori" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
                    Kategori
                </a>    
                            
            </div>

            </div>

        
            @if (Route::has('login'))
                <div class="flex items-center px-6 ">
                    @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            
                            class="rounded-md px-3 py-2 text-sm font-medium text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                        >
                            Log Out
                        </button>
                    </form>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                        >
                            Log in
                        </a>
                        <p>/</p>
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md px-3 py-2  text-sm font-medium text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                            >
                                Register
                            </a>
                    @endauth
                </div>
            @endif
        </nav>
        <main>
            <div class="flex justify-center mt-5 mb-5 "">
                <div class="w-[95%] ">
                     <div class="flex">
                        <div class="flex flex-col items-start w-full">
                            <div class="w-full mt-5">
                                <p class="text-3xl font-bold">User</p>
                                <div class="flex items-center justify-between gap-2">
                                    <input id="searchBooks" class="search-input w-[14rem] border-none text-black font-semibold bg-[#D9D9D9] px-2 text-sm h-8" 
                                    type="text" placeholder="Search Books">
                                    <button id="openModalButton"
                                    class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600">
                                        Add User
                                    </button>
                                </div>
                                
                                <div class="py-4 overflow-x-auto overflow-y-scroll max-h-[38rem]">
                                    <table class="w-full border-collapse table-auto"  id="booksTable">
                                        <thead class="text-white border border-black bg-[#2D2D2D]">
                                            <tr>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">No</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Name</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Gmail</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Role</th>

                                                <th class="px-4 py-2 text-left border-r border-black border-3">Password</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1
                                            @endphp
                                            @foreach($users as $users)
                                            <tr class="border border-b border-black hover:bg-gray-100">
                                                <td class="px-4 py-2 text-center border-r border-black center col-2">{{$no++}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$users->name}}</td>
                                                <td class="px-4 py-2 border-r border-black">
                                                   {{ $users->email }}
                                                </td>
                                                <td class="px-4 py-2 border-r border-black" >{{$users->role}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$users->password}}</td>
                                                <td class="flex justify-center gap-5 px-4 py-2 border-r border-black">
                                                    <button
                                                        class="px-4 py-2 text-white bg-yellow-300 rounded openEditModal hover:bg-yellow-400"
                                                        data-id="{{$users->id}}"

                                                        data-name="{{$users->name}}"
                                                        data-email="{{$users->email}}"
                                                        data-role="{{$users->role}}"
                                                        data-password="{{$users->password}}"
                                                        id="openEditModal"
                                                    >
                                                        Edit
                                                    </button>
                                                    <button
                                                    type="button"
                                                    class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                                                    id="openDeleteModal"
                                                    data-id="{{$users->id}}"
                                                >
                                                    Delete
                                                </button>
                                                
                                                    
                                                </td>

                                            </tr>
                                           @endforeach 
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>    
                        </div>
                
    </div>
</div>
<div
    id="openModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-[30rem] p-6">
            <h2 class="mb-4 text-lg font-semibold">Add User</h2>
            <form id="addForm" action="/add/admin/user" method="POST">
                @csrf
                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">Name:</label>
                    <input
                        type="text"
                        id="nameInputs"
                        name="name"
                        class="w-full px-3 py-2 border rounded"
                    />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700">Email:</label>
                    <input
                        type="email"
                        id="emailInputs"
                        name="email"
                        class="w-full px-3 py-2 border rounded"
                    />
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label class="block text-gray-700">Role:</label>
                    <select
                        id="roleInputs"
                        name="role"
                        class="w-full px-3 py-2 border rounded"
                    >
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700">Password:</label>
                    <input
                        type="password"
                        id="passwordInputs"
                        name="password"
                        class="w-full px-3 py-2 border rounded"
                    />
                </div>

                <!-- Hidden ID Field -->
                <input type="hidden" id="userIdInputs" name="id" />

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4">
                    <button
                        type="button"
                        id="cancelEditButtons"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<div
    id="deleteConfirmationModal"
    class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50"
>
    <div class="p-6 bg-white rounded-lg shadow-lg w-96">
        <h2 class="mb-4 text-lg font-semibold">Confirm Deletion</h2>
        <p class="mb-4 text-gray-600">
            Are you sure you want to delete this user? This action cannot be undone.
        </p>
        <form id="deleteUserForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-4">
                <button
                    type="button"
                    id="cancelDeleteButton"
                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                >
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>

<div
    id="editModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-[30rem] p-6">
            <h2 class="mb-4 text-lg font-semibold">Edit User</h2>
            <form id="editForm" action="/edit/admin/user" method="POST">
                @csrf
                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">Name:</label>
                    <input
                        type="text"
                        id="nameInput"
                        name="name"
                        class="w-full px-3 py-2 border rounded"
                    />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700">Email:</label>
                    <input
                        type="email"
                        id="emailInput"
                        name="email"
                        class="w-full px-3 py-2 border rounded"
                    />
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label class="block text-gray-700">Role:</label>
                    <select
                        id="roleInput"
                        name="role"
                        class="w-full px-3 py-2 border rounded"
                    >
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700">Password:</label>
                    <input
                        type="password"
                        id="passwordInput"
                        name="password"
                        class="w-full px-3 py-2 border rounded"
                    />
                </div>

                <!-- Hidden ID Field -->
                <input type="hidden" id="userIdInput" name="id" />

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4">
                    <button
                        type="button"
                        id="cancelEditButton"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
        </main>
        <script>
             document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.see-more').forEach(button => {
            button.addEventListener('click', event => {
                event.preventDefault();
                const td = button.closest('td');
                const shortDesc = td.querySelector('.short-desc');
                const fullDesc = td.querySelector('.full-desc');
                if (shortDesc.classList.contains('hidden')) {
                    shortDesc.classList.remove('hidden');
                    fullDesc.classList.add('hidden');
                    button.textContent = 'See more';
                } else {
                    shortDesc.classList.add('hidden');
                    fullDesc.classList.remove('hidden');
                    button.textContent = 'See less';
                }
            });
        });
    });
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("deleteConfirmationModal");
        const openDeleteButtons = document.querySelectorAll("#openDeleteModal");
        const cancelDeleteButton = document.getElementById("cancelDeleteButton");
        const deleteUserForm = document.getElementById("deleteUserForm");

        // Open modal when delete button is clicked
        openDeleteButtons.forEach(button => {
            button.addEventListener("click", () => {
                const userId = button.getAttribute("data-id");
                deleteUserForm.action = `/delete/user/${userId}`;
                modal.classList.remove("hidden");
            });
        });

        // Close modal when cancel button is clicked
        cancelDeleteButton.addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    });

function toggleNewCategoryInput() {
    const select = document.getElementById('categorySelect');
    const newCategoryInput = document.getElementById('newCategoryInput');

    if (select.value === 'new') {
        newCategoryInput.classList.remove('hidden');
        newCategoryInput.setAttribute('required', 'required');
    } else {
        newCategoryInput.classList.add('hidden');
        newCategoryInput.removeAttribute('required');
    }
}

         document.querySelectorAll('.search-input').forEach((input) => {
        input.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const tableId = this.id.replace('search', '').toLowerCase() + 'Table'; // e.g., searchBooks -> booksTable
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);

            rows.forEach(row => {
                const rowText = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                row.style.display = rowText.includes(searchTerm) ? '' : 'none';
            });
        });
    });
            // Select modal and input elements
const modal = document.getElementById("returnModal");
const modals = document.getElementById("editModal");

const openEditButton = document.querySelectorAll("#openEditModal");
const editModal = document.getElementById("editModal");

// Form fields in the modal

document.addEventListener("DOMContentLoaded", () => {
    const editModal = document.getElementById("editModal");
    const cancelEditButton = document.getElementById("cancelEditButton");
    const editButtons = document.querySelectorAll(".openEditModal");

    const nameInput = document.getElementById("nameInput");
    const emailInput = document.getElementById("emailInput");
    const roleInput = document.getElementById("roleInput");
    const passwordInput = document.getElementById("passwordInput");
    const userIdInput = document.getElementById("userIdInput");

    // Open Modal
    editButtons.forEach((button) => {
        button.addEventListener("click", () => {
            // Retrieve data attributes from the button
            const userId = button.getAttribute("data-id");
            const userName = button.getAttribute("data-name");
            const userEmail = button.getAttribute("data-email");
            const userRole = button.getAttribute("data-role");
            const userPassword = button.getAttribute("data-password");

            // Fill the modal inputs
            nameInput.value = userName;
            emailInput.value = userEmail;
            roleInput.value = userRole;
            passwordInput.value = userPassword;
            userIdInput.value = userId;

            // Show the modal
            editModal.classList.remove("hidden");
        });
    });

    // Close Modal
    cancelEditButton.addEventListener("click", () => {
        editModal.classList.add("hidden");
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const editModal = document.getElementById("openModal");
    const cancelEditButton = document.getElementById("cancelEditButtons");
    const openModal = document.getElementById("openModalButton");

    const button = document.querySelectorAll(".openEditModal");

    const nameInput = document.getElementById("nameInput");
    const emailInput = document.getElementById("emailInput");
    const roleInput = document.getElementById("roleInput");
    const passwordInput = document.getElementById("passwordInput");
    const userIdInput = document.getElementById("userIdInput");

    // Open Modal
    openModal.addEventListener("click", () => {
          
            // Show the modal
            editModal.classList.remove("hidden");
        });


    // Close Modal
    cancelEditButton.addEventListener("click", () => {
        editModal.classList.add("hidden");
    });
});




cancelModalButtonss.addEventListener("click", () => {
    modals.classList.add("hidden");
});

// Close modal
cancelModalButton.addEventListener("click", () => {
    modal.classList.add("hidden");
});

            

        </script>
        
        <!-- Tailwind CSS Styles -->
        <style>
            /* Ensure modal overlay covers the entire screen */
            #customModal {
                z-index: 1000;
            }
        </style>
        <style>
            .active::after {
                content: '';
                position: absolute;
                left:  0;
                bottom: -4px; /* Adjust as needed */
                width: 100%;
                height: 2px; /* Thickness of the underline */
                background-color: black; /* Color of the underline */
            }
            .hidden {
    display: none;
}

        </style>
        
        
    </body>
</html>