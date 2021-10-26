@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user"></i> {{ $user->nombres }}</li>
@endsection
@section('content')
@section('user', 'active')
@section('titulo', '| '.$user->nombres)
<div id="confirmareliminar" >
	<div class="row">
		<div class="col-12 col-md-12 col-lg-4">
			<div class="card profile-widget">
				<div class="profile-widget-header">
					<img alt="image" src="{{ Avatar::create($user->nombres)->setFontSize(35)->setChars(4) }}" class="rounded-circle profile-widget-picture">
			
				</div>
				<div class="profile-widget-description pb-0">
					<div class="profile-widget-name text-center"> @role('super-admin') Super Admin @endrole @role('admin') Administrador @endrole <div class="text-muted d-inline font-weight-normal">
						
					</div>
				</div>
				<p>@isset ($user->instituto->nombre)
					{{ $user->instituto->nombre }}
				@endisset</p>
			</div>
		</div>
		
	</div>
	<div class="col-12 col-md-12 col-lg-8">
		<div class="card">
			<div wire:ignore.self class="padding-20">
				<ul  class="nav nav-tabs" id="myTab2" role="tablist">
					<li class="nav-item">
						<a wire:ignore class="nav-link active" id="personales-tab2" data-toggle="tab" href="#personales" role="tab" aria-selected="true">Personales</a>
					</li>
					<li class="nav-item">
						<a wire:ignore class="nav-link" id="contrasena-tab2" data-toggle="tab" href="#contrasena" role="tab" aria-selected="false"> Contraseña</a>
					</li>
				</ul>
				<div wire:ignore.self  class="tab-content tab-bordered" id="myTab3Content">
					<div class="tab-pane fade show active" id="personales" role="tabpanel" aria-labelledby="personales-tab2" wire:ignore.self>
						@livewire('component.datos-personales')
					
					</div>
					<div class="tab-pane fade" id="contrasena" role="tabpanel" aria-labelledby="contrasena-tab2" wire:ignore.self>
						@livewire('component.password')
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<br>
</div>
@endsection