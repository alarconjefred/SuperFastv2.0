<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class LayouthController extends Controller
{
    public function dashboardcliente()
    {
        return view('layouts.dashboardcliente');
    }
}
class LayouthController extends Controller
{
    public function dashboardempresa()
    {
        return view('layouts.dashboardempresa');
    }
}
class LayouthController extends Controller
{
    public function dashborepartidor()
    {
        return view('layouts.dashboardreprepartidor');
    }
}
