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
        //
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
        //dd($request->input('text') , $request->input('teg'));

        $text = $request->input('tag');
        $words = str_word_count($text, 1);
        
        // $words буде масивом, що містить окремі слова з тексту
        print_r($words);

       // $post = new Post();
      //  $post->title = 'Заголовок посту';
      //  $post->content = 'Текст посту';
        
        // Використання associate() для призначення батьківського об'єкта (категорії) до поста
        //$post->category()->associate($category);
       
      // $post->save();

        foreach ($words as $word) {
            Tag::create(['name' => $word]);
         //   $post->category()->associate($category);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
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
