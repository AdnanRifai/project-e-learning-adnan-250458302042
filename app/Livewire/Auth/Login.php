<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.master')]
class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();

            // ambil user
            $user = Auth::user();

            // redirect berdasarkan role
            if ($user->role === 'admin') {
                return $this->redirectRoute('admin.dashboard', navigate: true);
            } elseif ($user->role === 'student') {
                return $this->redirectRoute('student.dashboard', navigate: true);
            }

            return redirect('/dashboard');
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }

}
