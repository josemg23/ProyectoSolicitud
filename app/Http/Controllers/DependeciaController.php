<?php

namespace App\Http\Controllers;

use App\Dependecia;
use Illuminate\Http\Request;

class DependeciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mantenimiento.dependencias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dependecia  $dependecia
     * @return \Illuminate\Http\Response
     */
    public function show(Dependecia $dependecia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dependecia  $dependecia
     * @return \Illuminate\Http\Response
     */
    public function edit(Dependecia $dependecia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dependecia  $dependecia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dependecia $dependecia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dependecia  $dependecia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dependecia $dependecia)
    {
        //
    }
}
