<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditModal extends Component
{
    public $user;

    protected $listeners = ['setUser'];

    protected $rules = [
        'user.name'                         => 'required|min:3',
        'user.email'                        => 'required|email',
        'user.new_password'                 => 'nullable|min:8|max:255|confirmed',
        'user.new_password_confirmation'    => 'nullable',
        'user.role'                         => 'required|numeric|in:1,2,3'
    ];
    protected $messages = [
        'user.name.required'                         => 'The Name Field is required',
        'user.email.required'                        => 'The Name Email is required',
        'user.role.required'                         => 'The Name Role is required'
    ];

    public function setUser($id)
    {
        $this->user = User::find($id);
    }

    public function submit()
    {
        $validated = $this->validate();

        if (!Gate::allows('super-admin') && $validated['user']['role'] == 1) {
            return session()->flash('errorEdit', 'Not Allowed');
        }

        $data = [
            'name'      => $validated['user']['name'],
            'email'     => $validated['user']['email'],
            'role'      => $validated['user']['role'],
        ];
        
        if ($validated['user']['new_password']) {
            $data = [
                ...$data,
                'password'  => bcrypt($validated['user']['new_password']),
            ];
        }

        unset($this->user->new_password);
        unset($this->user->new_password_confirmation);

        $this->user->update($data);

        $this->emitUp('reset');

        return session()->flash('success', 'User successfully updated!');
    }

    public function render()
    {
        return view('livewire.users.edit-modal');
    }
}
