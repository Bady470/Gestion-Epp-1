<?php

namespace App\Http\Livewire;

use App\Models\ElementoPP;
use App\Models\Ficha;
use App\Models\Programa;
use App\Models\User;
use Livewire\Component;

class DashboardAdmin extends Component
{
    public int $usuariosCount = 0;
    public int $fichasCount = 0;
    public int $programasCount = 0;
    public int $eppsCount = 0;

    public function mount()
    {
        $this->refreshCounts();
    }

    public function refreshCounts(): void
    {
        $this->usuariosCount = User::count();
        $this->fichasCount = Ficha::count();
        $this->programasCount = Programa::count();
        $this->eppsCount = ElementoPP::count();
    }

    public function render()
    {
        return view('livewire.dashboard-admin');
    }
}
