<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class HomeComponent extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $question, $search='', $answer, $image, $category_id;
    protected $queryString = [
        'page'
    ];
    protected $listeners = ['searched'];

    public function searched($data)
    {
        $this->search = $data;
    }

    public function mount()
    {
        if (session()->has('message')){
           $this->search = session()->get('message');
            $this->emit('redirecting', $this->search);
        }
    }
    public function saveData()
    {
            $data =  $this->validate([
                'question' => ['required', 'min:2', 'max:5555', Rule::unique('posts', 'question')],
                'answer' => ['required', 'min:2', 'max:55555'],
                'category_id' => ['required'],
                'image' => ['required', 'url'],
            ]);
            $data = Post::create($data);
            $this->emit('dataAdded', ['dataId' => 'item-id-'.$data->id]);
            $this->alert('success', __('Data saved successfully'));
            $this->reset('question', 'answer', 'category_id', 'image');
    }
    public function render()
    {
        $categories = Category::where('status', 'active')->get();
        $posts = Post::with('category')->where('status', 'active')->where('question', 'like', '%'.$this->search.'%')->orderBy('id', 'desc')->paginate(12);
        return view('livewire.home-component', compact('posts', 'categories'));
    }
}
