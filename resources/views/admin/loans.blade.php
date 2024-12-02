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
                    <div class="">
                        Guest (No Points)
                    </div>
                </div>
            @endif
            <!-- Home link, perfectly centered -->
            <div class="flex items-center gap-16 px-6 ">
                <div class="relative">

                <a href="/admin/books" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
                    Books
                </a>
            </div>

                <div class="relative">

                    <a href="/admin/dashboard" class="mx-auto font-bold text-center text-gray-800 text-md  hover:text-gray-900">
                        Dashboard
                    </a>
                </div>
                <div class="relative">

                <a href="/admin/loans" class="mx-auto font-bold text-gray-800 text-md active hover:text-gray-800/70 hover:text-gray-900">
                    Loans
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
                                <p class="text-3xl font-bold">Loans</p>
                                <div class="py-4 overflow-x-auto overflow-y-scroll max-h-[38rem]">
                                    <table class="w-full border-collapse table-auto"  id="booksTable">
                                        <thead class="text-white border border-black bg-[#2D2D2D]">
                                            <tr>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">No</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3"colspan="2">User</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Book Title</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Tanggal Pinjam</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Tanggal Tenggat</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Status</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Tanggal Pengembalian</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Keadaan</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Denda</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1
                                            @endphp
                                            @foreach($loans as $loans)
                                            <tr class="border border-b border-black hover:bg-gray-100">
                                                <td class="px-4 py-2 text-center border-r border-black center col-2">{{$no++}}</td>
                                                <td class="px-4 py-2 border-r border-black" colspan="2">{{$loans->user->name}}</td>
                                                <td class="px-4 py-2 border-r border-black">
                                                    {{ $loans->book->title }}
                                                </td>
                                                <td class="px-4 py-2 border-r border-black" >{{$loans->tanggal_pinjam}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$loans->tanggal_tenggat}}</td>
                                                <td class="px-4 py-2 border-r border-black">
                                                    {{ $loans->status }}
                                                </td>
                                                <td class="px-4 py-2 border-r border-black">            
                                                    {{ $loans->returns?->tanggal_pengembalian ?? '-' }}
                                                </td>
                                                <td class="px-4 py-2 border-r border-black">                        
                                                    {{ $loans->returns?->keadaan ?? '-' }}
                                                    
                                                </td>
                                                <td class="px-4 py-2 border-r border-black">                        
                                                    {{ $loans->returns?->denda ?? '-' }}

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
    id="returnModal"
    class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50"
>
    <div class="p-6 bg-white rounded-lg shadow-lg w-96">
        <h2 class="mb-4 text-lg font-semibold">Return Book</h2>
        <form id="returnForm" action="/add/admin/loans" method="POST">
            @csrf

            <!-- Book Title -->
            <div class="mb-4">
                <label class="block text-gray-700">Book Title:</label>
                <input
                    type="text"
                    id="titles"
                    name="title"
                    class="w-full px-3 py-2 border rounded"
                        
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <input
                    type="text"
                    id="descs"
                    name="desc"
                    class="w-full px-3 py-2 border rounded"
                    
                />
            </div>

            <!-- Tanggal Tenggat -->
            <div class="mb-4">
                    <label class="block text-gray-700">Author</label>
                <input
                    type="text"
                    id="authors"
                    name="author"
                    class="w-full px-3 py-2 border rounded"
                        
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Category</label>
                <select
                    name="Category"
                    class="w-full px-3 py-2 border rounded"
                    id="categorySelects"
                    onchange="toggleNewCategoryInput()"
                >
                    
                    <option value="new">Add New Category</option>
                </select>
            
                <input
                    type="text"
                    id="newCategoryInputs"
                    name="newCategory"
                    placeholder="Enter new category"
                    class="hidden w-full px-3 py-2 mt-2 border rounded"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Cover</label>
                <input
                    type="file"
                    id="coverInputs"
                    name="cover"
                    class="w-full px-3 py-2 border rounded"
                    onchange="uploadImageToCloudinary(this)"
                />
            </div>
            <div id="spinner" class="flex items-center justify-center hidden mt-4">
                <div class="w-8 h-8 border-t-2 border-b-2 border-blue-500 rounded-full animate-spin"></div>
                <span class="ml-2 text-blue-500">Uploading...</span>
            </div>
            <input type="hidden" id="uploadedImageUrl" name="uploadedImageUrl" />

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4">
                <button
                    type="button"
                    id="cancelModalButton"
                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600"
                >
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>
<div
    id="editModal"
    class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50"
