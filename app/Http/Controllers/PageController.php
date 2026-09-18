<?php

namespace App\Http\Controllers;

use App\Support\Offerings;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'services' => Offerings::all(),
        ]);
    }

    public function services(): View
    {
        return view('pages.services', [
            'services' => Offerings::all(),
        ]);
    }

    public function service(string $service): View
    {
        return view('pages.service', [
            'service' => Offerings::find($service),
            'otherServices' => Offerings::all()->except($service),
        ]);
    }

    public function whyUs(): View
    {
        return view('pages.why-us');
    }

    public function contact(Request $request): View
    {
        $tier = $request->query('tier');
        $tierInterest = in_array($tier, Offerings::tierSlugs(), true) ? $tier : null;

        return view('pages.contact', [
            'tierInterest' => $tierInterest,
            'tierLabel' => $tierInterest ? Offerings::tierLabel($tierInterest) : null,
        ]);
    }
}
