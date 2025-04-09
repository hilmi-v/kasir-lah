<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

#[Title('Profile')]
class Profile extends Component
{
    use Toast;

    public $email;
    public $name;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function changeProfile()
    {
        $this->validate([
            'name' => 'required|unique:users,id,' . auth()->user()->id,
            'email' => 'email|required|unique:users,email,' . auth()->user()->id,
        ]);

        User::find(auth()->user()->id)->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->success('berhasil di ubah');
    }

    public function changePassword()
    {
        $this->validate([
            'password' => 'required|confirmed|min:8'
        ], [
            'password.confirmed' => 'password tidak sama'
        ]);

        User::find(auth()->user()->id)->update([
            'password' => Hash::make(
                $this->password
            ),

        ]);

        $this->success('berhasil di ubah');

    }
    public function render()
    {
        return view('livewire.profile');
    }
}