>
    <div class="p-6 bg-white rounded-lg shadow-lg w-96">
        <h2 class="mb-4 text-lg font-semibold">Edit Book</h2>
        <form id="returnForm" action="/edit/admin/books" method="POST">
            @csrf

            <!-- Book Title -->
            <div class="mb-4">
                <label class="block text-gray-700">Book Title:</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 border rounded" />

            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <input type="text" id="desc" name="desc" class="w-full px-3 py-2 border rounded" />

            </div>

            <!-- Tanggal Tenggat -->
            <div class="mb-4">
                    <label class="block text-gray-700">Author</label>
                    <input type="text" id="author" name="author" class="w-full px-3 py-2 border rounded" />

            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Category</label>
                    <select
                        name="Category"
                        class="w-full px-3 py-2 border rounded"
                        id="categorySelect"
                        onchange="toggleNewCategoryInput()"
                    >
                      
                        <option value="new">Add New Category</option>
                    </select>
            
                <input
                    type="text"
                    id="newCategoryInput"
                    name="newCategory"
                    placeholder="Enter new category"
                    class="hidden w-full px-3 py-2 mt-2 border rounded"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Cover</label>
                <input
                    type="file"
                    id="coverInput"
                    name="cover"
                    class="w-full px-3 py-2 border rounded"
                    onchange="uploadImageToCloudinary(this)"
                />
            </div>
            <div id="spinner" class="flex items-center justify-center hidden mt-4">
                <div class="w-8 h-8 border-t-2 border-b-2 border-blue-500 rounded-full animate-spin"></div>
                <span class="ml-2 text-blue-500">Uploading...</span>
            </div>
            <input type="hidden" id="uploadedImageUrls" name="uploadedImageUrl" />
            <input type="hidden" id="id" name="id" />

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4">
                <button
                    type="button"
                    id="cancelModalButtonss"
                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600"
                >
                    Confirm
                </button>
            </div>
        </form>
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
async function uploadImageToCloudinary(input) {
    const file = input.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);
    formData.append('upload_preset', 'my_upload_preset'); // Replace with your Cloudinary upload preset
    const spinner = document.getElementById('spinner');
    spinner.classList.remove('hidden'); // Show the spinner
    try {
        const response = await fetch('https://api.cloudinary.com/v1_1/dezla8wit/image/upload', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (response.ok) {
            document.getElementById('uploadedImageUrl').value = data.secure_url;
            alert('Image uploaded successfully!');
        } else {
            alert('Image upload failed: ' + data.error.message);
        }
    } catch (err) {
        console.error(err);
        alert('An error occurred while uploading the image.');
    }finally {
        spinner.classList.add('hidden'); // Hide the spinner
    }
}
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
const titleInput = document.getElementById("title");
const authorInput = document.getElementById("author");
const descInput = document.getElementById("desc");
const categorySelect = document.getElementById("categorySelect");
const newCategoryInput = document.getElementById("desc");

const openModalButtons = document.querySelectorAll("#openModalButton");

const cancelModalButton = document.getElementById("cancelModalButton");
const cancelModalButtonss = document.getElementById("cancelModalButtonss");
const dendaInput = document.getElementById("dendaInput");
// Open modal with autofilled data
openEditButton.forEach((button) => {
    button.addEventListener("click", () => {
        // Retrieve data attributes
        const bookId = button.getAttribute("data-id");
        const title = button.getAttribute("data-title");
        const desc = button.getAttribute("data-desc");
        const cover = button.getAttribute("data-cover");
        const author = button.getAttribute("data-author");
        const categoryId = button.getAttribute("data-category");

        // Debugging: Log to check if data is correctly retrieved
        console.log("Title:", title, "Author:", author, "Description:", desc, "Category ID:", categoryId, "cover:", cover);

        // Populate modal inputs
        titleInput.value = title;
        document.getElementById("id").value = bookId;
        document.getElementById("author").value = author || "";
        document.getElementById("desc").value = desc || "";
        document.getElementById("uploadedImageUrls").value = cover || "";
        const categorySelect = document.getElementById("categorySelect");

        // Set category or show new category input
        // Set category or show new category input
        if (categoryId === "new") {
            document.getElementById("newCategoryInput").classList.remove("hidden");
            document.getElementById("newCategoryInput").value = ""; // Clear new category input
        } else {
            document.getElementById("newCategoryInput").classList.add("hidden");
            categorySelect.value = categoryId || ""; // Set existing category as selected
        }


        // Show the modal
        document.getElementById("editModal").classList.remove("hidden");
    });
});





openModalButtons.forEach((button) => {
    button.addEventListener("click", () => {
        modal.classList.remove("hidden");
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