<div>
    @section('title', 'Invoice')


    <h1 class="my-5 text-2xl font-semibold text-center">Invoice</h1>
    {{-- per Page --}}
    <div class="flex justify-between px-10">
        <x-text-input id="search" class="block w-full mt-1 lg:w-1/5" type="search" name="search" :value="old('search')"
            required wire:model.debounce.500ms="search" autofocus autocomplete="search" placeholder="Search Company ..." />
        <select id="perPage" wire:model="perpage"
            class="hidden  w-full lg:w-1/6 bg-gray-50 border rounded-lg border-gray-300 text-gray-600 text-sm  focus:ring-blue-500 focus:border-blue-500 lg:block  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="5">5 rows</option>
            <option value="10">10 rows</option>
            <option value="15">15 rows</option>
            <option value="20">20 rows</option>
            <option value="25">25 rows</option>
        </select>
        <a href="/createinvoice">
            <x-blue-button>Create Invoice
            </x-blue-button>
        </a>

    </div>
    <div class="relative px-10 mt-5 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-white bg-gray-500 dark:text-white">
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Number</th>
                    <th scope="col" class="px-6 py-3">Customer</th>
                    <th scope="col" class="px-6 py-3">Total</th>
                    <th scope="col" class="px-6 py-3">Invoice Date</th>
                    <th scope="col" class="px-6 py-3">Due Date</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($data))


                    @foreach ($data as $key => $d)
                        <tr class="border-b dark:bg-gray-800 dark:border-gray-700 even:bg-gray-200 hover:bg-blue-200">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ invNumberFormat($d->number, $d->invoice_date) }}</td>
                            <td class="px-6 py-4">{{ getCompany($d->customer_id) }}</td>
                            <td class="px-6 py-4 text-right">
                                {{ number_format(getTotal($d->number)) }}</td>
                            <td class="px-6 py-4">{{ tanggal($d->invoice_date) }}</td>
                            <td class="px-6 py-4">{{ tanggal($d->due_date) }}</td>
                            <td class="px-6 py-4">
                                <x-badge>{{ $d->status }}</x-badge>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="/updateinvoice/{{ $d->number }}"><button
                                            class="px-3 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700">Update</button></a>
                                    <button wire:click="deleteConfirmation({{ $d->number }})"
                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-700">Delete</button>
                                    <a href="/pdftemplate/{{ $d->number }}"> <button
                                            class="px-3 py-2 text-white bg-teal-500 rounded-lg hover:bg-teal-700">Email</button></a>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700 even:bg-gray-200 hover:bg-blue-200">
                        <td class="px-6 py-4">
                            <h4 class="text-xl">Sorry, no data found</h4>
                        </td>
                    </tr>

                @endif
            </tbody>
        </table>
        <div class="my-3">
            {{ $data->links() }}
        </div>
    </div>
</div>
</div>
