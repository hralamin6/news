<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SidebarComponent extends Component
{
    use LivewireAlert;
    public $cat_id;
    public $name, $search='';
    protected $listeners = ['postAdded'=> 'postAdded'];
    public function saveData()
    {
        $data =  $this->validate([
            'name' => ['required', 'min:2', 'max:111', Rule::unique('categories', 'name')],
        ]);
        $data = Category::create($data);
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$data->id]);
        $this->alert('success', __('Data saved successfully'));
        $this->reset('name');
    }

    public function render()
    {
        $categories = Category::withCount('posts')->where('status', 'active')->where('name', 'like', '%'.$this->search.'%')->orderBy('id', 'desc')->get();
        return view('livewire.sidebar-component', compact('categories'));
    }
}
