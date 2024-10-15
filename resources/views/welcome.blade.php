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
        <nav class="flex items-center justify-between bg-white drop-shadow-md">
            <!-- Empty div for balancing the right side -->

                <div class="w-[200px] ">
                    
                </div>
            <!-- Home link, perfectly centered -->
            <div class="flex items-center gap-16 px-6 ">
                <div class="relative">

                <a href="/" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
                    Books
                </a>
            </div>

                <div class="relative">

                    <a href="/" class="mx-auto font-bold text-center text-gray-800 text-md active hover:text-gray-900">
                        Home
                    </a>
                </div>
                <div class="relative">

                <a href="/" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
                    Loans
                </a>                
            </div>


            </div>

        
            @if (Route::has('login'))
                <div class="flex items-center px-6 py-3">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                        >
                            Dashboard
                        </a>
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
            <div class="flex justify-center w-screen mt-5 "">
                    <div class="w-[95%] ">
                        <div class="bg-[#222222] rounded-xl h-[45vh] pt-10">
                            <div class="text-2xl font-bold text-center text-white">RENT YOUR FAVORITES BOOKS HERE!!</div>
                            <div class="flex justify-center mt-5"><img class="w-[80%]" src="https://utfs.io/f/u1nbYPCUJps7fsbQCukatcBhTPXOqkG2Jv8VgKxH3lRL9Qbd" alt=""></div>
                        </div>
                    <div class="mt-32 w-[78%] mx-auto">
                        <div class="">
                           <p class="text-xl font-medium ">Book Category</p>     
                           <div class="flex items-center justify-between">
                            <div class="" >
                                <a href="/books/{{'fantasy'}}" class="">
                                    <img src="https://utfs.io/f/u1nbYPCUJps7WDSnQVbzHdUJ9iauIw2hvXEAD0Tj7Wn5oKQF"  style="width:248px; height:218px !important;"alt="">
                                </a>
                                <p class="mt-2 text-lg font-bold text-center">Fantasy</p>
                            </div>
                            <div class="">               
                                <a href="/books/{{'romance'}}" class="">            
                                 <img src="https://utfs.io/f/u1nbYPCUJps7rgiYIStxvZQjXVd2zOB0hag9nsUYrfRcw8kT" style="width:248px; height:218px !important;" alt="">
                                </a>
                                 <p class="mt-2 text-lg font-bold text-center">Romance</p>
                            </div>
                            <div class="">   
                                <a href="/books/{{'self-improvement'}}" class="">            
                                    <img src="https://utfs.io/f/u1nbYPCUJps7Gols5QWzKnhudLeOxWvRkZMisaw6r9NmPC7D" style="width:248px; height:218px !important;" alt="">
                                </a>                         
                                <p class="mt-2 text-lg font-bold text-center">Self Improvements</p>
                            </div>
                            <div class="">        
                                <a href="/books/{{'science-fiction'}}" class="">
                                    <img src="https://utfs.io/f/u1nbYPCUJps7qbstc9sGMCBRSKIbNUTohpu7Jv8i39aOLxZX" style="width:248px; height:218px !important;" class="" alt="">
                                </a>                    
                                <p class="mt-2 text-lg font-bold text-center ">Science Fiction</p>
                            </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <style>
            .active::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -4px; /* Adjust as needed */
    width: 100%;
    height: 2px; /* Thickness of the underline */
    background-color: black; /* Color of the underline */
}

        </style>
        
        
    </body>
</html>
