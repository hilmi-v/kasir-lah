<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;
#[Layout('components.layouts.auth')]
#[Title('Reset Password')]
class ResetPassword extends Component
{
    use Toast;
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function ResetPassword()
    {
        $credentials = $this->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
            'email' => 'required|email',
        ], [
            'password.confirmed' => 'password tidak sama'
        ]);

        $status = Password::reset(
            $credentials,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? $this->success('Password reset successfully', redirectTo: "/login")
            : $this->error('Password reset failed :' . __($status), redirectTo: "/login");
    }
    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
