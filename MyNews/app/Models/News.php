<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $fillable = [
      'name',
      'text',
      
  ];

  public function tags()
  {
    return $this->hasMany(Tag::class);
  }

}
