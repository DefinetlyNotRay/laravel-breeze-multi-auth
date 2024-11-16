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

                <div class="w-[200px] ">
                    
                </div>
            <!-- Home link, perfectly centered -->
            <div class="flex items-center gap-16 px-6 ">
                <div class="relative">

                <a href="/books" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
                    Books
                </a>
            </div>

                <div class="relative">

                    <a href="/" class="mx-auto font-bold text-center text-gray-800 text-md  hover:text-gray-900">
                        Home
                    </a>
                </div>
                <div class="relative">

                <a href="/loans" class="mx-auto font-bold text-gray-800 text-md active hover:text-gray-800/70 hover:text-gray-900">
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
                    
                    <div class="" id="bookContainer">
                        <h2>Currently Loaning</h2>
                        <ul>
                            @foreach ($currentlyLoaning as $loan)
                                <li>{{ $loan->book->title }} - Due: {{ $loan->tanggal_tenggat }}</li>
                            @endforeach
                        </ul>

                        <h2>Past Loans</h2>
                        <ul>
                            @foreach ($returnedBooks as $loan)
                                <li>{{ $loan->book->title }} - Returned: {{ $loan->returns->tanggal_pengembalian }}</li>
                            @endforeach
                        </ul>

                        <h2>Waiting to Be Picked Up</h2>
                        <ul>
                            @foreach ($waitingToBePickedUp as $loan)
                            <a href="/loan/{{$loan->book->id}}">

                                <img 
                                    src="{{$loan->book->cover_img}}" 
                                    class="w-[200px] h-[300px] object-cover" 
                                    alt="">
                            </a>
                            <div>
                                <p class="font-bold text-sm">{{ $loan->book->title}}</p>
                                <p class="text-xs opacity-70 font-semibold">{{$loan->book->author}}</p>
                                <p class="text-xs opacity-70 font-semibold">Reserved on: {{$loan->tanggal_pinjam}}</p>
                            </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </main>
      
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
        </style>
        
        
    </body>
</html>