<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DomParser;
use Symfony\Component\DomCrawler\Crawler;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
       //перевірити на існування 

//  $html = 'хороша <a href="http://127.0.0.1:8000/show/1">погода</a> сьогодні <a href="http://127.0.0.1:8000/show/1">добре</a>';

//         $crawler = new Crawler($html);
//         // Отримати всі теги <a>
//         $linkTags = $crawler->filter('a');
//         // Пройтися по всіх тегах <a> та замінити їх текстом
//         $linkTags->each(function (Crawler $node) {
//             $node->getNode(0)->parentNode->replaceChild(new \DOMText($node->text()), $node->getNode(0));
//         });
//         //Отримати остаточний текст
//         $cleanText = $crawler->text();
            
       $News = News::get();
     
        foreach ($News as $news) {
           
            $news->text = preg_replace('/<a[^>]*>'.$tag->name.'<\/a>/', $tag->name, $news->text);
            $news->save();
        }
       $tag->delete();

    }
}
