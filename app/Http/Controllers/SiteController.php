<?php

namespace App\Http\Controllers;

use App\Hotel;

class SiteController extends Controller
{
    /**
     * Show the frontpage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('site.index');

        $hotel = Hotel::where('slug', 'havnehotellet-i-halden')->first();
        return redirect()->route('hotel.show', $hotel->slug);
    }
}
