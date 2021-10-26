<?php

namespace App\Observers;

use App\Cuenta;

class CuentaObserver
{
    /**
     * Handle the cuenta "created" event.
     *
     * @param  \App\Cuenta  $cuenta
     * @return void
     */
    public function created(Cuenta $cuenta)
    {
        //
    }

    /**
     * Handle the cuenta "updated" event.
     *
     * @param  \App\Cuenta  $cuenta
     * @return void
     */
    public function updated(Cuenta $cuenta)
    {
        if (isset($cuenta->convenio_id)) {
            syncConvenio($cuenta->convenio_id);
        }
    }

    /**
     * Handle the cuenta "deleted" event.
     *
     * @param  \App\Cuenta  $cuenta
     * @return void
     */
    public function deleted(Cuenta $cuenta)
    {
        //
    }

    /**
     * Handle the cuenta "restored" event.
     *
     * @param  \App\Cuenta  $cuenta
     * @return void
     */
    public function restored(Cuenta $cuenta)
    {
        //
    }

    /**
     * Handle the cuenta "force deleted" event.
     *
     * @param  \App\Cuenta  $cuenta
     * @return void
     */
    public function forceDeleted(Cuenta $cuenta)
    {
        //
    }
}
