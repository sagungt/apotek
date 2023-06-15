<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class AddModal extends Component
{
    public $newUser;

    protected $rules = [
        'newUser.username'                     => 'required|min:4|unique:users,username|alpha_num:ascii',
        'newUser.password'                     => 'required|min:8|max:255|confirmed',
        'newUser.password_confirmation'        => 'required',
        'newUser.role'                         => 'required|numeric|in:1,2,3'
    ];
    protected $messages = [
        'newUser.username.required'                 => 'The Username field is required',
        'newUser.password.required'                 => 'The Password field is required',
        'newUser.password_confirmation.required'    => 'The Password Confirmation field is required',
        'newUser.role.required'                     => 'The Role field is required'
    ];

    public function submit()
    {
        $validated = $this->validate();

        if (!Gate::allows('pemilik') && $validated['newUser']['role'] == 1) {
            return session()->flash('errorAdd', 'Not Allowed');
        }

        $data = [
            'username'  => $validated['newUser']['username'],
            'role'      => $validated['newUser']['role'],
            'password'  => bcrypt($validated['newUser']['password']),
        ];
        
        User::create($data);

        $this->dispatchBrowserEvent('close-modal-add-user');
        $this->emitUp('reset');
        $this->reset(['newUser']);

        return session()->flash('success', 'User successfully created!');
    }

    public function render()
    {
        return view('livewire.users.add-modal');
    }
}
