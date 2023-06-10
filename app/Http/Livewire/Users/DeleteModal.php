<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class DeleteModal extends Component
{
    public $userId;

    protected $listeners = ['setUserId'];

    public function setUserId($id)
    {
        $this->userId = $id;
    }

    public function delete()
    {
        try {
            User::destroy($this->userId);
        } catch (\Exception $e) {
            return session()->flash('error', 'Failed');
        }

        $this->dispatchBrowserEvent('close-modal-delete-user');
        $this->emitUp('reset');

        return session()->flash('success', 'User deleted!');
    }

    public function render()
    {
        return view('livewire.users.delete-modal');
    }
}
