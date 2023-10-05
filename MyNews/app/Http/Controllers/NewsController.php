<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function test(){

        $text = "Це ваш текст слово1 з деякими слово2 словами, які потрібно зробити посиланнями.";
        $wordsToLink = ["слово1", "слово2", "слово3"]; // Додайте слова, які потрібно зробити посиланнями
        
        foreach ($wordsToLink as $word) {
            $text = str_replace($word, "<a href='#'>$word</a>", $text);
        }
        
         echo $text;
        }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //view('profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $text = $request->input('tag');
        $words = str_word_count($text, 1);
    
        $news = new News();
        $news->text = $request->input('text');
        $news->name = "name";
        $news->photo='photo';
         $news->save();

        foreach ($words as $word) {
           $tag = new Tag();
           $tag->name = $word;
           $tag->news()->associate($news);
           $tag->save();
        }

        return view('show', compact('news'));
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
       return view('show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
