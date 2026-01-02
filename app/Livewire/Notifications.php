<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsDropdown extends Component
{
    public $notifications = [];

    protected $listeners = [];

    public function mount()
    {
        // Dynamically add the Echo private listener
        $this->listeners['echo-private:user.' . Auth::id() . ',ClubProposalStatusUpdated'] = 'receiveNotification';
    }

    public function receiveNotification($payload)
    {
        $this->notifications[] = $payload['message'];
    }

    public function render()
    {
        return view('livewire.notifications-dropdown');
    }
}
