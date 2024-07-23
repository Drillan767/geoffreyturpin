<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Tags\Tag;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->tag) {
            $lang = app()->currentLocale();
            $params = [
                $request->tag,
                $lang,
            ];

            $tag = Tag::all()->first(function ($t) use($params) {
                list($label, $lang) = $params;
                return $t->getTranslation('slug', $lang) === $label;
            });

            $articles = Article::withAllTags($tag->getTranslation('name', $lang))->get();

            return view('front.articles.filter', compact('articles', 'tag'));
        } else {
            $articles = Article::where('draft', false)->get();
            $articles_id = $articles->map(fn ($article) => $article->id);

            $tags_id = DB::table('taggables')
                ->whereIn('taggable_id', $articles_id->toArray())
                ->distinct()
                ->pluck('tag_id');

            $tags = Tag::find($tags_id);

            return view('front.articles.index', compact('articles', 'tags'));
        }
    }

    public function show($slug)
    {
        $article = Article::all()->first(function ($article) use($slug) {
            return $article->getTranslation('slug', app()->getLocale()) === $slug;
        });

        return view('front.articles.show', compact('article'));
    }


}
