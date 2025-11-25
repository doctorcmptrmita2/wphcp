<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about');
    }

    public function whoWeAre(): View
    {
        return view('pages.who-we-are');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function roadmap(): View
    {
        return view('pages.roadmap');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }
}
