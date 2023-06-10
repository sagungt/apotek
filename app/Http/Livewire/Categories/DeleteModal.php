<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class DeleteModal extends Component
{
    public $categoryId;

    protected $listeners = ['setCategoryId'];

    public function setCategoryId($id)
    {
        $this->categoryId = $id;
    }

    public function delete()
    {
        try {
            Category::destroy($this->categoryId);
        } catch (\Exception $e) {
            return session()->flash('error', 'Failed');
        }

        $this->dispatchBrowserEvent('close-modal-delete-category');
        $this->emitUp('reset');

        return session()->flash('success', 'Category deleted!');
    }

    public function render()
    {
        return view('livewire.categories.delete-modal');
    }
}
