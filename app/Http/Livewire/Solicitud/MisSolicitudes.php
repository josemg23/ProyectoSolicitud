<?php

namespace App\Http\Livewire\Solicitud;

use App\Solicitud;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\App;

class MisSolicitudes extends Component
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
    public $orderBy        = 'solicituds.id';
    public $orderAsc       = true;
    public $rol            = '';
    public $estado         = 'activo';
    public $editMode       = false;
    public $creatingMode   = false;
    public $borrador;

    public function mount($borrador = false)
    {
        $this->borrador = $borrador;
    }
    public function render()
    {
        $solicitudes =  Solicitud::join('dependencias', 'solicituds.dependencia_id', '=', 'dependencias.id')
            ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
            ->where(function ($query) {
                if ($this->borrador) {
                    $query->where('solicituds.estado', 'borrador');
                } else {
                    $query->where('solicituds.estado', '!=', 'borrador');
                }
            })
            ->where(function ($query) {
                $query->where('solicituds.tipo', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.total', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.descripcion', 'like', '%' . $this->search . '%');
            })
            ->orWhere('solicituds.id', $this->search)
            ->select('solicituds.*', 'dependencias.nombre as dependencia', 'departamentos.nombre as departamento')

            ->withTrashed()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.solicitud.mis-solicitudes', compact('solicitudes'));
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
    public function editSolicitud($tipo, $id)
    {
        if ($tipo == 'contrato-suministros') {
            return redirect()->to("solicitudes/contratos-suministros?solicitud={$id}");
        } elseif ($tipo == 'insumos') {
            return redirect()->to("solicitudes/insumos-y-servicios?solicitud={$id}");
        } elseif ($tipo == 'convenios') {
            return redirect()->to("solicitudes/convenios?solicitud={$id}");
        } elseif ($tipo == 'mantenimiento') {
            return redirect()->to("solicitudes/mantenimiento?solicitud={$id}");
        }
    }
    public function eliminarSolicitud(Solicitud $solicitud)
    {
        if (count($solicitud->aprobaciones) == 0) {
            $solicitud->estado = 'eliminado';
            $solicitud->save();
            $solicitud->delete();
        } else {
            $this->emit('error', ['mensaje' => 'No puedes eliminar esta solicitud, porque ya tiene aprobaciones']);
        }
    }
    public function pdfGenerate(Solicitud $solicitud)
    {
        $data = $solicitud->tipo;
        $solicitud = Solicitud::with([
            'aprobaciones',
            'dependencia' => function ($query) use ($data) {
                $query->select('id', 'nombre');
            },
            'departamento' => function ($query) use ($data) {
                $query->select('id', 'nombre');
            },
            'contrato',
            'convenio' => function ($query) use ($data) {
                if ($data == 'convenios') {
                    $query->with(['products']);
                }
            }, 'insumo' => function ($query) use ($data) {
                if ($data == 'insumos') {
                    $query->with(['products']);
                }
            }
        ])->find(16);
        // return $solicitud;
        // return response()->streamDownload(
        //     fn () => echo $pdf->stream(),
        //     "filename.pdf"
        // );

        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->stream();
        // }, 'test.pdf');
        return response()->streamDownload(function () {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML('<h1>Test</h1>');
            echo $pdf->stream();
        }, 'test.pdf');
    }
    public function showSolicitud($id, $tipo)
    {
        if ($tipo == 'contrato-suministros') {
            return redirect()->route('solicitudes.suministros.show', $id);
        } elseif ($tipo == 'insumos') {
            return redirect()->route('solicitudes.insumos.show', $id);
        } elseif ($tipo == 'convenios') {
            return redirect()->route('solicitudes.convenios.show', $id);
        } elseif ($tipo == 'mantenimiento') {
            return redirect()->route('solicitudes.mantenimiento.show', $id);
        }
    }
}
