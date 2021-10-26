<?php

namespace App\Http\Livewire\Admin\User;

use App\User;
use App\Instituto;
use Carbon\Carbon;
use App\Departamento;
use DepartamentoSeeder;
use Livewire\Component;
use App\Mail\UserRegister;
use App\Exports\UserExport;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class Usuarios extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarUser'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page', 'findrole' => ['except' => '']
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'id';
    public $orderAsc       = true;
    public $findrole       = '';
    public $role           = '';
    public $rol            = '';
    public $estado         = 'activo';
    public $permiso        = '';
    public $user_id        = '';
    public $roles          = [];
    public $permissions    = [];
    public $allRoles       = [];
    public $departamentos       = [];
    public $editMode       = false;
    public $creatingMode   = false;

    // CREAR Usuarios
    public $reNombres, $reEmail, $reTelefono, $reCelular, $reDireccion, $reUsuario, $file, $departamento_id = '';
    public function render()
    {
        $this->roles = Role::whereNotIn('name', ['super-admin'])->select('name', 'description')->get();
        $this->departamentos = Departamento::with(['dependencia' => fn ($query) => $query->select('id', 'nombre')])->where('estado', 'activo')->get();
        $data = User::where('users.id', '!=', 1)
            ->where(function ($query) {
                $query->where('users.nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('users.username', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if ($this->findrole !== '') {
                    $query->role($this->findrole);
                }
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.admin.user.usuarios', compact('data'));
    }
    public function crearUsuario()
    {
        $this->validate([
            'reNombres'   => 'required',
            'reUsuario'    => 'required|unique:users,username',
            'reEmail'     => 'required|email|unique:users,email',
            'rol'         => 'required',
            'departamento_id'         => 'required',

        ], [
            'reNombres.required'   => 'No has agregado el nombre del usuario',
            'reUsuario.required'    => 'No has agregado el usuario',
            'reUsuario.unique'      => 'Este usuario ya se encuentra registrado',
            'reCedula.unique'      => 'Esta cedula o DNI ya se encuentra registrado',
            'reEmail.required'     => 'No has agregado el correo',
            'reEmail.email'        => 'Agrega un correo valido',
            'reEmail.unique'       => 'Este correo ya se encuentra en uso',
            'rol.required'         => 'No has selecionado un rol',
        ]);
        $this->creatingMode = true;

        // $clave = Str::random(10);
        $clave              = 12345678;
        $user               = new User;
        $user->nombres      = $this->reNombres;
        $user->username     = $this->reUsuario;
        $user->departamento_id     = $this->departamento_id;
        $user->email        = $this->reEmail;
        $user->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $user->password     = Hash::make($clave);
        $user->save();

        $user->assignRole($this->rol);
        $this->resetInput();
        $this->emit('success', ['mensaje' => 'Usuario Registrado Correctamente', 'modal' => '#createUser']);

        // Mail::to($user->email)->send(new UserRegister($user, $clave));

        $this->creatingMode = false;
    }
    public function resetInput()
    {
        $this->reNombres = null;
        $this->rol       = "";
        $this->user_id   = "";
        $this->departamento_id   = "";
        $this->estado    = "activo";
        $this->reUsuario = null;
        $this->reEmail   = null;
        $this->editMode  = false;
    }
    public function editUser($id)
    {
        $this->user_id   = $id;
        $user            = User::find($id);
        $this->reNombres = $user->nombres;
        $this->reUsuario = $user->username;
        $this->departamento_id = $user->departamento_id ? $user->departamento_id : '';
        $this->reEmail   = $user->email;
        $this->estado    = $user->estado;
        $this->editMode  = true;
        $this->rol = $user->roles[0]->name;
        // if ($user->hasRole('admin')) {
        //     $this->rol         = "admin";
        // } elseif ($user->hasRole('jefe')) {
        //     $this->rol         = "jefe";
        // } elseif ($user->hasRole('director')) {
        //     $this->rol         = "director";
        // } elseif ($user->hasRole('supervisor')) {
        //     $this->rol         = "supervisor";
        // } elseif ($user->hasRole('sub-director')) {
        //     $this->rol         = "sub-director";
        // } elseif ($user->hasRole('coordinador')) {
        //     $this->rol         = "coordinador";
        // }
    }
    public function updateUser()
    {
        $this->validate([
            'reNombres'   => 'required',
            'reUsuario'    => 'required|unique:users,username,' . $this->user_id,
            'reEmail'     => 'required|email|unique:users,email,' . $this->user_id,
            'rol'         => 'required',
            'departamento_id'         => 'required',


        ], [
            'reNombres.required'   => 'No has agregado el nombre del usuario',
            'reUsuario.required'   => 'No has agregado el usuario',
            'reUsuario.unique'     => 'Este usuario ya se encuentra registrado',
            'reEmail.required'     => 'No has agregado el correo',
            'reEmail.email'        => 'Agrega un correo valido',
            'reEmail.unique'       => 'Este correo ya se encuentra en uso',
            'rol.required'         => 'No has selecionado un rol',
        ]);
        $user           = User::find($this->user_id);
        $user->nombres  = $this->reNombres;
        $user->username = $this->reUsuario;
        $user->email    = $this->reEmail;
        $user->departamento_id     = $this->departamento_id;
        $user->estado   = $this->estado;
        $user->save();
        $user->syncRoles([$this->rol]);
        $this->resetInput();
        $this->emit('info', ['mensaje' => 'Usuario Actualizado Correctamente', 'modal' => '#createUser']);
    }
    public function eliminarUser($id)
    {
        $user = User::find($id);
        $user->delete();
        $this->emit('info', ['mensaje' => 'Usuario Eliminado Correctamente']);
    }
    public function estadochange($id)
    {
        $estado = User::find($id);
        if ($estado->estado == 'activo') {
            $estado->estado = 'inactivo';
            $estado->save();
            $this->emit('info', ['mensaje' => 'Estado Desactivado Actualizado']);
        } else {
            $estado->estado = 'activo';
            $estado->save();
            $this->emit('info', ['mensaje' => 'Estado Activado Actualizado']);
        }
    }
    public function generaExcel()
    {
        $usuarios = User::where('users.id', '!=', 1)
            ->where(function ($query) {
                $query->where('users.nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('users.username', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if ($this->findrole !== '') {
                    $query->role($this->findrole);
                }
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->get();

        return Excel::download(new UserExport($usuarios), 'usuarios_' . now() . '.xlsx');
    }
}
