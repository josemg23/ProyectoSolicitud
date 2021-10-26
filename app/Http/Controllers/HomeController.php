<?php

namespace App\Http\Controllers;

use App\Fpdf\PDF;
use App\Solicitud;
use App\Traits\Pdfs\PdfTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use PdfTrait;
    public $pdf;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pdf = new PDF();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('login');
    }
}
