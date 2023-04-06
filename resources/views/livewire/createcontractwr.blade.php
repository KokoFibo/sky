<div>
    <div class="w-3/4 mx-auto mt-3 text-black bg-white shadow rounded-xl border-1">
        <h2 class="py-3 text-2xl font-semibold text-center">Create Contract</h2>
    </div>

    <div class="w-3/4 p-5 mx-auto mt-3 text-black bg-white shadow rounded-xl border-1">
        <div class="flex items-start justify-between w-full px-10 ">
            <div class="flex flex-col w-1/3 gap-3">
                {{-- customer_id --}}
                <div class="flex ">
                    <span
                        class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Customer
                    </span>
                    <select wire:model="customer_id"
                        class=" w-full  bg-gray-50 border  border-gray-300 text-gray-600 rounded-none rounded-r-lg
        text-sm focus:ring-blue-500 focus:border-blue-500 lg:block p-2.5 dark:bg-gray-700 dark:border-gray-600
        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Select Customer</option>
                        @foreach ($customer as $c)
                            <option value="{{ $c->id }}">{{ $c->company }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Contract Number --}}

                <div class="flex ">
                    <span
                        class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Contract Number
                    </span>
                    <input type="text" id="contract_number" type="text" name="contract_number" disabled
                        :value="old('contract_number')" required wire:model="contract_number"
                        autocomplete="contract_number"
                        class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

            </div>
            <div class="flex flex-col w-1/3 gap-3">
                <div class="flex ">
                    <span
                        class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Contract Begin
                    </span>
                    <input id="contract_begin" type="date" name="contract_begin" :value="old('contract_begin')"
                        required wire:model="contract_begin" autocomplete="contract_begin"
                        class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="flex ">
                    <span
                        class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Contract End
                    </span>
                    <input id="contract_end" type="date" name="contract_end" :value="old('contract_end')" required
                        wire:model="contract_end" autocomplete="contract_end"
                        class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="flex ">
                    <span
                        class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Upload PDF
                    </span>
                    <input id="pdf" type="file" name="pdf" :value="old('pdf')" required wire:model="pdf"
                        autocomplete="pdf"
                        class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('photo')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>
    </div>
    {{-- table --}}
    <div>
        <table class="w-3/4 mx-auto mt-3 text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-white bg-gray-500 dark:text-white">
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Package</th>
                    <th scope="col" class="px-6 py-3">Price</th>
                    <th scope="col" class="px-6 py-3">Qty</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">
                        @if ($customer_id == '' || $contract_begin == null || $contract_end == null)
                            <button wire:click="add_row" class="button button-gray" disabled>Add</button>
                        @else
                            <button wire:click="add_row" class="button button-blue">Add</button>
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($contracts))
                    @foreach ($contracts as $index => $contract)
                        <tr x-data="{ packageManual: false }" @dblclick="packageManual = !packageManual"
                            class="border-b dark:bg-gray-800 dark:border-gray-700 even:bg-gray-200 hover:bg-blue-200">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="p-3 ">
                                {{-- <td class="px-6 py-4"> --}}
                                {{-- <div class="p-3 " x-data="{ packageManual: false }" @dblclick="packageManual = !packageManual "> --}}
                                <div class="w-full " x-show="!packageManual">
                                    <select wire:model="contracts.{{ $index }}.package"
                                        wire:change="updatePrice({{ $index }})"
                                        class="w-72  bg-gray-50 border rounded-lg border-gray-300 text-gray-600
                    text-sm focus:ring-blue-500 focus:border-blue-500 lg:block p-2.5 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select Package</option>
                                        @foreach ($packageData as $p)
                                            <option value="{{ $p->package }}">{{ $p->package }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- input package manual --}}
                                <div class="w-full " x-show="packageManual">
                                    <x-text-input class="w-full mt-1 marker:block" type="text" name="package"
                                        :value="old('package')" required
                                        wire:model.lazy="contracts.{{ $index }}.package"
                                        autocomplete="package" />
                                </div>
                                {{-- </div> --}}
                            </td>
                            <td class="px-6 py-4">
                                {{-- input price --}}
                                <div class="p-3 ">
                                    <x-text-input class="block w-full mt-1 text-right" type="text" name="price"
                                        onchange="Calc(this);" :value="old('price')"
                                        wire:model.lazy="contracts.{{ $index }}.price" autocomplete="price" />
                                    {{-- <input type="text" wire:model.lazy="contracts.{{ $index }}.price"> --}}

                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{-- input Qty --}}
                                <div class="p-3 ">
                                    <x-text-input class="block w-full mt-1 text-right" type="number" name="qty"
                                        onchange="Calc(this);" :value="old('qty')" required
                                        wire:model.lazy="contracts.{{ $index }}.qty" autocomplete="qty" />
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{-- input description --}}
                                <div class="w-full ">
                                    <x-text-input class="w-full mt-1 marker:block" type="text" name="description"
                                        :value="old('description')" required
                                        wire:model.lazy="contracts.{{ $index }}.description"
                                        autocomplete="description" />
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="p-3 ">
                                    <button wire:click="delete_row({{ $index }})"
                                        class="button button-red">-</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>


        <div class="flex justify-between w-3/4 mx-auto my-3 ">
            <div></div>
            <div class="flex gap-2">
                <x-blue-button wire:click="saveContract">
                    {{ __('Save') }}
                </x-blue-button>
                <a href="/contract">
                    <x-primary-button>
                        {{ __('Cancel') }}
                    </x-primary-button>
                </a>
            </div>
        </div>
    </div>



</div>
