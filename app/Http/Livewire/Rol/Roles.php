<?php

namespace App\Http\Livewire\Rol;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarDepartamento'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page',
    ];


    public $perPage         = 10;
    public $search          = '';
    public $orderBy         = 'id';
    public $orderAsc        = true;
    public $role            = '';
    public $estado          = 'activo';
    public $permisos          = [];
    public $permissions = [];
    public $libres          = [];
    public $allRoles          = [];
    public $editMode        = false;
    public $creatingMode    = false;


    public $nombre, $dependencia_id = '';
    public function render()
    {
        $this->libres = Permission::where(function ($query) {
            if (count($this->permisos) > 0) {
                $query->whereNotIn('name', $this->permisos->pluck('name'));
            }
        })->get();
        $this->allRoles = Role::select('name', 'description')->whereNotIn('name', ['super-admin'])->get();
        $roles = Role::whereNotIn('name', ['super-admin'])
            ->with(['permissions'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
        return view('livewire.rol.roles', compact('roles'));
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
    public function editPermisos($name)
    {
        $this->role = $name;
        $this->obtenerPermisos();
    }
    public function quitarPermiso($permiso)
    {
        $role = Role::where('name', $this->role)->first();
        $role->revokePermissionTo($permiso);
        $this->obtenerPermisos();
    }
    public function asignarPermiso($permiso)
    {
        $role = Role::where('name', $this->role)->first();
        $role->givePermissionTo($permiso);
        $this->obtenerPermisos();
    }
    public function obtenerPermisos()
    {
        $role = Role::where('name', $this->role)->with(['permissions'])->first();
        $this->permisos = $role->permissions;
        // $this->permissions = $role->permissions->select('name', 'description');
    }
    public function resetModal()
    {
        $this->reset(['role', 'permisos']);
    }
}
