<form method="post" action="" wire:submit.prevent="createRole">
    @csrf
    <h2 class="text-2xl mb-6">
        {{ __('admin.admins.roles.create') }}
    </h2>
    {{-- Name --}}
    <x-fields.group label="{{ __('admin.admins.roles.name') }}" for="role_name" hint="{{ __('admin.form.required') }}"
        required :error="$errors->first('role_name')">
        <x-fields.text id="role_name" name="role_name" wire:model.defer="role_name" wire:loading.attr="disabled"
            :error="$errors->first('role_name')" />
    </x-fields.group>

    {{-- Save Button --}}
    <div class="flex justify-center mt-6">
        <x-button icon="o-check" label="{{ __('admin.form.save') }}" type="submit" class="btn-success text-white"
            spinner="createRole" />
    </div>
</form>
