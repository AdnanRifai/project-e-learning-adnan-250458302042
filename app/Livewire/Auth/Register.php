<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.master')]
class Register extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $confirm_password;
    public $agree_terms = false;

    public function register()
    {
        $this->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:3',
            'confirm_password' => 'required|same:password',
            'agree_terms' => 'accepted',
        ]);

        // simpan ke DB
        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        // redirect ke login page
        session()->flash('success', 'Akun berhasil dibuat! Silakan login.');
        return $this->redirectRoute('login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
