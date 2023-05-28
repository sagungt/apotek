<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $userId;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['reset' => 'refresh', 'delete', 'setUserId'];

    public function refresh()
    {
        $this->resetPage();
    }

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
        $this->refresh();
        return session()->flash('success', 'User deleted!');
    }

    public function render()
    {
        $users = User::query()
            ->when(strlen($this->search) > 0, fn ($query) =>
                $query
                    ->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
            )
            ->paginate(10);
        return view('livewire.users.index', compact('users'));
    }
}
