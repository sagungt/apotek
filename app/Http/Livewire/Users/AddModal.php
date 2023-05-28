<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class AddModal extends Component
{
    public $newUser;

    protected $rules = [
        'newUser.name'                         => 'required|min:3',
        'newUser.email'                        => 'required|email',
        'newUser.password'                     => 'required|min:8|max:255|confirmed',
        'newUser.password_confirmation'        => 'required',
        'newUser.role'                         => 'required|numeric|in:1,2,3'
    ];
    protected $messages = [
        'newUser.name.required'                     => 'The Name Field is required',
        'newUser.email.required'                    => 'The Name Email is required',
        'newUser.password.required'                 => 'The Name Password is required',
        'newUser.password_confirmation.required'    => 'The Name Password Confirmation is required',
        'newUser.role.required'                     => 'The Name Role is required'
    ];

    public function submit()
    {
        $validated = $this->validate();

        if (!Gate::allows('super-admin') && $validated['newUser']['role'] == 1) {
            return session()->flash('errorAdd', 'Not Allowed');
        }

        $data = [
            'name'      => $validated['newUser']['name'],
            'email'     => $validated['newUser']['email'],
            'role'      => $validated['newUser']['role'],
            'password'  => bcrypt($validated['newUser']['password']),
        ];
        
        User::create($data);

        $this->emitUp('reset');

        return session()->flash('success', 'User successfully created!');
    }

    public function render()
    {
        return view('livewire.users.add-modal');
    }
}
