<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpus</title>
        <!-- Fonts and Styles -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">

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

                <a href="/books" class="mx-auto font-bold text-gray-800 text-md active hover:text-gray-800/70 hover:text-gray-900">
                    Books
                </a>
            </div>

                <div class="relative">

                    <a href="/" class="mx-auto font-bold text-center text-gray-800 text-md hover:text-gray-900">
                        Home
                    </a>
                </div>
                <div class="relative">

                <a href="/loans" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
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
            
            <div class="flex flex-col justify-center gap-10 ">
                <div class="flex items-center justify-center gap-10 h-[80vh]">
                    <img class="max-w-[340px]" src="{{$books->cover_img}}" alt="">
                    <div class="max-w-[80ch] h-full flex flex-col justify-center">
    
                        <p class="text-xl font-bold">{{$books->title}}</p>
                        <p class="text-sm font-semibold">{{$books->author}}</p>
                        <p class="font-bold">{{$books->category->nama_category}}</p>
                        <p class="text-sm">{{$books->desc   }}</p>
                        @php
                        
                        @endphp
                         @if (!in_array($books->id, $currentlyLoaningBooks))
                         {{-- href="/loan/{{$books->id}}" --}}
                         <button  
                         class="text-xs mt-2 bg-[#01B14B] w-full text-center text-white hover:bg-[#01B14B]/70 transition-all duration-300 py-1 px-4"
                         onclick="openLoanModal({{ $books->id }}, '{{ $books->title }}')"
                     >
                         Loan
                     </button>
                     
                         @else
                         <!-- Tombol Tidak Aktif -->
                         <button
                         class="w-full px-4 py-1 mt-2 text-xs text-center text-white bg-[#01B14B]"
                         onclick="openPdfModal('/storage/pdfs/{{$books->pdf}}')"
                         >
                         Read
                     </button>
                         @endif
                        
                    </div>
                </div>
                <div class="ml-[26rem] mb-10">
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-start">
                            <p class="text-xl font-semibold">Comments</p>
                        </div>
                        <!-- Dummy Comments -->
                        <div class="flex flex-col gap-2 w-[1100px]">
                            <div class="p-3 bg-gray-100 rounded">
                                <p class="text-sm font-semibold">John Doe:</p>
                                <p class="text-sm">Great book! Highly recommended.</p>
                            </div>
                            <div class="p-3 bg-gray-100 rounded">
                                <p class="text-sm font-semibold">Jane Smith:</p>
                                <p class="text-sm">Loved the story, very engaging!</p>
                            </div>
                            <div class="p-3 bg-gray-100 rounded">
                                <p class="text-sm font-semibold">Alex Johnson:</p>
                                <p class="text-sm">Informative and well-written.</p>
                            </div>
                        </div>
                        <!-- Add Comment Form -->
                       
                    </div>
                </div>
            </div>
          
        </main>
        <!-- PDF Modal -->
<div
id="pdfModal"
class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50"
>
<div class="relative bg-white w-[90%] max-w-4xl h-[90%] rounded shadow-lg p-4">
    <!-- Close Button -->
    <button
        class="absolute text-gray-500 top-4 right-4 hover:text-black"
        onclick="closePdfModal()"
    >
        ✖
    </button>

    <!-- PDF Viewer -->
    <div id="pdf-container ">
        <div id="canvas-container" style="display: flex;justify-content:center;"> 
            <canvas id="pdf-canvas" ></canvas>
        </div>
        <div id="controls" class="flex justify-between mt-4">
            <button
                id="prev"
                class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
            >
                Previous
            </button>
            <span id="page-info">
                Page <span id="current-page">1</span> of
                <span id="total-pages">0</span>
            </span>
            <button
                id="next"
                class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
            >
                Next
            </button>
        </div>
    </div>
    <
</div>
</div>
        <div
    id="returnModal"
    class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50"
