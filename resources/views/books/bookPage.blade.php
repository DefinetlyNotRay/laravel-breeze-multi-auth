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
            
            <div class="flex justify-center gap-10 items-center h-[80vh]">
                <img class="max-w-[340px]" src="{{$books->cover_img}}" alt="">
                <div class="max-w-[80ch] h-full flex flex-col justify-center">

                    <p class="text-xl font-bold">{{$books->title}}</p>
                    <p class="text-sm font-semibold">{{$books->author}}</p>
                    <p class="font-bold">{{$books->category->nama_category}}</p>
                    <p class="text-sm">{{$books->desc   }}</p>
                    @if($books->status == 'Available')
                    <!-- Tombol Loan -->
                    <form action="{{ route('loans.loan', ['id' => $books->id]) }}" method="POST">
                        @csrf

                        <input type="submit" class="text-xs mt-2 bg-[#01B14B] w-full text-center text-white hover:bg-[#01B14B]/70 transition-all duration-300 py-1 px-4" placeholder="Loan" />
                 
                    </form>
                    @else
                    <!-- Tombol Tidak Aktif -->
                    <button disabled class="w-full px-4 py-1 mt-2 text-xs text-center text-white bg-gray-400 cursor-not-allowed">
                        Unavailable
                    </button>
                    @endif
                    
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
            
        </script>
        
    </body>
</html>
