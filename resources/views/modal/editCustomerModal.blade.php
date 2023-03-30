<div x-show="editCustomer" class="w-3/4" x-cloak>
    <x-modalCustom>
        <h2 class="text-2xl text-center font-semibold mt-3">Update Customer Data</h2>
        <hr class="my-2 px-3">
        <div class="p-3">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                wire:model="name" autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="p-3">
            <x-input-label for="salutation" :value="__('Salutation')" />
            <x-text-input id="salutation" class="block mt-1 w-full" type="text" name="salutation" :value="old('salutation')"
                required wire:model="salutation" autofocus autocomplete="salutation" />
            <x-input-error :messages="$errors->get('salutation')" class="mt-2" />
        </div>
        <div class="p-3">
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"
                required wire:model="title" autofocus autocomplete="title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>
        <div class="p-3">
            <x-input-label for="company" :value="__('Company')" />
            <x-text-input id="company" class="block mt-1 w-full" type="text" name="company" :value="old('company')"
                required wire:model="company" autofocus autocomplete="company" />
            <x-input-error :messages="$errors->get('company')" class="mt-2" />
        </div>
        <div class="p-3">
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                required wire:model="address" autofocus autocomplete="address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>
        <div class="p-3">
            <x-input-label for="mobile" :value="__('Mobile')" />
            <x-text-input id="mobile" class="block mt-1 w-full" type="text" name="mobile" :value="old('mobile')"
                required wire:model="mobile" autofocus autocomplete="mobile" />
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
        </div>
        <div class="p-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')"
                required wire:model="email" autofocus autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="p-3">
            <x-input-label for="notes" :value="__('Notes')" />
            <x-text-input id="notes" class="block mt-1 w-full" type="text" name="notes" :value="old('notes')"
                required wire:model="notes" autofocus autocomplete="notes" />
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>
        <div class="flex justify-between">
            <x-blue-button class="m-3" @click="editCustomer=false" wire:click="updateCustomer">
                {{ __('Update') }}
            </x-blue-button>
            <x-primary-button class="m-3" @click="editCustomer=false" wire:click="clear">
                {{ __('Cancel') }}
            </x-primary-button>
        </div>


    </x-modalCustom>
</div>
