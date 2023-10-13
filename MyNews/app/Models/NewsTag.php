<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTag extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function tag()
    {
      return $this->belongsTo(Tag::class);
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    

}
