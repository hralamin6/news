<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    protected $listeners = ['deleteMultiple', 'deleteSingle', 'searched'];
    use WithPagination;
    use LivewireAlert;
    public $category, $name, $search='';

    public function searched($data)
    {
        $this->search = $data;
    }
    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
    }
    public function saveData()
    {
            $data = $this->validate([
                'name' => ['required', 'min:2', 'max:44', Rule::unique('categories', 'name')->ignore($this->category['id'])],
            ]);
            $this->category->update($data);
            $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->category->id]);
            $this->alert('success', __('Data updated successfully'));
    }
    public function render()
    {
        $posts = Post::with('category')->where('status', 'active')->where('question', 'like', '%'.$this->search.'%')->where('category_id', $this->category->id)->paginate(12);
        return view('livewire.category-component', compact('posts'));
    }

    public function deleteSingle(Category $category)
    {
        $category->delete();
        $this->alert('success', __('Data deleted successfully'));
    }

}
