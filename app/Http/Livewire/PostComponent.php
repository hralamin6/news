<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PostComponent extends Component
{
    public $post;
    use LivewireAlert;
    public $question, $answer, $image, $category_id;
    protected $listeners = ['deleteMultiple', 'deleteSingle', 'searched'];

    public function searched($data)
    {
        return redirect()->route('home')->with('message', $data);
    }

    public function saveData()
    {
        $data =  $this->validate([
            'question' => ['required', 'min:2', 'max:5555', Rule::unique('posts', 'question')->ignore($this->post['id'])],
            'answer' => ['required', 'min:2', 'max:55555'],
            'category_id' => ['required'],
            'image' => ['required', 'url'],
        ]);
        $data = $this->post->update($data);
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->post->id]);
        $this->alert('success', __('Data updated successfully'));
//        $this->reset('question', 'answer', 'category_id');
    }

    public function mount(Post $post)
    {
        $Key = 'blog' . $post->id;
        if (Session::has($Key)) {
        }else{
            $post->increment('views');
            Session::put($Key, 1);
        }
        $this->post = $post;
        $this->question = $post->question;
        $this->answer = $post->answer;
        $this->category_id = $post->category_id;
        $this->image = $post->image;
    }
    public function render()
    {
        $categories = Category::where('status', 'active')->get();
        return view('livewire.post-component', compact('categories'));
    }
    public function deleteSingle(Post $post)
    {
        $post->delete();
        $this->alert('success', __('Data deleted successfully'));
        return redirect()->route('home');
    }

}
