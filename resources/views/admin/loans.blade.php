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
  
<!-- Include jsPDF and autoTable plugin via CDN -->

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

                    <a href="/admin/user" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
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

                <a href="/admin/loans" class="mx-auto font-bold text-gray-800 text-md active hover:text-gray-800/70 hover:text-gray-900">
                    Loans
                </a>                
            </div>    <div class="relative">

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
                                    <div class="flex items-end justify-between">
                                        <div class="flex items-end gap-4">
                                            <div class="flex flex-col">
                                                <p class="text-3xl font-bold">Loans</p>
                                                <div class="flex gap-5">
                                                    <div class="">

                                                        <p class="font-semibold">
                                                            Cari Buku
                                                        </p>
                                                        <input id="searchBooks" class="mb-2 search-input w-[14rem] border-none text-black font-semibold bg-[#D9D9D9] px-2 text-sm h-6" 
                                                        type="text" placeholder="Search">
                                                    </div>
                                                    <div class="">

                                                        <p class="font-semibold">
                                                            Cari User
                                                        </p>
                                                        <input id="searchUser" class="mb-2 search-input w-[14rem] border-none text-black font-semibold bg-[#D9D9D9] px-2 text-sm h-6" 
                                                        type="text" placeholder="Search">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <p>Date-1</p>
                                                <input         id="dateFilter" 
                                                class="mb-2 search-input w-[14rem] border-none text-black font-semibold bg-[#D9D9D9] px-2 text-sm h-6" 
                                                type="date">
                                            </div>
                                            <div class="">
                                                <p>Date-2</p>
                                                <input         id="dateFilter2" 
                                                class="mb-2 search-input w-[14rem] border-none text-black font-semibold bg-[#D9D9D9] px-2 text-sm h-6" 
                                                type="date">
                                            </div>
                                        </div>
                                        <button
                                        id="printButton"
                                        class="px-10 mb-[0.4rem] py-[0.1rem] mt-5 text-white bg-green-500 rounded-md hover:bg-green-700"
                                    >
                                        Print Laporan
                                    </button>
                                    </div>
                                    <div class=" overflow-x-auto overflow-y-scroll max-h-[38rem]">

                                    <table class="w-full border-collapse table-auto"  id="booksTable">
                                        <thead class="text-white border border-black bg-[#2D2D2D]">
                                            <tr>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">No</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3"colspan="2">User</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Book Title</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Tanggal Pinjam</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Tanggal Tenggat</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
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
                                                <td class="px-4 py-2 border-r border-black" data-date="{{ $loans->tanggal_pinjam }}">{{$loans->tanggal_pinjam}}</td>
                                                <td class="px-4 py-2 border-r border-black" >{{$loans->tanggal_tenggat}}</td>
                                                <td class="px-4 py-2 border-r border-black">
                                                    {{ $loans->status }}
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

        </main>
       <!-- Include jsPDF from CDN -->
