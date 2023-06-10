<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['reset' => 'refresh'];

    public function refresh()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $categories = Category::query()
            ->when(strlen($this->search) > 0, fn ($query) =>
                $query
                    ->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
            )
            ->paginate(10);
        
        return view('livewire.categories.index', compact('categories'));
    }
}
