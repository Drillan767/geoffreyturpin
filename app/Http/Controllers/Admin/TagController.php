<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\Tags\Tag;

class TagController extends Controller
{
    public function index()
    {
        return response()->json($this->handleTags());
    }

    public function update(TagRequest $request)
    {
        $tag = Tag::find($request->get('id'));
        if ($request->has('created')) {
            $tag = new Tag();
        }

        $tag->name = [
            'en' => $request->get('en'),
            'fr' => $request->get('fr')
        ];

        $tag->save();

        return response()->json($this->handleTags());
    }
    private function handleTags()
    {
        return Tag::all()->map(function($tag) {
            return [
                'id' => $tag->id,
                'fr' => $tag->getTranslation('name', 'fr'),
                'en' => $tag->getTranslation('name', 'en'),
            ];
        });
    }

    /**
     * @param $lang
     * @return JsonResponse
     */
    public function getTags($lang): JsonResponse
    {
        $translated = Tag::all()->reject(function($tag) use($lang) {
            return $tag->getTranslation('name', $lang) === '';
        })->map(function($tag) use($lang) {
            return [
                'name' => $tag->getTranslation('name', $lang),
                'id' => $tag->id,
            ];
        });

        return response()->json($translated);
    }

    public function remove(Tag $tag)
    {
        $tag->delete();
        return response()->json($this->handleTags());
    }
}
