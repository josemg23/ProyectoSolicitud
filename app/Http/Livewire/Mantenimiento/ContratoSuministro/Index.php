<?php

namespace App\Http\Livewire\Mantenimiento\ContratoSuministro;

use Livewire\Component;
use App\ContratoSuministro;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarTipo'];
    protected $queryString     = [
        'search'               => ['except' => ''],
        'page'
    ];
    public $perPage            = 10;
    public $search             = '';
    public $orderBy            = 'id';
    public $orderAsc           = true;
    public $editMode           = false;
    public function render()
    {
        $contratos = ContratoSuministro::where(
            function ($query) {
                $query->where('licitacion', 'like', '%' . $this->search . '%')
                    ->orWhere('decreto_adjudicacion', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha_termino', 'like', '%' . $this->search . '%')
                    ->orWhere('monto', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha_inicio', 'like', '%' . $this->search . '%');
            }
        )
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.contrato-suministro.index', compact('contratos'));
    }
    public function sortBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $field;
    }
}
