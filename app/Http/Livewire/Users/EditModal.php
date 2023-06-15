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
        'user.username'                     => 'required|min:4|unique:users,username|alpha_num:ascii',
        'user.new_password'                 => 'nullable|min:8|max:255|confirmed',
        'user.new_password_confirmation'    => 'nullable',
        'user.new_shared_password'          => 'nullable',
        'user.role'                         => 'required|numeric|in:1,2,3'
    ];
    protected $messages = [
        'user.name.required'                         => 'The Username field is required',
        'user.role.required'                         => 'The Role field is required'
    ];

    public function setUser($id)
    {
        $this->user = User::find($id);
    }

    public function submit()
    {
        $validated = $this->validate();

        if (!Gate::allows('pemilik') && $validated['user']['role'] == 1) {
            return session()->flash('errorEdit', 'Not Allowed');
        }

        $data = [
            'username'  => $validated['user']['username'],
            'role'      => $validated['user']['role'],
        ];
        
        if ($validated['user']['new_password']) {
            $data = [
                ...$data,
                'password'  => bcrypt($validated['user']['new_password']),
            ];
        }

        if ($validated['user']['new_shared_password']) {
            $data = [
                ...$data,
                'shared_password'  => bcrypt($validated['user']['new_shared_password']),
            ];
        }

        unset($this->user->new_password);
        unset($this->user->new_password_confirmation);
        unset($this->user->new_shared_password);

        $this->user->update($data);

        $this->emitUp('reset');

        return session()->flash('success', 'User successfully updated!');
    }

    public function render()
    {
        return view('livewire.users.edit-modal');
    }
}
