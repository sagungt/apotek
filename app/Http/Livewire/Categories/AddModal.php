<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class AddModal extends Component
{
    public $newCategory;

    protected $rules = [
        'newCategory.nama_kategori'          => 'required|unique:kategori,nama_kategori',
    ];
    protected $messages = [
        'newCategory.nama_kategori.required' => 'The Category Name field is required',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'nama_kategori'  => $validated['newCategory']['nama_kategori'],
        ];
        
        Category::create($data);

        $this->dispatchBrowserEvent('close-modal-add-category');
        $this->emitUp('reset');
        $this->reset(['newCategory']);

        return session()->flash('success', 'Category successfully created!');
    }

    public function render()
    {
        return view('livewire.categories.add-modal');
    }
}