<!-- Include jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- Include jsPDF AutoTable plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.4/jspdf.plugin.autotable.min.js" integrity="sha512-PRJxIx+FR3gPzyBBl9cPt62DD7owFXVcfYv0CRNFAcLZeEYfht/PpPNTKHicPs+hQlULFhH2tTWdoxnd1UGu1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
       document.getElementById("dateFilter").addEventListener("change", filterTable);
    document.getElementById("dateFilter2").addEventListener("change", filterTable);

    function filterTable() {
        const date1 = document.getElementById("dateFilter").value;
        const date2 = document.getElementById("dateFilter2").value;
        const rows = document.querySelectorAll("#tableBody tr");

        rows.forEach(row => {
            const tanggalPinjam = row.querySelector('[data-date]').getAttribute('data-date');

            // Show the row if it falls within the date range
            if (tanggalPinjam >= date1 && tanggalPinjam <= date2) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
  // Wait for the entire window to load to ensure all resources are loaded
  window.onload = function() {
    document.getElementById('printButton').addEventListener('click', function() {
      const { jsPDF } = window.jspdf; // Access jsPDF from the window object
      const doc = new jsPDF(); // Create a new PDF instance

      // Add a title to the PDF
      doc.text("Report: Loan Details", 20, 10);

      // Ensure autoTable is available
      if (typeof doc.autoTable === 'function') {
        // Use autoTable to add the table to the PDF
        doc.autoTable({
          html: '#booksTable', // Target the table by ID
          startY: 20,  // Position the table below the title
          styles: {
            fontSize: 10,  // Set font size for readability
            cellPadding: 2,  // Cell padding for spacing
          },
          columnStyles: {
            // Adjust column widths (in mm)
            0: { cellWidth: 10 },  // First column (No) width
            1: { cellWidth: 10 },  // Second column (User) width
            2: { cellWidth: 30 },  // Third column (User) width
            3: { cellWidth: 40 },  // Fourth column (Book Title) width
            4: { cellWidth: 30 },  // Fifth column (Tanggal Pinjam) width
            5: { cellWidth: 30 },  // Sixth column (Tanggal Tenggat) width
            6: { cellWidth: 30 },  // Seventh column (Status) width
          }
        });
      } else {
        console.error("autoTable plugin is not available.");
      }

      // Save the PDF with the name 'laporan-loan-details.pdf'
      doc.save('laporan-loan-details.pdf');
    });
  };



document.getElementById('dateFilter').addEventListener('input', function () {
    const selectedDate = this.value; // The selected date from the input in YYYY-MM-DD format
    const table = document.getElementById('booksTable');
    const rows = table.querySelectorAll('tbody tr');

    // Wait until the rows are fully rendered and accessible
    setTimeout(() => {
    if (!selectedDate) {
        rows.forEach(row => {
            row.style.display = ''; // Reset to default, showing all rows
        });
    } else {

            rows.forEach(row => {
                const tanggalPinjamCell = row.cells[3]; // Get the 5th column for Tanggal Pinjam
                const tanggalPinjam = tanggalPinjamCell.textContent.trim(); // Trim to remove any extra spaces
                
                console.log("Comparing:", tanggalPinjam, "with", selectedDate);
                
                // Check if the date matches
                if (tanggalPinjam === selectedDate) {
                    row.style.display = ''; // Show row if it matches
                } else {
                    row.style.display = 'none'; // Hide row if it doesn't match
                }
            });
        }
    }, 100); // Delay added to ensure the table is fully loaded
});

document.querySelectorAll('input[type="date"]').forEach(input => {
    input.addEventListener('input', function () {
        const date1 = document.querySelectorAll('input[type="date"]')[0].value; // Date-1 input
        const rows = document.querySelectorAll('#booksTable tbody tr');

        rows.forEach(row => {
            const tanggalPinjamText = row.cells[4]?.textContent.trim(); // Ensure the cell exists (adjusted for the correct column index)

            // Skip row if tanggalPinjamText is empty or invalid
            if (!tanggalPinjamText) {
                row.style.display = 'none';
                return;
            }

            // Parse both dates as ISO strings (YYYY-MM-DD)
            const tanggalPinjam = tanggalPinjamText.split('T')[0]; // Extract date part (if T included)
            const date1Parsed = date1 ? date1 : null;

            // Check if the dates are exactly the same
            const isExactMatch = tanggalPinjam >= date1Parsed;

            // Display or hide rows based on the filtering criteria
            row.style.display = isExactMatch ? '' : 'none';
        });
    });
});




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
    document.querySelector('#searchUser').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#booksTable tbody tr');

    rows.forEach(row => {
        // Get the text content of the "User" column (adjust the cell index as needed)
        const userCellText = row.cells[1].textContent.toLowerCase(); // Assuming User is in the second column (index 1)
        row.style.display = userCellText.includes(searchTerm) ? '' : 'none';
    });
});

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