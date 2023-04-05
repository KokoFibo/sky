<div>
    <div class="w-3/4 mx-auto mt-3 text-black bg-white shadow rounded-xl border-1">
        <h2 class="py-3 text-2xl font-semibold text-center">Create Quotation</h2>
    </div>
    {{-- <div class="w-3/4 mx-auto text-black bg-white" style="height: 100vh;"> --}}
    <div class="w-3/4 p-3 mx-auto mt-3 text-black bg-white shadow rounded-xl border-1">

        <div class="flex items-start justify-between w-full px-10 ">
            <div class="flex flex-col w-full gap-3">
                {{-- customer --}}
                <div class="flex ">
                    <span
                        class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Customer
                    </span>
                    <select wire:model="customer_id"
                        class=" w-72  bg-gray-50 border  border-gray-300 text-gray-600 rounded-none rounded-r-lg
        text-sm focus:ring-blue-500 focus:border-blue-500 lg:block p-2.5 dark:bg-gray-700 dark:border-gray-600
        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Select Customer</option>
                        @foreach ($customer as $c)
                            <option value="{{ $c->id }}">{{ $c->company }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            {{-- Invoice Number --}}
            <div class="flex flex-col w-1/3 gap-3">

                <div class="flex ">
                    <span
                        class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Quotation Number
                    </span>
                    <input type="text" id="quotation_number" type="text" name="quotation_number" disabled
                        :value="old('quotation_number')" required wire:model="number" autocomplete="quotation_number"
                        class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="flex ">
                    <span
                        class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Quotation Date
                    </span>
                    <input id="quotation_date" type="text" name="quotation_date" :value="old('quotation_date')"
                        required wire:model="quotation_date" autocomplete="quotation_date"
                        class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
        </div>

        <table class="w-full mx-auto mt-3 text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-white bg-gray-500 dark:text-white">
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Package</th>
                    <th scope="col" class="px-6 py-3">Price</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">
                        @if ($customer_id == '')
                            <button wire:click="add_row" class="button button-gray" disabled>Add</button>
                        @else
                            <button wire:click="add_row" class="button button-blue">Add</button>
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($quotations))
                    @foreach ($quotations as $index => $quotation)
                        <tr x-data="{ packageManual: false }" @dblclick="packageManual = !packageManual"
                            class="border-b dark:bg-gray-800 dark:border-gray-700 even:bg-gray-200 hover:bg-blue-200">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="p-3 ">



                                <div class="w-full " x-show="!packageManual">
                                    <select wire:model="quotations.{{ $index }}.package"
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
                                        wire:model.lazy="quotations.{{ $index }}.package"
                                        autocomplete="package" />
                                </div>

                            </td>
                            <td class="px-6 py-4">
                                {{-- input price --}}
                                <div class="p-3 ">
                                    <x-text-input class="block w-full mt-1 text-right" type="text" name="price"
                                        :value="old('price')" wire:model.lazy="quotations.{{ $index }}.price"
                                        autocomplete="price" />
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{-- input description --}}
                                <div class="p-3 ">
                                    {{-- <x-text-input class="block w-full mt-1 text-right" type="text" name="description"
                                        :value="old('description')" required
                                        wire:model.lazy="quotations.{{ $index }}.description"
                                        autocomplete="description" /> --}}

                                    <textarea id="message" rows="4" wire:model.lazy="quotations.{{ $index }}.description"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>

                                </div>
                            </td>


                            <td class="px-6 py-4">
                                <div class="p-3 ">
                                    <button wire:click="delete_row({{ $index }})" onclick="btnDel(this);"
                                        class="button button-red">-</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="flex gap-2 my-3 text-right ">
            <x-blue-button wire:click="saveQuotation">
                {{ __('Save') }}
            </x-blue-button>
            <a href="/quotation">
                <x-primary-button>
                    {{ __('Cancel') }}
                </x-primary-button>
            </a>
        </div>
    </div>
</div>
