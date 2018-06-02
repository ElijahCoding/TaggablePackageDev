<?php

namespace App\Taggy;

trait TaggableTrait
{
  public function tags()
  {
    return $this->morphToMany(Tag::class, 'taggable');
  }
}
