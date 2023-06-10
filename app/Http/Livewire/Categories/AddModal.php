<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class AddModal extends Component
{
    public $newCategory;

    protected $rules = [
        'newCategory.name'          => 'required|unique:categories,name',
    ];
    protected $messages = [
        'newCategory.name.required' => 'The Category Name field is required',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'name'  => $validated['newCategory']['name'],
        ];
        
        Category::create($data);

        $this->dispatchBrowserEvent('close-modal-category-user');
        $this->emitUp('reset');
        $this->reset(['newCategory']);

        return session()->flash('success', 'Category successfully created!');
    }

    public function render()
    {
        return view('livewire.categories.add-modal');
    }
}