>
    <div class="p-6 bg-white rounded-lg shadow-lg w-[40rem]">
        <h2 class="mb-4 text-lg font-semibold">Loan Book</h2>
        <form id="loanForm" action="/loans/{{$books->id}}" method="POST">
            @csrf
            <input type="hidden" name="id_buku" id="loanIdInput">
            <input type="hidden" name="due_date_days" id="dueDateDaysInput">

            <!-- Book Title -->
            <div class="mb-4">
                <label class="block text-gray-700">Book Title:</label>
                <input
                    type="text"
                    id="bookTitleInput"
                    class="w-full px-3 py-2 border rounded"
                    readonly
                />
            </div>

            <!-- Today's Date -->
            <div class="mb-4">
                <label class="block text-gray-700">Today's Date:</label>
                <input
                    type="date"
                    id="todaysDateInput"
                    name="todaysDateInput"
                    class="w-full px-3 py-2 border rounded"
                    value="{{ date('Y-m-d') }}"
                    readonly
                />
            </div>

            <!-- Due Date Selection -->
            <div class="mb-4">
                <label class="block text-gray-700">Select Due Date:</label>
                <div class="flex gap-4">
                    <label>
                        <input
                            type="radio"
                            name="due_date_option"
                            value="3"
                            data-points="5"
                            class="mr-2"
                        />
                        3 Days
                    </label>
                    <label>
                        <input
                            type="radio"
                            name="due_date_option"
                            value="7"
                            data-points="10"
                            class="mr-2"
                        />
                        7 Days
                    </label>
                    <label>
                        <input
                            type="radio"
                            name="due_date_option"
                            value="14"
                            data-points="15"
                            class="mr-2"
                        />
                        14 Days
                    </label>
                    <label>
                        <input
                            type="radio"
                            name="due_date_option"
                            value="30"
                            data-points="25"
                            class="mr-2"
                        />
                        30 Days
                    </label>
                </div>
            </div>

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
    type="button"
    class="text-xs mt-2 bg-[#01B14B] w-full text-center text-white hover:bg-[#01B14B]/70 transition-all duration-300 py-1 px-4"
    onclick="confirmLoan({{ $books->id }}, '{{ $books->title }}')"
>
    Loan
</button>

            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

 
<script>
    const dueDateOptions = document.getElementsByName('due_date_option');
    dueDateOptions.forEach(option => {
        option.addEventListener('change', function () {
            document.getElementById('dueDateDaysInput').value = this.value;
        });
    });

</script>
               
                <!-- Action Buttons -->
                
            </form>
        </div>
    </div>
    <!-- Confirmation Modal -->
<div
id="confirmModal"
class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50"
>
<div class="p-6 bg-white rounded-lg shadow-lg w-96">
    <h2 class="mb-4 text-lg font-semibold">Confirm Loan</h2>
    <p id="confirmationMessage" class="mb-4 text-gray-700">
        Are you sure you want to loan this book? This will cost you <span id="pointsCostDisplay"></span> points.
    </p>
    <div class="flex justify-end gap-4">
        <button
            type="button"
            id="cancelConfirmButton"
            class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
        >
            Cancel
        </button>
        <button
            type="button"
            id="confirmButton"
            class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600"
        >
            Confirm
        </button>
    </div>
</div>
</div>
       
        <!-- Active Class Styling -->
        <style>
            .active::after {
                content: '';
                position: absolute;
                left: 0;
                bottom: -4px;
                width: 100%;
                height: 2px;
                background-color: black;
            }
        </style>



        <script>
             // PDF.js Variables
      let pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 1,
        canvas = document.getElementById("pdf-canvas"),
        ctx = canvas.getContext("2d");

    // Open PDF Modal
    function openPdfModal(pdfUrl) {
    console.log('Opening PDF:', pdfUrl);  // Log the URL to verify it's correct
    document.getElementById("pdfModal").classList.remove("hidden");

    // Load the PDF
    pdfjsLib.getDocument(pdfUrl).promise.then((pdf) => {
        pdfDoc = pdf;
        document.getElementById("total-pages").textContent = pdf.numPages;
        renderPage(pageNum);
    }).catch((error) => {
        console.error('Error loading PDF:', error);
    });
}


    // Close PDF Modal
    function closePdfModal() {
        document.getElementById("pdfModal").classList.add("hidden");
        pageNum = 1; // Reset to first page
    }

    // Render a Page
    // Render a Page
