<div>
    <form method="post" action="" wire:submit.prevent="updateAccount">
        @csrf
        <h2 class="text-2xl mb-6">
            {{ __('admin.navigation.account') }}
        </h2>
        <hr / class="mb-6">
        <x-fields.group label="{{ __('admin.admins.users.firstname') }}" for="account_firstname"
            hint="{{ __('admin.form.required') }}" required :error="$errors->first('firstname')">
            <x-fields.text id="account_firstname" autocomplete="off" wire:model.defer="firstname"
                wire:loading.attr="disabled" :error="$errors->first('firstname')" />
        </x-fields.group>
        {{-- Lastname --}}
        <x-fields.group label="{{ __('admin.admins.users.lastname') }}" for="account_lastname"
            hint="{{ __('admin.form.required') }}" required :error="$errors->first('lastname')">
            <x-fields.text id="account_lastname" autocomplete="off" wire:model.defer="lastname"
                wire:loading.attr="disabled" :error="$errors->first('lastname')" />
        </x-fields.group>
        {{-- Email --}}
        <x-fields.group label="{{ __('admin.admins.users.email') }}" for="account_email"
            hint="{{ __('admin.form.required') }}" required :error="$errors->first('email')">
            <x-fields.text type="email" id="account_email" autocomplete="off" wire:model.defer="email"
                wire:loading.attr="disabled" :error="$errors->first('email')" />
        </x-fields.group>
        {{-- Password --}}
        {{-- Password --}}
        <x-fields.group label="{{ __('admin.admins.users.password') }}" for="account_password"
            hint="{!! __('admin.admins.users.password_not_required') . '<br>' . __('admin.admins.users.password_instruction') !!}" required :error="$errors->first('password')">
            <x-fields.password id="account_password" name="password" wire:model.defer="password"
                wire:loading.attr="disabled" :error="$errors->first('password')" />
        </x-fields.group>
        <div class="flex justify-between items-center space-x-4">
            <x-button label="{{ __('admin.form.save') }}" type="submit" class="btn-primary" spinner="updateAccount" />
            <x-button label="{{ __('admin.form.cancel') }}" class="js-drawer__close" spinner="updateAccount" />
        </div>
    </form>
</div>
