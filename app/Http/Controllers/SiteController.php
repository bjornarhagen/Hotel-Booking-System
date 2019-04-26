<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    /**
     * Show the frontpage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('site.index');
    }
}
