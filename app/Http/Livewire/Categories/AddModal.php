<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class AddModal extends Component
{
    public $newCategory;

    protected $rules = [
        'newCategory.nama_kategori'          => 'required|unique:kategori,nama_kategori',
        'newCategory.deskripsi'              => 'nullable',
    ];
    protected $messages = [
        'newCategory.nama_kategori.required' => 'The Category Name field is required',
        'newCategory.deskripsi.required'     => 'The Category Description field is required',
    ];

    public function submit()
    {
        $validated = $this->validate();

        Category::create([...$validated['newCategory']]);

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
