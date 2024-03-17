<div>
    <div class="flex mt-10 flex-col lg:h-screen gap-10 justify-center items-center">
        <div class="bg-gray-100 w-full  gap-4 flex-wrap flex justify-center items-center">
            <!-- Expiring Contracts -->
            <div x-data="{ showDetail: false }"
                class="flex justify-between items-start z-10 w-full mx-3 lg:w-full mx-3 lg:w-72 p-2 h-32 bg-gray-800 text-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                <div class="flex flex-col gap-7 justify-between items-start">
                    <h2 class=" px-2 text-5xl font-bold text-purple-400">{{ count($expiring) }}</h2>
                    <div class="px-2">
                        <!-- Heading -->
                        <h2 class="font-bold text">Expiring Contracts</h2>
                        <!-- Description -->
                        {{-- <p class="text-sm text-gray-600">Simple Yet Beautiful Card Design with TaiwlindCss. Subscribe to our
                    Youtube channel for more ...</p> --}}
                        <div class="w-full" x-show="showDetail">
                            <ul class="p-3 mt-3  text-purple-400 text-sm">
                                @foreach ($expiring as $index => $d)
                                    {{-- <p class="text-sm my-2">{{ $index + 1 }}. {{ getCompany($d->customer_id) }}</p> --}}
                                    <li class="border-b-4 p-3  rounded-lg text-sm  bg-purple-400  text-white z-50 ">
                                        {{ getCompany($d->customer_id) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- CTA -->
                </div>
                <div class="flex justify-between gap-5 px-1 flex-col items-center">
                    <div class="bg-purple-400 text-white rounded-full   w-14 h-14 flex justify-center items-center">
                        <i class="fa-solid fa-file-contract text-3xl"></i>
                    </div>
                    <div>

                        <div x-show="!showDetail">
                            <button @click="showDetail = !showDetail"
                                class="text-xs text-white bg-purple-400 px-1 py-1 rounded-md hover:bg-purple-700">Details</button>
                        </div>

                        <div x-show="showDetail">
                            <button @click="showDetail = !showDetail"
                                class="text-xs text-white bg-purple-400 px-1 py-1 rounded-md hover:bg-purple-700">Less
                                Details</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Clients -->
            <div
                class="flex justify-between items-start w-full mx-3 lg:w-72 p-2 h-32 bg-gray-800 text-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                <div class="flex flex-col gap-7 justify-between items-start">
                    <h2 class=" px-2 text-5xl text-green-400 font-bold">{{ $active }}</h2>
                    <div class="px-2">
                        <h2 class="font-bold text">Active Clients</h2>
                    </div>
                    <!-- CTA -->
                </div>
                <div class="flex justify-between gap-5 px-1 flex-col items-center">
                    <div class="bg-blue-400 text-white rounded-full   w-14 h-14 flex justify-center items-center">
                        <i class="fa-solid fa-people-group text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- MTD Sales turnover -->
            <div
                class="flex justify-between items-start w-full mx-3 lg:w-72 p-2 h-32 bg-gray-800 text-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                <div class="flex flex-col gap-10 justify-between items-start">
                    <h2 class=" px-2 text-3xl text-green-400 font-bold">{{ number_format($mtd) }}</h2>
                    <div class="px-2">
                        <h2 class="font-bold text">MTD Sales turnover</h2>
                    </div>
                    <!-- CTA -->
                </div>
                <div class="flex justify-between gap-5 px-1 flex-col items-center">
                    <div class="bg-green-400 text-white rounded-full   w-14 h-14 flex justify-center items-center">
                        <i class="fa-solid fa-sack-dollar text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- YTD Sales turnover -->
            <div
                class="flex justify-between items-start w-full mx-3 lg:w-72 p-2 h-32 bg-gray-800 text-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                <div class="flex flex-col gap-10 justify-between items-start">
                    <h2 class=" px-2 text-3xl text-pink-400 font-bold">{{ number_format($ytd) }}</h2>
                    <div class="px-2">
                        <h2 class="font-bold text">YTD Sales turnover</h2>
                    </div>
                    <!-- CTA -->
                </div>
                <div class="flex justify-between gap-5 px-1 flex-col items-center">
                    <div class="bg-pink-400 text-white rounded-full   w-14 h-14 flex justify-center items-center">
                        <i class="fa-solid fa-hand-holding-dollar text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100 w-full  gap-4 flex-wrap flex justify-center items-center">
            <!-- Card -->
            <div
                class="w-full mx-3 lg:w-60 p-2 bg-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                <!-- Image -->
                <img class="h-40 object-cover rounded-xl" h-40 object-cover rounded-xl"
                    src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80"
                    alt="">
                <div class="p-2">
                    <!-- Heading -->
                    <h2 class="font-bold text-lg mb-2 ">{{ $active }} Active Clients</h2>
                    <!-- Description -->
                    <p class="text-sm text-gray-600">Simple Yet Beautiful Card Design with TaiwlindCss.
                        Subscribe to our
                        Youtube channel for more ...</p>
                </div>
                <!-- CTA -->
                <div class="m-2">
                    <a role='button' href='#'
                        class="text-white bg-sky-500 px-3 py-1 rounded-md hover:bg-purple-700">Learn More</a>
                </div>
            </div>

            <!-- Card -->
            <div
                class="w-full mx-3 lg:w-60 p-2 bg-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                <!-- Image -->
                <img class="h-40 object-cover rounded-xl" h-40 object-cover rounded-xl"
                    src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80"
                    alt="">
                <div class="p-2">
                    <!-- Heading -->
                    <h2 class="font-bold text-lg mb-2 ">Sales Turnover MTD</h2>
                    <!-- Description -->
                    <p class="text-sm text-gray-600">Simple Yet Beautiful Card Design with TaiwlindCss. Subscribe to our
                        Youtube channel for more ...</p>
                </div>
                <!-- CTA -->
                <div class="m-2">
                    <a role='button' href='#'
                        class="text-white bg-green-500 px-3 py-1 rounded-md hover:bg-purple-700">Learn More</a>
                </div>
            </div>
            <!-- Card -->
            <div
                class="w-full mx-3 lg:w-60 p-2 bg-white rounded-xl transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2xl">
                <!-- Image -->
                <img class="h-40 object-cover rounded-xl" h-40 object-cover rounded-xl"
                    src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80"
                    alt="">
                <div class="p-2">
                    <!-- Heading -->
                    <h2 class="font-bold text-lg mb-2 ">Sales Turnover YTD</h2>
                    <!-- Description -->
                    <p class="text-sm text-gray-600">Simple Yet Beautiful Card Design with TaiwlindCss. Subscribe to our
                        Youtube channel for more ...</p>
                </div>
                <!-- CTA -->
                <div class="m-2">
                    <a role='button' href='#'
                        class="text-white bg-yellow-500 px-3 py-1 rounded-md hover:bg-purple-700">Learn More</a>
                </div>
            </div>
        </div>
    </div>




</div>
