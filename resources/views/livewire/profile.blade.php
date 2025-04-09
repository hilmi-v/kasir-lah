<div>
    <x-header title="Profile" separator progress-indicator>
    </x-header>
    <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
        <x-card title="kelola pengguna">
            <x-form wire:submit='changeProfile'>
                <x-input label="name" wire:model='name'></x-input>
                <x-input label="email" type="email" wire:model='email'></x-input>
                <div class="mt-4 flex justify-end">
                    <x-button label="simpan" class="btn-accent" spinner="changeProfile" type="submit"></x-button>
                </div>
            </x-form>
        </x-card>
        <x-card title="ganti password">
            <x-form wire:submit="changePassword">
                <x-password label="new password" wire:model='password'></x-password>
                <x-password label="repeat" wire:model='password_confirmation'></x-password>
                <div class="mt-4 flex justify-end">
                    <x-button label="simpan" class="btn-accent" spinner="changePassword" type="submit"></x-button>
                </div>
            </x-form>
        </x-card>
    </div>
</div>