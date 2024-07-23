<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MusicRequest;
use App\Models\Music;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MusicController extends Controller
{
    const FIELDS = [
        'title',
        'author',
        'year',
        'subtitle',
        'iframe',
        'content',
    ];

    /**
     * @return Response
     */
    public function index(): Response
    {
        $musics = Music::all();
        return Inertia::render('Admin/Music/Index', compact('musics'));
    }

    /**
     * @param MusicRequest $request
     * @return RedirectResponse
     */
    public function store(MusicRequest $request): RedirectResponse
    {
        $music = new Music();
        $this->handleMusics($music, $request);

        return redirect()->back();
    }

    /**
     * @param Music $music
     * @param MusicRequest $request
     * @return RedirectResponse
     */
    public function update(Music $music, MusicRequest $request): RedirectResponse
    {
        $this->handleMusics($music, $request);
        return redirect()->back();
    }

    public function delete(Music $music)
    {
        $music->delete();
        return redirect()->back();
    }

    private function handleMusics(Music $music, $request)
    {
        foreach (self::FIELDS as $field) {
            if ($field === 'subtitle' && $request->filled('subtitle')) {
                $music->$field = $request->get($field);
            } elseif ($field === 'content') {
                $music->$field = [
                    'fr' => $request->get('content_fr'),
                    'en' => $request->get('content_en'),
                ];
            } else {
                $music->$field = $request->get($field);
            }
        }

        $music->save();
    }
}
