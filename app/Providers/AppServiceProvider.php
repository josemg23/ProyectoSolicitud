<?php

namespace App\Providers;

use App\Cuenta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));
        Schema::defaultStringLength(191);
        Relation::morphMap([
            'solicitudes' => 'App\Solicitud',
            'contrato-suministro' => 'App\ContratoSuministro',
            'cuentas' => 'App\Cuenta',
            'aprobaciones' => 'App\Aprobacion',
            'ordenes' => 'App\OrdenCompra',
            'recepciones' => 'App\Recepcion',
        ]);

        Validator::extend('monto_cuenta', function ($attribute, $value, $parameters, $validator) {
            $validator->addReplacer('monto_cuenta', function ($message, $attribute, $rule, $parameters) {
                return str_replace(':attribute', $attribute, $message == 'validation.monto_cuenta'
                    ? 'Tu saldo actual no puede ser menor a 0.'
                    : $message);
            });
            $cuenta = Cuenta::find($parameters[0]);
            $diferencia = $value - $cuenta->saldo_i;

            $calculo = $cuenta->saldo_a + $diferencia;
            // dd($calculo);

            return  $calculo > 0;
        });
    }
}
