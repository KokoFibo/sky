<div x-show="editCustomer" class="w-3/4" x-cloak>
    <x-modalCustomer>
        <h2 class="mt-3 text-2xl font-semibold text-center">Update Customer Data</h2>
        <hr class="px-3 my-2">
        <div class="flex flex-col w-full gap-3 p-5">

            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Name
                </span>
                <input type="text" id="name" type="text" name="name" required wire:model.live="name"
                    autocomplete="name"
                    class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block  min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Salutation
                </span>
                <select wire:model.live="salutation"
                    class="w-full text-sm text-gray-600 border border-gray-300 rounded-none rounded-r-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 lg:block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                    <option value="">Select Salutation</option>
                    <option value="Mr">Mr.</option>
                    <option value="Ms">Ms.</option>

                </select>
            </div>
            <x-input-error :messages="$errors->get('salutation')" class="mt-2" />
            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Brand
                </span>
                <input type="text" id="company" type="text" name="company" required wire:model.live="company"
                    autocomplete="company"
                    class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block  min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <x-input-error :messages="$errors->get('company')" class="mt-2" />
            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Title
                </span>
                <input type="text" id="company" type="text" name="company" required wire:model.live="title"
                    autocomplete="company"
                    class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block  min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

            </div>
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Address
                </span>
                <input type="text" id="address" type="text" name="address" required wire:model.live="address"
                    autocomplete="address"
                    class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block  min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">



            </div>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Mobile
                </span>
                <input type="text" id="mobile" type="text" name="mobile" required wire:model.live="mobile"
                    autocomplete="mobile"
                    class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block  min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Email
                </span>
                <input type="text" id="email" type="text" name="email" required wire:model.live="email"
                    autocomplete="email"
                    class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block  min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Notes
                </span>
                <input type="text" id="notes" type="text" name="notes" required wire:model.live="notes"
                    autocomplete="notes"
                    class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block  min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
            <div class="flex ">
                <span
                    class="inline-flex items-center w-32 px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Active
                </span>
                <select wire:model.live="is_active"
                    class="w-full text-sm text-gray-600 border border-gray-300 rounded-none rounded-r-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 lg:block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                    <option value="">Select Active</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>

                </select>
            </div>
        </div>

        <div class="flex justify-between">
            <x-blue-button class="m-3" wire:click="updateCustomer">
                {{ __('Update') }}
            </x-blue-button>
            <x-primary-button class="m-3" @click="editCustomer=false" wire:click="clear">
                {{ __('Cancel') }}
            </x-primary-button>
        </div>


    </x-modalCustomer>
</div>
