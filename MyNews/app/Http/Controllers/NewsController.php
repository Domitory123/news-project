<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use App\Jobs\MyJob;


class NewsController extends Controller
{

    public function test(News $news){

        Queue::push(new MyJob());

       // Встановлення Laravel Queues:

$tags = Tag::pluck('news_id', 'name'); // Отримуємо ідентифікатори тегів, де ключ - це ім'я тегу

$text = $news->text;

// Регулярний вираз для пошуку українських слів
$pattern = '/\b(' . implode('|', array_map(function ($tag) {
    return preg_quote($tag, '/');
}, $tags->keys()->toArray())) . ')\b/ui';

// Замінюємо відповідні слова в тексті на посилання з ідентифікаторами
$text = preg_replace_callback($pattern, function ($matches) use ($tags) {
    $tagName = $matches[0]; // Отримуємо слово з відповідності
    $tagId = $tags[$tagName]; // Отримуємо ідентифікатор для слова
    return '<a href="' . route('show', $tagId) . '">' . $tagName . '</a>'; // Побудова URL з ідентифікатором
}, $text);







        $news->text=$text;
        $news->save();
         //echo $text;
          // dd($news->text);

         return $news;
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
        //$words = str_word_count($text, 1, 'UTF-8');
        $text = $request->input('tag');
        $pattern = '/\p{L}+/u'; // Регулярний вираз для слова з будь-якою буквою в будь-якому алфавіті
        preg_match_all($pattern, $text, $matches);
        $words = $matches[0];
      
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

        $news = $this->test($news);

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
