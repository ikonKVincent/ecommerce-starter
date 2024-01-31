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

    <form method="post" action="" wire:submit.prevent="passwordAttempt">
        @csrf
        <x-honeypot />
        {{-- Username --}}
        <div class="form-group relative mb-6">
            <label class="form-label mb-1 text-sm" for="login_email">
                {{ __('admin.auth.email') }} :
            </label>
            <input type="email" name="login_email" value="" id="login_email" required="required"
                class="input input-bordered w-full text-sm" autocomplete="off" wire:model.defer="email"
                wire:loading.attr="disabled" @error('email')aria-invalid="true"@enderror>
            @error('username')
                <div class="text-error text-sm italic">{{ $message }}</div>
            @enderror
        </div>
        {{-- Submit --}}
        <div class="flex justify-center mt-6">
            <div wire:loading.remove>
                <button type="submit" class="btn" wire:loading.remove wire:target="passwordAttempt">
                    {{ __('admin.auth.valid') }}
                </button>
            </div>
            <div wire:loading>
                <span class="loading loading-spinner loading-lg text-primary"></span>
            </div>
        </div>
    </form>
</div>
