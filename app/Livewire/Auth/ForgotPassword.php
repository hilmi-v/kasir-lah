<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;
#[Title('Forgot password')]
#[Layout('components.layouts.auth')]
class ForgotPassword extends Component
{
    use Toast;
    public $email;

    public function forgotPassword()
    {
        $credentials = $this->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $credentials
        );

        return $status === Password::ResetLinkSent
            ? $this->success('Password reset link sent.')
            : $this->error(__($status));
    }
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
