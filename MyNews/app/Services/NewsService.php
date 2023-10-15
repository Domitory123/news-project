<?php

namespace App\Services; 

use App\Models\User;
use App\Models\News;
use App\Models\Tag;
use App\Models\NewsTag;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use App\Jobs\MyJob;

class NewsService
{   
    
   static public function delete(News $news){

    unlink(public_path($news->photo));
    $news->delete();
   
    }

 /**
     * проходимось по новому тексті і добавляємо всі теги 
     * 
     */
    static public function addTagsforNewtext($news){

        $tags = Tag::where('news_id','!=',$news->id)->pluck('id', 'name');
       
        // Регулярний вираз для пошуку слів
        $pattern = '/\b(' . implode('|', array_map(function ($tag) {
            return preg_quote($tag, '/');
        }, $tags->keys()->toArray())) . ')\b/ui';
 
       preg_replace_callback($pattern, function ($matches) use ($tags,$news) {

            $tagName = $matches[0]; 
            try { 
                $tagId = $tags[mb_strtolower($tagName, 'UTF-8')];
                $newsTag = new  NewsTag();
                $newsTag->news_id = $news->id;
                $newsTag->tag_id = $tagId;
                $newsTag->save();
            } catch (\Exception $e) {
              echo $tagName;
            }
           
        }, $news->text);

     
    }

/**
     * проходимось по всіх текстах і добавляємо нові теги
     * 
     */
    static  public function addTagsforAlltext($tagId ,News $n)
    {

      $tags = Tag::whereIn('id', $tagId)->get();
      $News = News::whereNotIn('id', [$n->id])->get();
     
        foreach ($News as $news) {
           
            foreach ($tags as $tag) {
               
                if (stripos(mb_strtolower($news->text, 'UTF-8'), $tag->name) !== false) {
  
                    $newsTag = new NewsTag();
                    $newsTag->news_id=$news->id;
                    $newsTag->tag_id=$tag->id;
                    $newsTag->save();
                }
            }
        }
   
    }

    static  public function storeTag($text, News $news){

        $pattern = '/[^\p{L}\d]+/u'; 
        $words = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);
        
        $words = array_map(function ($word) {
            return mb_strtolower($word, 'UTF-8');
        }, $words);

        $uniqueWords = array_unique($words);

        $tags=[];
        foreach ($uniqueWords as $word) {
           $tag = new Tag();
           $tag->name = $word;
           $tag->news()->associate($news);
           $tag->save();
           $tags[]=$tag->id;
        }

        return $tags;
    }

 /**
     * Store a newly created resource in storage.
     */
    static public function store(NewsRequest $request)
    {
      //збереження фото
        $photoName = $request->file('file')->store('uploads', 'public');

        $news = new News();
        $news->text = $request->input('text');
        $news->name = $request->input('name');
        $news->active = $request->input('active') === 'on' ? 1 : 0;
        $news->photo="/storage/".$photoName;
        $news->save();

        $tags = NewsService::storeTag($request->input('tag'),$news);
       
        NewsService::addTagsforNewtext($news);//добавляємо теги в нову новину
        NewsService::addTagsforAlltext($tags,$news);//добавляємо нові теги в існуючі статті

       // MyJob::dispatch($tags);//addTagsforAlltext();//добавляємо нові теги в існуючі статті
       
        return $news;
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
        
            $originalNews->tags()->delete();
            $tags = NewsService::storeTag($request->input('tag'),$news);
            NewsService::addTagsforAlltext($tags,$news);
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

        $originalNews->active = $request->input('active') === 'on' ? 1 : 0;
        $originalNews->save();
        
      return $originalNews;
    }

 /**
     * проходимось по новому тексті і добавляємо всі теги (для фабрики)
     * 
     */
    static public function addTagsforNewtextforFactory($news){

    }
}
