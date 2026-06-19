<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\Article;
use App\Models\HomeContent;
use App\Models\HomeFeatureCard;
use App\Models\PortfolioItem;
use App\Models\SiteSetting;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'homeContent' => HomeContent::cached(),
            'featureCards' => HomeFeatureCard::query()
                ->active()
                ->ordered()
                ->get()
                ->filter(fn (HomeFeatureCard $card) => $card->hasT('title')),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'aboutPage' => AboutPage::cached(),
        ]);
    }

    public function portfolio(): View
    {
        return view('pages.portfolio', [
            'portfolioItems' => PortfolioItem::query()
                ->active()
                ->ordered()
                ->with('media')
                ->get()
                ->filter(fn (PortfolioItem $item) => $item->hasT('title')),
        ]);
    }

    public function articles(): View
    {
        return view('pages.articles', [
            'articles' => Article::query()
                ->published()
                ->ordered()
                ->with('media')
                ->get()
                ->filter(fn (Article $article) => $article->hasT('title')),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'siteSettings' => SiteSetting::cached(),
        ]);
    }
}
