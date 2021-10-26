<div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-4">
        <div class="card author-box">
            <div class="card-body">
                <div class="author-box-center">
                    <img alt="image" src="{{ Avatar::create($cuenta->descripcion)->setFontSize(35)->setChars(2) }}"
                        class="rounded-circle author-box-picture">
                    <div class="clearfix"></div>
                    <div class="author-box-name">
                        <a href="#">{{ $cuenta->nombre }}</a>
                    </div>
                </div>
                <div class="text-center">
                    <div class="author-box-description">
                        {{-- <p>
							{{ $cuenta->nombre }}
						</p> --}}
                    </div>
                    <div class="mb-2 mt-3">
                        <div class="text-small font-weight-bold">{{ $cuenta->descripcion }}</div>
                    </div>

                    <div class="w-100 d-sm-none"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Datos de la Cuenta</h4>
            </div>
            <div class="card-body">
                <div>
                    <p class="clearfix">
                        <span class="float-left font-weight-bold">
                            Saldo Inicial
                        </span>
                        <span class="float-right badge badge-primary">
                            {{ number_format($cuenta->saldo_i, 2, '.', ',') }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left font-weight-bold">
                            Saldo Actual
                        </span>
                        <span class="float-right badge badge-success">
                            {{ number_format($cuenta->saldo_a, 2, '.', ',') }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left font-weight-bold">
                            Estado
                        </span>
                        <span class="float-right text-muted">
                            {{ $cuenta->estado }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card">
            <div wire:ignore.self class="padding-20">
                <div wire:ignore.self class="tab-content tab-bordered" id="myTab3Content">
                    <div class="tab-pane fade show active" id="estudiante" role="tabpanel"
                        aria-labelledby="estudiante-tab2" wire:ignore.self>
                        <h3 class="text-center font-weight-bold text-danger">Historial de Cuenta</h3>
                        <div class="table-responsive" style="height: 500px; overflow-y: scroll;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Modulo</th>
                                        <th>Detalle</th>
                                        <th>Cantidad</th>
                                        <th>Proceso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cuenta->historial as $his)
                                        <tr>
                                            <td class="text-capitalize">{{ $his->historial_cuentable_type }}
                                            </td>
                                            <td>{{ $his->detalle }}</td>
                                            <td class="text-center">{{ number_format($his->cantidad, 2, ',', '.') }}
                                            </td>
                                            <td class="text-center text-capitalize">{{ $his->type }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
