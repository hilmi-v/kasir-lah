<div class="flex items-center justify-center h-full min-h-full ">
    <x-form no-separator class="w-3/5" wire:submit='login'>
        <h1 class="text-white font-bold text-3xl text-center">Login</h1>
        <x-input label="Email" icon="o-user" placeholder="masukkan email" required wire:model="email" type='email' />
        <x-password label="Password" placeholder="masukkan password" wire:model='password'>
            <x-slot:hint>
                <a wire:navigate class="pt-1 hover:underline hover:text-blue-600 cursor-pointer"
                    href="{{ route('forgot.password') }}">forgot pasword ?</a>
            </x-slot:hint>
        </x-password>
        <x-checkbox label="Remember me" wire:model="remember" />
        <x-slot:actions>
            <x-button label="Login" class="btn-success w-full" type="submit" spinner="login"></x-button>
        </x-slot:actions>
    </x-form>
</div>