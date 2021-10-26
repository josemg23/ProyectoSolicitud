<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\LogError;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->token == env('APP_KEY')) {
            $logs = LogError::all();
            return response()->json(['message' => 'OK', 'data' => $logs], 200);
        } else {
            return response()->json(['message' => 'Token Incorrecto'], 401);
        }
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
     * @param  \App\LogError  $logError
     * @return \Illuminate\Http\Response
     */
    public function show(LogError $logError)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LogError  $logError
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogError $logError)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LogError  $logError
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogError $logError)
    {
        //
    }
}
