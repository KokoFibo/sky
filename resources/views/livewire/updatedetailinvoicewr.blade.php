<div class="p-3">

    <div
        class="flex flex-col w-full gap-3 p-3 mx-auto mt-5 text-center bg-white rounded-lg dark:bg-gray-800 dark:text-white shadow lg:w-1/3">
        Edit Invoice Item
    </div>

    <div class="flex flex-col w-full gap-3 p-3 mx-auto mt-5 bg-white rounded-lg dark:bg-gray-800 dark:text-white shadow lg:w-1/3"
        x-data="{ inputManual: false }">
        {{-- Package --}}
        <div class="flex">
            <span @dblclick="inputManual = !inputManual"
                class="inline-flex items-center w-24 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                Package
            </span>
            <div x-show="inputManual" class="w-full">

                <select wire:model="package"
                    class="w-full rounded-none rounded-r-lg bg-gray-50 border  border-gray-300 text-gray-600
                text-sm focus:ring-blue-500 focus:border-blue-500 lg:block p-2.5 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                    @if ($packages != null)
                        @foreach ($packages as $p)
                            <option value="{{ $p->package }}">{{ $p->package }}</option>
                        @endforeach
                    @endif

                </select>
            </div>
            <div x-show="!inputManual" @dblclick="inputManual = !inputManual" class="w-full">

                <input type="text" required wire:model="package"
                    class="w-full rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>


        </div>
        {{-- Price --}}
        <div class="flex">
            <span
                class="inline-flex items-center w-24 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">

                {{-- class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"> --}}
                Price
            </span>

            <input required wire:model="price"
                class="w-full rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

        </div>
        {{-- Qty --}}
        <div class="flex">
            <span
                class="inline-flex items-center w-24 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">

                {{-- class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"> --}}
                Quantity
            </span>

            <input required wire:model="qty" autocomplete="qty"
                class="w-full rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

        </div>
        <div class="flex justify-between">
            <button class="button button-teal" wire:click="updateLower">Update</button>
            <button class="button button-gray" wire:click="cancel">Back</button>
        </div>
    </div>


</div>
