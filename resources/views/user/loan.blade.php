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
        <script src="//unpkg.com/alpinejs" defer></script>

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

                <a href="/books" class="mx-auto font-bold text-gray-800 text-md hover:text-gray-800/70 hover:text-gray-900">
                    Books
                </a>
            </div>

                <div class="relative">

                    <a href="/" class="mx-auto font-bold text-center text-gray-800 text-md hover:text-gray-900">
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
                    
                    <div class="flex flex-col items-center justify-center">
                        <h2 class="text-lg font-bold">Currently Loaning</h2>
                        @if($currentlyLoaning->isNotEmpty())
                        <div class="flex gap-10">

                            @foreach ($currentlyLoaning as $loan)
                            <ul class="flex flex-col gap-5">
                                <a href="/loan/{{$loan->book->id}}">
    
                                    <img 
                                        src="{{$loan->book->cover_img}}" 
                                        class="shadow-2xl w-[200px] h-[300px] object-cover" 
                                        alt="">
                                </a>
                                <div>
                                    <p class="text-sm font-bold">{{ $loan->book->title}}</p>
                                    <p class="text-xs font-semibold opacity-70">{{$loan->book->author}}</p>
                                    <p class="text-xs font-semibold opacity-70">Loan Date: {{$loan->tanggal_pinjam}}</p>
                                    <p class="text-xs font-semibold opacity-70">Due Date: {{$loan->tanggal_tenggat}}</p>
                                </div>                            
                                
                            </ul>
                            @endforeach
                            @else
                            <div class="min-h-[352px] h-full flex flex-col justify-center items-center"> 
    
                                <p>No loans</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div x-data="{ showModal: null }" class="flex justify-start gap-20 mb-5">
                        <div class="flex flex-col gap-2">
                            <h2 class="text-lg font-semibold">Past Loans</h2>
                            @if($pastLoans->isNotEmpty())
                                <div class="flex gap-10">
                                    @php
                                        $groupedLoans = $pastLoans->groupBy('book.id');
                                    @endphp
                    
                                    @foreach ($groupedLoans as $bookId => $loans)
                                        <ul class="flex flex-col gap-5">
                                            <!-- Trigger Popup -->
                                            <div 
                                                @click="showModal = {{ $bookId }}" 
                                                class="cursor-pointer"
                                            >
                                                <img 
                                                    src="{{ $loans->first()->book->cover_img }}" 
                                                    class="shadow-2xl w-[200px] h-[300px] object-cover" 
                                                    alt="{{ $loans->first()->book->title }}"
                                                >
                                                <div>
                                                    <p class="text-sm font-bold">{{ $loans->first()->book->title }}</p>
                                                    <p class="text-xs font-semibold opacity-70">{{ $loans->first()->book->author }}</p>
                                                </div>
                                            </div>
                    
                                            <!-- Modal -->
                                            <div 
                                                x-show="showModal === {{ $bookId }}" 
                                                x-cloak 
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                            >
                                                <div class="bg-white p-5 rounded-lg w-[400px]">
                                                    <h3 class="mb-3 text-lg font-bold">{{ $loans->first()->book->title }}</h3>
                                                    <p class="mb-3 text-sm font-semibold">{{ $loans->first()->book->author }}</p>
                                                    <h4 class="text-sm font-semibold">Loan History:</h4>
                                                    <ul class="text-sm">
                                                        @foreach ($loans as $loan)
                                                            <li class="mb-2">
                                                                Loan Date: {{ $loan->tanggal_pinjam }} <br>
                                                                Due Date: {{ $loan->tanggal_tenggat }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <button 
                                                        @click="showModal = null"
                                                        class="px-4 py-2 mt-5 text-white bg-red-500 rounded-md hover:bg-red-700"
                                                    >
                                                        Close
                                                    </button>
                                                    <a href="/loan/{{$loan->book->id}}"
                                                        class="px-4 py-[0.6rem] mt-5 text-white bg-green-500 rounded-md hover:bg-green-700"
                                                    >
                                                        Loan
                                                    </a>
                                                </div>
                                            </div>
                                        </ul>
                                    @endforeach
                                </div>
                            @else
                                <div class="min-h-[352px] h-full flex flex-col justify-center items-center"> 
                                    <p>No loans</p>
                                </div>
                            @endif
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
                left:  0;
                bottom: -4px; /* Adjust as needed */
                width: 100%;
                height: 2px; /* Thickness of the underline */
                background-color: black; /* Color of the underline */
            }
        </style>
        
        
    </body>
</html>
