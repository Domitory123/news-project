<?php

namespace App\Services;

use App\Models\User;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use App\Jobs\MyJob;

class NewsService
{   
    
   static public function deleteTag(News $n){
        $tags = $n->tags;
        $News = News::get();
 
        foreach ($News as $news) {
           
            foreach ($tags as $tag) {
               $news->text = preg_replace('/<a[^>]*>'.preg_quote($tag->name, '/').'<\/a>/i', $tag->name, $news->text);
               $news->save();
            } 
        }
        $n->tags()->delete();
    }

    static  public function addTag(News $news){

         $tags = Tag::pluck('news_id', 'name');
         $text = $news->text;
 
         // Регулярний вираз для пошуку слів
         $pattern = '/\b(' . implode('|', array_map(function ($tag) {
             return preg_quote($tag, '/');
         }, $tags->keys()->toArray())) . ')\b/ui';
 
         // Замінюємо відповідні слова в тексті на посилання з ідентифікаторами
         $text = preg_replace_callback($pattern, function ($matches) use ($tags) {
             $tagName = $matches[0]; // Отримуємо слово з відповідності
             $tagId = $tags[$tagName]; // Отримуємо ідентифікатор для слова
             return '<a href="' . route('news.show', $tagId) . '">' . $tagName . '</a>';
         }, $text);
 
         $news->text=$text;
         $news->save();
         
         return $news;
     }

 /**
     * проходимось по новому тексті і добавляємо всі теги 
     * 
     */
    static public function addTagsforNewtext($news){

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
  static  public function addTagsforAlltext($tagIdsToRetrieve)
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
     * Store a newly created resource in storage.
     */
    static public function store(NewsRequest $request)
    {
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

        
        MyJob::dispatch($tags);//addTagsforAlltext();//добавляємо нові теги в існуючі статті

       // NewsService::addTagsforAlltext($tags);//добавляємо нові теги в існуючі статті
        NewsService::addTagsforNewtext($news);//

        return $news;
        //$news = $this->addTag($news);
        // return redirect()->route('news.show', ['news' => $news]);

    }

 /**
     * Update the specified resource in storage.
     */
    static public function update(Request $request, News $news)
    {
       
        $data = $request->all();
        $originalNews = News::find($news->id);

        //якщо  редагований тег
        if ($originalNews->getTagsString() != $data['tag']){
        
            NewsService::deleteTag($originalNews);//видаляємо старі теги
            
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

             MyJob::dispatch($tags);//addTagsforAlltext();//добавляємо нові теги в існуючі статті
            // NewsService::addTagsforAlltext($tags);
        }

        //якщо редаговано текст
        if ($originalNews->getTextWithoutTag() != $data['text']){ 

            $originalNews->text=$data['text'];
            $originalNews->save();
            NewsService::addTagsforNewtext($originalNews);
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

      return $originalNews;
    }


}