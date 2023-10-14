<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded = false;

  public function tags()
  {
    return $this->hasMany(Tag::class);
  }

  public function newsTag()
  {
    return $this->hasMany(NewsTag::class);
  }

  public function getTagsString()
  {       
    $tagNames = $this->tags->pluck('name')->toArray();
    return implode(' ', $tagNames);
  }

  public function getTextWithoutTag()
  {    
    return preg_replace('/<a[^>]*>(.*?)<\/a>/i', '$1', $this->text); 
  }

  public function showTextWithTags()
  {
 // вибираємо теги які є в тексті
    $tags = Tag::select('tags.*')
    ->join('news_tags', 'tags.id', '=', 'news_tags.tag_id')
    ->where('news_tags.news_id', $this->id)
    ->pluck('tags.news_id', 'tags.name');

      if (count($tags)==0) 
         return $this->text;


     $text = $this->text;
      // Регулярний вираз для пошуку слів
      $pattern = '/\b(' . implode('|', array_map(function ($tag) {
          return preg_quote($tag, '/');
      }, $tags->keys()->toArray())) . ')\b/ui';

      // Замінюємо слова в тексті 
      $text = preg_replace_callback($pattern, function ($matches) use ($tags) {
          $tagName = $matches[0]; 
          $tagId = $tags[mb_strtolower($tagName, 'UTF-8')]; 
          if ($tagId!=$this->id)
            return '<a href="' . route('news.show', $tagId) . '">' . $tagName . '</a>'; 
          else
            return $tagName;
      }, $text);

      return  $text;
  }



}
