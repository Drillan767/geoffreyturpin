<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Tags\Tag;

class ArticleController extends Controller
{
    public function index(): Response
    {
        $articles = Article::all();
        return Inertia::render('Admin/Articles/Index', compact('articles'));
    }

    public function create()
    {
        $tiny_secret = env('TINY_SECRET');
        return Inertia::render('Admin/Articles/Create', compact('tiny_secret'));
    }

    /**
     * @param ArticleRequest $request
     * @return RedirectResponse
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function store(ArticleRequest $request): RedirectResponse
    {
        $article = new Article();
        $this->handleArticle($article, $request);

        return redirect()->to(route('admin.articles.index'))->with('success', 'Article créé avec succès.');
    }

    /**
     * @param Article $article
     * @return Response
     */
    public function edit(Article $article): Response
    {
        $tiny_secret = env('TINY_SECRET');
        return Inertia::render('Admin/Articles/Edit', compact('article', 'tiny_secret'));
    }

    /**
     * @param Article $article
     * @return Response
     */
    public function translate(Article $article): Response
    {
        $tiny_secret = env('TINY_SECRET');

        if (count($article->getTranslations('title')) === 1) {
            return Inertia::render('Admin/Articles/Translate', compact('article', 'tiny_secret'))->with(
                'message',
                "L'article affiché ci-dessous est affiché avec sa langue par défaut mais sera enregistré dans la langue alternative.
                Attention, toute image uploadée ici ne sera pas affichée pour l'autre langue et inversement."
            );
        } else {
            return Inertia::render('Admin/Articles/Translate', compact('article', 'tiny_secret'));
        }
    }

    /**
     * @param Article $article
     * @param ArticleRequest $request
     * @return RedirectResponse
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function update(Article $article, ArticleRequest $request): RedirectResponse
    {
        $this->handleArticle($article, $request, $editing = TRUE, $translating = $request->has('translating'));
        return redirect()->to(route('admin.articles.index'))->with('success', 'Article mit à jour avec succès.');
    }

    /**
     * @param Article $article
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete(Article $article): RedirectResponse
    {
        $article->clearMediaCollection();
        $article->delete();
        return redirect()->back()->with('success', 'Article supprimé avec succès');
    }

    /**
     * @param Article $article
     * @param ArticleRequest $request
     * @param bool $editing
     * @param bool $translating
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function handleArticle(Article $article, ArticleRequest $request, $editing = FALSE, $translating = FALSE)
    {
        $lang = $request->get('lang');
        $translated = json_decode($article->translated);

        if ($editing && !in_array($lang, $translated)) {
            if ($translating) {
                $translated[] = $lang;
            } else {
                $translated = [$lang];
            }

            $article->translated = json_encode($translated);
        }

        $article->default_lang = $lang;

        $article->draft = boolval($request->get('draft'));
        $article->draft = boolval($request->get('draft'));
        $article->setTranslation('title', $lang, $request->get('title'));
        $article->setTranslation('slug', $lang, Str::slug($request->get('title')));

        if (!$editing) {
            $article->content = '';
        }

        if ($request->file('illustration')) {
            $article
                ->addMediaFromRequest('illustration')
                ->toMediaCollection('banner');
        }

        $article->save();

        $previews = json_decode($request->get('content_preview'));
        if (!empty($previews)) {
            $content = $request->get('content');
            foreach ($previews as $i => $preview) {
                if (str_contains($request->get('content'), $preview)) {
                    $path = $article->addMedia($request->file('content_files')[$i])->toMediaCollection('illustrations');
                    $content = str_replace($preview, $path->getFullUrl(), $content);
                }
            }

            $article->setTranslation('content', $lang, $content);
        } else {
            $article->setTranslation('content', $lang, $request->get('content'));
        }

        $request_tags = json_decode($request->get('tags'));
        if (!empty($request_tags)) {
            $tags = [];
            foreach ($request_tags as $tag) {
                $new_tag = Tag::firstWhere('id', $tag->id);
                $tags[] = $new_tag;
            }

            $article->syncTags($tags);
        }

        $article->save();

    }
}
