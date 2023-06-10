<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class EditModal extends Component
{
    public $category;

    protected $listeners = ['setCategory'];

    protected $rules = [
        'category.name'             => 'required|unique:categories,name',
    ];
    protected $messages = [
        'category.name.required'    => 'The Category Name field is required',
    ];

    public function setCategory($id)
    {
        $this->category = Category::find($id);
    }

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'name'  => $validated['category']['name'],
        ];

        $this->category->update($data);

        $this->emitUp('reset');

        return session()->flash('success', 'Category successfully updated!');
    }

    public function render()
    {
        return view('livewire.categories.edit-modal');
    }
}