function renderPage(num) {
    console.log(`Rendering page ${num}`); // Debug log

    pageRendering = true;

    pdfDoc.getPage(num).then((page) => {
        console.log('Page loaded successfully'); // Debug log

        const viewport = page.getViewport({ scale: scale });
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderContext = {
            canvasContext: ctx,
            viewport: viewport,
        };
        const renderTask = page.render(renderContext);

        renderTask.promise.then(() => {
            pageRendering = false;
            // Update the current page number in the page info
            document.getElementById("current-page").textContent = num;
            if (pageNumPending !== null) {
                renderPage(pageNumPending);
                pageNumPending = null;
            }
        }).catch(error => console.error('Page Render Error:', error)); // Log render errors
}
)}


    // Queue a page rendering request
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    // Show Previous Page
    document.getElementById("prev").addEventListener("click", () => {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    });

    // Show Next Page
    document.getElementById("next").addEventListener("click", () => {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    });
            // Declare variables only once
            let currentBookId, currentBookTitle, currentPointsCost;

// Function to handle the initial confirmation of loan
function confirmLoan(bookId, bookTitle) {
    // Ensure a due date is selected
    const selectedOption = document.querySelector('input[name="due_date_option"]:checked');
    if (!selectedOption) {
        alert('Please select a due date before proceeding.');
        return;
    }

    // Store book details and points cost
    currentBookId = bookId;
    currentBookTitle = bookTitle;
    currentPointsCost = selectedOption.getAttribute('data-points');

    // Update confirmation modal content
    document.getElementById('pointsCostDisplay').textContent = currentPointsCost;

    // Show confirmation modal
    document.getElementById('confirmModal').classList.remove('hidden');
}

// Event listener for the Confirm button in the confirmation modal
document.getElementById('confirmButton').addEventListener('click', function () {
    // Hide the confirmation modal
    document.getElementById('confirmModal').classList.add('hidden');

    // Submit the form after confirmation
    document.getElementById('loanForm').submit();
});

// Event listener for the Cancel button in the confirmation modal
document.getElementById('cancelConfirmButton').addEventListener('click', function () {
    // Hide the confirmation modal without submitting
    document.getElementById('confirmModal').classList.add('hidden');
});
        
            // Function to proceed to the loan modal after confirmation
            function proceedToLoanModal() {
                // Hide the confirmation modal
                document.getElementById('confirmModal').classList.add('hidden');
        
                // Populate loan modal with book details
                document.getElementById('loanIdInput').value = currentBookId;
                document.getElementById('bookTitleInput').value = currentBookTitle;
                document.getElementById('dueDateDaysInput').value = document.querySelector('input[name="due_date_option"]:checked').value;
        
                // Show the loan modal
                document.getElementById('returnModal').classList.remove('hidden');
            }
        
            // Function to open the loan modal (used in proceedToLoanModal)
            function openLoanModal(bookId, bookTitle) {
                // Populate modal with book details
                document.getElementById('loanIdInput').value = bookId;
                document.getElementById('bookTitleInput').value = bookTitle;
        
                // Show the loan modal
                document.getElementById('returnModal').classList.remove('hidden');
            }
        
            // Event listener to hide the confirmation modal
            document.getElementById('cancelConfirmButton').addEventListener('click', function () {
                document.getElementById('confirmModal').classList.add('hidden');
            });
        
            // Event listener to hide the loan modal
            document.getElementById('cancelModalButton').addEventListener('click', function () {
                document.getElementById('returnModal').classList.add('hidden');
            });
        </script>
        


    
    </body>
</html>
