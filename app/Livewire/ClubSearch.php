<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Club;

class ClubSearch extends Component
{
    public $search = '';
    public $clubs = [];

    public function mount()
    {
        $this->clubs = Club::latest()->get();
    }

    // Triggered when user presses Enter
    public function searchClubs()
    {
        $this->clubs = Club::query()
            ->when($this->search, function ($query) {
                $query->where('clubname', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();
    }

    // Auto update on typing
    public function updatedSearch()
    {
        $this->searchClubs();
    }

    public function render()
    {
        return view('livewire.club-search', [
            'clubs' => $this->clubs
        ]);
    }
}
