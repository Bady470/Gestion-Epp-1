<?php

namespace App\Http\Livewire;

use App\Models\ElementoPP;
use App\Models\Ficha;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardInstructor extends Component
{
    use WithPagination;

    public $user;
    public $fichas;
    public $selectedFicha = null;
    public $cartCount = 0;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->user = Auth::user();

        if (! $this->user?->areas_id) {
            return redirect()->back()->with('error', 'No tienes un área asignada.');
        }

        $this->fichas = Ficha::whereHas('programa', function ($query) {
            $query->where('areas_id', $this->user->areas_id);
        })->get();
    }

    public function updatingSelectedFicha()
    {
        $this->resetPage();
    }

    public function render()
    {
        $elementos = ElementoPP::with(['area', 'filtro'])
            ->where('areas_id', $this->user->areas_id)
            ->paginate(10);

        return view('livewire.dashboard-instructor', [
            'elementos' => $elementos,
        ]);
    }
}
