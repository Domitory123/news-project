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

  public function getTagsString()
  {       
    $tagNames = $this->tags->pluck('name')->toArray();
    return implode(' ', $tagNames);
  }
  public function getTextWithoutTag()
  {    
    return preg_replace('/<a[^>]*>(.*?)<\/a>/i', '$1', $this->text); 
  }


}
