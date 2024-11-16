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

                <div class="w-[200px] ">
                    
                </div>
            <!-- Home link, perfectly centered -->
            <div class="flex items-center gap-16 px-6 ">
                <div class="relative">

                <a href="/books" class="mx-auto font-bold text-gray-800 text-md active hover:text-gray-800/70 hover:text-gray-900">
                    Books
                </a>
            </div>

                <div class="relative">

                    <a href="/" class="mx-auto font-bold text-center text-gray-800 text-md  hover:text-gray-900">
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
            <div class="flex justify-center mt-5">
                <div class="w-[95%]">
                    <p class="text-2xl font-bold">Explore Books!</p>
                    <div class="flex gap-10 mt-10">
                        <div>
                            <p class="font-semibold">Genre/Category</p>
                            <select name="genre" class="w-60" id="genreSelect">
                                <option value="" class="text-black/50" selected>Genre.....</option>
                                @foreach($categories as $category)
                                <option value="{{$category->nama_category}}">{{$category->nama_category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <p class="font-semibold">Authors</p>
                            <select name="authors" class="w-60" id="authorSelect">
                                <option value="" class="text-black/50" selected>Authors.....</option>
                                @foreach($authors as $author)
                                <option value="{{$author->author}}">{{$author->author}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-7 gap-5 mt-8" id="bookContainer">
                        @foreach($books as $book)
                        <div class="flex flex-col w-[200px] justify-center book" data-genre="{{$book->category->nama_category}}" data-author="{{$book->author}}">
                            <!-- Gambar Buku -->
                            <a href="/loan/{{$book->id}}">

                                <img 
                                    src="{{$book->cover_img}}" 
                                    class="w-[200px] h-[300px] object-cover {{ $book->status !== 'Available' ? 'grayscale opacity-50' : '' }}" 
                                    alt="">
                            </a>
                            <div>
                                <p class="font-bold text-sm">{{$book->title}}</p>
                                <p class="text-xs opacity-70 font-semibold">{{$book->author}}</p>
                                <p class="text-xs opacity-70 font-semibold">Category: {{$book->category->nama_category}}</p>
                            </div>
                            <div class="flex justify-center w-full">
                                @if($book->status == 'Available')
                                <!-- Tombol Loan -->
                                <a href="/loan/{{$book->id}}" class="text-xs mt-2 bg-[#01B14B] w-full text-center text-white hover:bg-[#01B14B]/70 transition-all duration-300 py-1 px-4">
                                    Loan
                                </a>
                                @else
                                <!-- Tombol Tidak Aktif -->
                                <button disabled class="text-xs mt-2 bg-gray-400 w-full text-center text-white py-1 px-4 cursor-not-allowed">
                                    Unavailable
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>

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

        <!-- JavaScript for Filtering -->
        <script>
            function getQueryParams() {
                const params = new URLSearchParams(window.location.search);
                const category = params.get('category') ? params.get('category').replace(/['"]/g, '').trim() : ""; // Remove single quotes and trim
                const author = params.get('author') ? params.get('author').replace(/['"]/g, '').trim() : ""; // Handle author similarly
                return { category, author };
            }
        
            function filterBooks() {
                const selectedGenre = document.getElementById('genreSelect').value;
                const selectedAuthor = document.getElementById('authorSelect').value;
                const books = document.querySelectorAll('.book');

                // Remove URL parameters
                const params = new URLSearchParams(window.location.search);
                
                if (selectedGenre) {
                    params.set('category', selectedGenre);
                } else {
                    params.delete('category'); // Remove genre parameter if none is selected
                }

                if (selectedAuthor) {
                    params.set('author', selectedAuthor);
                } else {
                    params.delete('author'); // Remove author parameter if none is selected
                }

                // Update the URL without reloading the page
                history.replaceState(null, '', `${window.location.pathname}?${params.toString()}`);

                books.forEach(book => {
                    const genre = book.getAttribute('data-genre');
                    const author = book.getAttribute('data-author');

                    // Check if both filters match
                    if ((selectedGenre === "" || genre === selectedGenre) &&
                        (selectedAuthor === "" || author === selectedAuthor)) {
                        book.style.display = "block"; // Show book
                    } else {
                        book.style.display = "none"; // Hide book
                    }
                });
            }

        
            function setInitialSelections() {
                const queryParams = getQueryParams();
                const genreSelect = document.getElementById('genreSelect');
                const authorSelect = document.getElementById('authorSelect');
        
                // Preselect the genre and author if present in URL
                if (queryParams.category) {
                    genreSelect.value = queryParams.category; // Set the selected value for the genre
                    console.log(queryParams.category)
                }
                if (queryParams.author) {
                    authorSelect.value = queryParams.author; // Set the selected value for the author
                }
        
                filterBooks(); // Apply the filters based on the initial selections
            }
        
            // Add event listeners to both dropdowns
            document.getElementById('genreSelect').addEventListener('change', filterBooks);
            document.getElementById('authorSelect').addEventListener('change', filterBooks);
        
            // Set the initial selections and filter books on page load
            window.onload = setInitialSelections();
        </script>
        
    </body>
</html>
