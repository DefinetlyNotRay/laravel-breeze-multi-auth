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

                    <a href="/" class="mx-auto font-bold text-center text-gray-800 text-md active hover:text-gray-900">
                        Dashboard
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
            <div class="flex justify-center mt-5 mb-5 "">
                <div class="w-[95%] ">
                     <div class="flex">
                        <div class="flex flex-col items-start w-full">
                            <div class="flex gap-10">
                                <div class="">
                                    <h2 class="text-xl font-bold">Book Loaned</h2>
                                    <div class="bg-[#222222] shadow-2xl text-white p-5 w-[24rem] text-3xl py-14 rounded-md font-semibold">
                                        <p>50 Books</p>
                                    </div>
                                </div>
                                <div class="">
                                    <h2 class="text-xl font-bold">Book Returned</h2>
                                    <div class="bg-[#222222] shadow-2xl text-white p-5 w-[24rem] text-3xl py-14 rounded-md font-semibold">
                                        <p>50 Books</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class="flex flex-col gap-2">
                                    <p class="text-3xl font-bold">Books</p>
                                    <input class="w-[14rem] border-none text-black font-semibold bg-[#D9D9D9] px-2 text-sm h-8" type="text" placeholder="Search"> 
                                </div>
                                
                                <div class="py-4 overflow-x-auto overflow-y-scroll max-h-[38rem]">
                                    <table class="border-collapse table-auto  w-[808px]">
                                        <thead class="text-white border border-black bg-[#2D2D2D]">
                                            <tr>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">No</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3"colspan="2">Book Name</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Author</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Status</th>
                                                <th class="px-4 py-2 text-left border-black border-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1
                                            @endphp
                                            @foreach($book as $books)
                                            <tr class="border border-b border-black hover:bg-gray-100">
                                                <td class="px-4 py-2 text-center border-r border-black center col-2">{{$no++}}</td>
                                                <td class="px-4 py-2 border-r border-black" colspan="2">{{$books->title}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$books->author}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$books->status}}</td>
                                                <td class="px-4 py-2 border-black">
                                                    <button class="">Edit</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>    
                        </div>
                        <div class="">
                            <div class="">
                                <div class="flex items-end justify-between">
                                    <p class="text-3xl font-bold">Loaned Books</p>
                                    <input class="w-[14rem] border-none text-black font-semibold bg-[#D9D9D9] px-2 text-sm h-6" type="text" placeholder="Search"> 
                                </div>
                                <div class="py-4 overflow-x-auto ">
                                    <table class="border-collapse table-auto  w-[808px]">
                                        <thead class="text-white border border-black bg-[#2D2D2D]">
                                            <tr>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">No</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3"colspan="2">Book Name</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">User</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Loaned Date</th>
                                                <th class="px-4 py-2 text-left border-black border-3">Due Date</th>
                                                <th class="px-4 py-2 text-left border-black border-3">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Example Row 1 -->
                                            @foreach($loan as $loans)
                                            <tr class="border border-b border-black hover:bg-gray-100">
                                                <td class="px-4 py-2 text-center border-r border-black center col-2">1</td>
                                                <td class="px-4 py-2 border-r border-black" colspan="2">{{$loans->book->title}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$loans->book->author}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$loans->tanggal_pinjam}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$loans->tanggal_tenggat}}</td>
                                                <td class="px-4 py-2 border-black">
                                                    <button class="">Returned</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="">
                                <div class="flex items-end justify-between">
                                    <p class="text-3xl font-bold">Waitlisted Books</p>
                                    <input class="w-[14rem] border-none text-black font-semibold bg-[#D9D9D9] px-2 text-sm h-6" type="text" placeholder="Search"> 
                                </div>
                                <div class="py-4 overflow-x-auto">
                                    <table class="border-collapse table-auto w-[808px]">
                                        <thead class="text-white border border-black bg-[#2D2D2D]">
                                            <tr>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">No</th>
                                                <th class="px-4 py-2 text-left">Book Name</th>

                                                <th class="px-4 py-2 text-left border-r border-black border-3">User</th>
                                                <th class="px-4 py-2 text-left border-r border-black border-3">Loaned Date</th>
                                                <th class="px-4 py-2 text-left border-black border-3">Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($loanWait as $loan)
                                            <tr class="border border-b border-black hover:bg-gray-100">
                                                <td class="px-4 py-2 text-center border-r border-black center col-2">1</td>
                                                <td class="px-4 py-2 border-r border-black" >{{$loan->book->title}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$loan->user->name}}</td>
                                                <td class="px-4 py-2 border-r border-black">{{$loan->tanggal_pinjam}}</td>
                                                <td class="px-4 py-2 border-r border-black"><input type="date"></td>
                                               
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
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
                left:  0;
                bottom: -4px; /* Adjust as needed */
                width: 100%;
                height: 2px; /* Thickness of the underline */
                background-color: black; /* Color of the underline */
            }
        </style>
        
        
    </body>
</html>