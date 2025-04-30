<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class BecomeAdmin extends Component
{
    public $email = '';
    public $password = '';
    public $confirm = false;
    public $success = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string',
        'confirm' => 'accepted',
    ];

    public function submit()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            $this->addError('email', 'Invalid credentials.');
            return;
        }

        if ($user->is_admin) {
            $this->addError('email', 'User is already an admin.');
            return;
        }

        $user->is_admin = true;
        $user->save();

        $this->success = true;
    }

    public function render()
    {
        return view('livewire.become-admin')->layout('layouts.guest');
    }
}
