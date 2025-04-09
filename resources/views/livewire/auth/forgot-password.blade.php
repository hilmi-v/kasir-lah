<div class="flex items-center justify-center h-full min-h-full ">
    <x-form no-separator class="w-3/5" wire:submit='forgotPassword'>
        <h1 class="text-white font-bold text-3xl text-center">Forgot Password</h1>
        <x-input label="Email" icon="o-user" placeholder="masukkan email" required wire:model="email" type='email' />
        <x-slot:actions>
            <x-button label="Send Link" class="btn-success w-full" type="submit" spinner="forgotPassword"></x-button>
        </x-slot:actions>
    </x-form>
</div>