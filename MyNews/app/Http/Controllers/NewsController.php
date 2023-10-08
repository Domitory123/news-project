<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use App\Jobs\MyJob;
use App\Http\Requests\NewsRequest;

class NewsController extends Controller
{

    public function deleteTag(News $n){

        $tags = $n->tags;
        $News = News::get();
 
        foreach ($News as $news) {
           
            foreach ($tags as $tag) {
               $news->text = preg_replace('/<a[^>]*>'.preg_quote($tag->name, '/').'<\/a>/i', $tag->name, $news->text);
               $news->save();
            } 
        }
       $tag->delete();
    }

    public function addTag(News $news){

       // Queue::push(new MyJob());  // Встановлення Laravel Queues:
        $tags = Tag::pluck('news_id', 'name');
        $text = $news->text;

        // Регулярний вираз для пошуку українських слів
        $pattern = '/\b(' . implode('|', array_map(function ($tag) {
            return preg_quote($tag, '/');
        }, $tags->keys()->toArray())) . ')\b/ui';

        // Замінюємо відповідні слова в тексті на посилання з ідентифікаторами
        $text = preg_replace_callback($pattern, function ($matches) use ($tags) {
            $tagName = $matches[0]; // Отримуємо слово з відповідності
            $tagId = $tags[$tagName]; // Отримуємо ідентифікатор для слова
            return '<a href="' . route('news.show', $tagId) . '">' . $tagName . '</a>'; // Побудова URL з ідентифікатором
        }, $text);

        $news->text=$text;
        $news->save();
        
        return $news;
    }

   /**
     * проходимось по новому тексті і добавляємо всі теги 
     * 
     */
    public function addTagsforNewtext($news){

        $tags = Tag::pluck('news_id', 'name');
        $text = $news->text;

        // Регулярний вираз для пошуку українських слів
        $pattern = '/\b(' . implode('|', array_map(function ($tag) {
            return preg_quote($tag, '/');
        }, $tags->keys()->toArray())) . ')\b/ui';

        // Замінюємо відповідні слова в тексті на посилання з ідентифікаторами
        $text = preg_replace_callback($pattern, function ($matches) use ($tags,$news) {
            $tagName = $matches[0]; // Отримуємо слово з відповідності
            $tagId = $tags[mb_strtolower($tagName, 'UTF-8')]; // Отримуємо ідентифікатор для слова
            if ($tagId!=$news->id)
              return '<a href="' . route('news.show', $tagId) . '">' . $tagName . '</a>'; // Побудова URL з ідентифікатором
            else
              return $tagName;
        }, $text);


        $news->text=$text;
        $news->save();
    }

    /**
     * проходимось по всіх текстах і добавляємо нові теги
     * 
     */
    public function addTagsforAlltext($tagIdsToRetrieve)
    {
        $tags = Tag::whereIn('id', $tagIdsToRetrieve)->pluck('news_id','name');
     
        //Регулярний вираз для пошуку українських слів
        $pattern = '/\b(' . implode('|', array_map(function ($tag) {
           return preg_quote($tag, '/');
                }, $tags->keys()->toArray())) . ')\b/ui';

        $news = News::get();
        foreach ($news as $n) {
            $text = $n->text;
                // Замінюємо відповідні слова в тексті на посилання з ідентифікаторами
                $text = preg_replace_callback($pattern, function ($matches) use ($tags,$n) {
                    $tagName = $matches[0]; // Отримуємо слово з відповідності
                    $tagId = $tags[mb_strtolower($tagName, 'UTF-8')]; // Отримуємо ідентифікатор для слова
                    if ($tagId!=$n->id)
                    return '<a href="' . route('news.show', $tagId) . '">' . $tagName . '</a>'; // Побудова URL з ідентифікатором
                    else
                     return $tagName;
                }, $text);
        
            $n->text=$text;
            $n->save();
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$News = News::get();
        $News = News::orderBy('created_at', 'desc')->paginate(1);
        return view('index' ,compact('News'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
 
        $request->validated();

        $text = $request->input('tag');
        $pattern = '/\p{L}+/u'; //
        preg_match_all($pattern, $text, $matches);
        $words = $matches[0];

        $words = array_map(function ($word) {
            return mb_strtolower($word, 'UTF-8');
        }, $words);

 
      //збереження фото
        $photoName = $request->file('file')->store('uploads', 'public');
      
        $news = new News();
        $news->text = $request->input('text');
        $news->name = $request->input('name');
        $news->photo="/storage/".$photoName;
        $news->save();

        $tags=[];
        foreach ($words as $word) {
           $tag = new Tag();
           $tag->name = $word;
           $tag->news()->associate($news);
           $tag->save();
           $tags[]=$tag->id;
        }

        $this->addTagsforAlltext($tags);
        $this->addTagsforNewtext($news);

        //$news = $this->addTag($news);
        return redirect()->route('news.show', ['news' => $news]);

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
        return view('edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //$data = $request->validated();
        $data = $request->all();
        $originalNews = News::find($news->id);

        //якщо  редагований тег
        if ($originalNews->getTagsString() != $data['tag']){
        
            $this->deleteTag($originalNews);//видаляємо старі теги

             $text = $data['tag'];
             $pattern = '/\p{L}+/u'; //

             preg_match_all($pattern, $text, $matches);
             $words = $matches[0];
    
             $words = array_map(function ($word) {
                 return mb_strtolower($word, 'UTF-8');
             }, $words);

             $tags=[];
             foreach ($words as $word) {
                $tag = new Tag();
                $tag->name = $word;
                $tag->news()->associate($originalNews);
                $tag->save();
                $tags[]=$tag->id;
             }

             $this->addTagsforAlltext($tags);
        }

        //якщо редаговано текст
        if ($originalNews->getTextWithoutTag() != $data['text']){ 

            $originalNews->text=$data['text'];
            $originalNews->save();
            $this->addTagsforNewtext($originalNews);
        }

        //коли міняємо картинку 
        if ($request->file('file')!=null) {
            unlink(public_path($originalNews->photo));
            $photoName = $request->file('file')->store('uploads', 'public');
            $originalNews->photo="/storage/".$photoName;
            $originalNews->save();
        }
         
       
        if($originalNews->name != $data['name'])
        {
            $originalNews->name=$data['name'];
            $originalNews->save();
        }

        return redirect()->route('news.show', ['news' => $originalNews]);
    }

    public function showDestroy(News $news)
    {
        return view('destroy', compact('news'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
       $this->deleteTag($news);
       $news->delete();

       return redirect()->route('news.destroyInfo');
    }
    public function destroyInfo()
    {
        return view('destroyInfo');
    }


}
