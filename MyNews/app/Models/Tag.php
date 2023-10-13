<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    //protected $guarded = false;

    protected $fillable = [
        'name',
    ];

    public function news()
    {
      return $this->belongsTo(News::class);
    }

    public function newsTag()
    {
      return $this->hasMany(NewsTag::class);
    }

}
