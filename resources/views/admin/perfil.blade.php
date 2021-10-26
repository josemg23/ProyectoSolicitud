@extends('layouts.nav')
@section('breadcrumb')
    <li class="active" aria-current="page"><a><i class="fas fa-user"></i> {{ Auth::user()->nombres }}</a></li>
@endsection
@section('content')
@section('css')
    <link href="{{ asset('assets/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />

@endsection
<div class="layout-px-spacing">
    <div class="row layout-spacing">
        <!-- Content -->
        <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
            <div class="user-profile layout-spacing">
                <div class="widget-content widget-content-area">

                    <div class="text-center user-info">
                        <img src="{{ Avatar::create(Auth::user()->nombres)->setChars(2) }}" alt="avatar">
                        <p class="">{{ Auth::user()->nombres }}</p>
                    </div>
                    <div class="user-info-list">
                        <div class="">
                            <ul class="contacts-block list-unstyled">
                                <li class="contacts-block__item text-capitalize">
                                    <i data-feather="coffee"></i> {{ getRole() }}
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">
            <div class="skills layout-spacing ">
                <div class="widget-content widget-content-area">
                    <div wire:ignore.self class="padding-20">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a wire:ignore class="nav-link active" id="personales-tab2" data-toggle="tab"
                                    href="#personales" role="tab" aria-selected="true">Personales</a>
                            </li>
                            <li class="nav-item">
                                <a wire:ignore class="nav-link" id="contrasena-tab2" data-toggle="tab"
                                    href="#contrasena" role="tab" aria-selected="false"> Contraseña</a>
                            </li>
                        </ul>
                        <div wire:ignore.self class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="personales" role="tabpanel"
                                aria-labelledby="personales-tab2" wire:ignore.self>
                                @livewire('componentes.perfil.datos-personales')

                            </div>
                            <div class="tab-pane fade" id="contrasena" role="tabpanel" aria-labelledby="contrasena-tab2"
                                wire:ignore.self>
                                @livewire('componentes.perfil.contrasena')

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
