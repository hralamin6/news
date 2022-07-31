<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HeaderComponent extends Component
{
    public $search;
    protected $listeners = ['redirecting'];

    public function redirecting($data)
    {
        $this->search = $data;
    }
    public function send()
    {
        $this->emit('searched', $this->search);
    }
    public function render()
    {
        return view('livewire.header-component');
    }
    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }

}
