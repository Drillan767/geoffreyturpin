<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BiographyRequest;
use App\Models\Biography;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BiographyController extends Controller
{
    public function index(): Response
    {
        $events = Biography::orderBy('year', 'ASC')->get();
        return Inertia::render('Admin/Biography/Index', compact('events'));
    }

    public function store(Request $request): RedirectResponse
    {
        $biography = new Biography();
        $this->handleBiography($biography, $request);

        return redirect()->back();
    }

    public function update(Biography $biography, Request $request)
    {
        $this->handleBiography($biography, $request);
        return redirect()->back();
    }

    public function delete(Biography $biography)
    {
        $biography->delete();
        return redirect()->back();
    }

    private function handleBiography(Biography $biography, $request) {
        $biography->year = $request->get('year');
        $biography->text = [
            'en' => $request->get('text_en'),
            'fr' => $request->get('text_fr'),
        ];

        $biography->save();
    }
}
