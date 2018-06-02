<?php

namespace App\Taggy\Scopes;

trait TaggableScopesTrait
{
  public function scopeWithAnyTag($query, array $tags)
  {
    return $query->hasTags($tags);
  }

  public function scopeWithAnyTags($query, array $tags)
  {
    foreach ($tags as $tag) {
      $query->hasTags([$tag]);
    }

    return $query;
  }

  public function scopeHasTags($query, array $tags)
  {
    return $query->whereHas('tags', function ($q) use ($tags) {
      return $query->whereIn('slug', $tags);
    });
  }
}
