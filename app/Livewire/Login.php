<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;
#[Layout('components.layouts.auth')]
#[Title('Login')]
class Login extends Component
{
    use Toast;
    public string $email;
    public string $password;
    public bool $remember = false;

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (
            auth()->attempt($credentials, $this->remember)
        ) {
            $this->success('Login successful.', redirectTo: '/');
        } else {
            $this->error('Login failed.');
            $this->reset('password');
        }
    }

    public function render()
    {
        return view('livewire.login');
    }
}
