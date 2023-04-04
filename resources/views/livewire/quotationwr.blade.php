<div>
    <div class="relative px-10 mt-5 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-white bg-gray-500 dark:text-white">
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Number</th>
                    <th scope="col" class="px-6 py-3">Customer</th>
                    <th scope="col" class="px-6 py-3">Package</th>
                    <th scope="col" class="px-6 py-3">Price</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Quotation Date</th>
                    <th scope="col" class="px-6 py-3">Emailed At</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">
                        <a href="/createquotation"><button
                                class="px-3 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700">Add</button></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($data))

                    @foreach ($data as $key => $d)
                        <tr class="border-b dark:bg-gray-800 dark:border-gray-700 even:bg-gray-200 hover:bg-blue-200">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $d->number }}</td>
                            <td class="px-6 py-4">{{ $d->customer_id }}</td>
                            <td class="px-6 py-4">{{ $d->package }}</td>
                            <td class="px-6 py-4">{{ $d->price }}</td>
                            <td class="px-6 py-4">{{ $d->description }}</td>
                            <td class="px-6 py-4">{{ $d->quotation_date }}</td>
                            <td class="px-6 py-4">{{ $d->emailed_at }}</td>
                            <td class="px-6 py-4">{{ $d->status }}</td>

                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="/updatequotation/{{ $d->number }}"><button
                                            class="px-3 py-2 text-white bg-teal-500 rounded-lg hover:bg-teal-700">Update</button></a>
                                    <button wire:click="deleteConfirmation({{ $d->number }})"
                                        class="px-3 py-2 text-white bg-red-500 rounded-lg hover:bg-red-700">Delete</button>
                                    <a href="/quotationtemplate/{{ $d->number }}"><button
                                            class="px-3 py-2 text-white bg-blue-500 rounded-lg hover:bg-red-700">Email</button></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700 even:bg-gray-200 hover:bg-blue-200">
                        <td class="px-6 py-4">No data Found !</td>
                    </tr>
                @endif

            </tbody>
        </table>

        <div class="px-6 mt-3">
            {{ $data->links() }}
        </div>
    </div>

</div>
