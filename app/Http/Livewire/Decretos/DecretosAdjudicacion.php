<?php

namespace App\Http\Livewire\Decretos;

use App\Decreto;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class DecretosAdjudicacion extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarSolicitud'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'decretos.id';
    public $orderAsc       = true;
    public $rol            = '';
    public $estado         = 'activo';
    public $editMode       = false;
    public $creatingMode   = false;

    public function render()
    {
        $decretos =  Decreto::leftJoin('solicituds', 'decretos.solicitud_id', '=', 'solicituds.id')
            ->where(function ($query) {
                $query->where('decretos.num_decreto', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.descripcion', 'like', '%' . $this->search . '%');
            })
            ->select('decretos.*', 'solicituds.adquisicion', 'solicituds.descripcion')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.decretos.decretos-adjudicacion', compact('decretos'));
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
