<div class="flex items-center justify-center h-full min-h-full ">
    <x-form no-separator class="w-3/5" wire:submit='ResetPassword'>
        <h1 class="text-white font-bold text-3xl text-center">set new password</h1>
        <x-input label="Email" icon="o-user" placeholder="masukkan email" required wire:model="email" type='email' />
        <x-password label="Password" placeholder="masukkan password" wire:model='password' />
        <x-password label="Repeat Password" placeholder="ulang password" wire:model='password_confirmation' />
        <x-slot:actions>
            <x-button label="Simpan Password" class="btn-success w-full" type="submit" spinner="ResetPassword">
            </x-button>
        </x-slot:actions>
    </x-form>
</div>