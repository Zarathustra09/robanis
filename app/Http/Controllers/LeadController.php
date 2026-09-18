<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): RedirectResponse
    {
        // Honeypot: real visitors never fill this in. Bots that do get the
        // same success response but nothing is stored, so they learn nothing.
        if (filled($request->input('website'))) {
            return $this->success();
        }

        Lead::create([
            ...$request->safe()->except(['website', 'source_page']),
            'source_page' => $request->input('source_page') ?: '/contact',
            'ip_address' => $request->ip(),
        ]);

        return $this->success();
    }

    private function success(): RedirectResponse
    {
        return redirect()->route('contact')
            ->with('status', "Thanks — we'll reply within one business day.");
    }
}
