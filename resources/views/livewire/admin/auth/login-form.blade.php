<div>
    @if (session()->has('success'))
        <x-alerts.alert type="success" class="mb-4" />
    @endif
    @if (session()->has('error'))
        <x-alerts.alert type="error" class="mb-4" />
    @endif
    @if ($errors->all())
        <x-alerts.validation-alert class="mb-4" />
    @endif

    <form method="post" action="" wire:submit.prevent="authAttempt">
        @csrf
        <x-honeypot />
        {{-- Username --}}
        <div class="relative mb-6">
            <x-fields.label for="account_username" label="{{ __('admin.auth.username') }}" required />
            <x-fields.text id="account_username" name="account_username" value="{{ old('username') }}" :error="$errors->first('account_username')"
                required autocomplete="off" wire:model.defer="username" wire:loading.attr="disabled" />
        </div>

        {{-- Password --}}
        <div class="relative">
            <x-fields.label for="account_password" label="{{ __('admin.auth.password') }}" required />
            <x-fields.password id="account_password" name="password" required="required" wire:model.defer="password"
                wire:loading.attr="disabled" :error="$errors->first('password')" />
        </div>
        <div class="flex justify-end mb-6">
            <a href="{{ route('admin.password') }}" class="text-sm text-primary hover:underline">
                {{ __('admin.auth.forgot_password') }}
            </a>
        </div>
        {{-- Submit --}}
        <div class="flex justify-center mt-6">
            <x-button label="{{ __('admin.auth.login') }}" type="submit" class="btn-primary" spinner="authAttempt" />
        </div>
    </form>
</div>
