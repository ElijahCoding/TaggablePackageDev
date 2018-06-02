<?php

namespace App\Taggy;

use App\Taggy\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait TaggableTrait
{
  public function tags()
  {
    return $this->morphToMany(Tag::class, 'taggable');
  }

  public function tag($tags)
  {
    $this->addTags($this->getWorkableTags($tags));
  }

  public function untag($tags = null)
  {
    if ($tags === null) {
      $this->removeAllTags();
      return;
    }

    $this->removeTags($this->getWorkableTags($tags));
  }

  private function removeAllTags()
  {
    $ths->removeTags($this->tags);
  }

  private function removeTags(Collection $tags)
  {
    $this->tags()->detach($tags);

    foreach ($tags->where('count', '>', 0) as $tag) {
      $tag->decrement('count');
    }
  }

  private function addTags(Collection $tags)
  {
    $sync = $this->tags()->syncWithoutDetach($tags->pluck('id')->toArray());

    foreach (array_get($sync, 'attached') as $attachedId) {
      $tags->where('id', $attachedId)->first()->increment('count');
    }
  }

  private function getWorkableTags($tags)
  {
    if (is_array($tags)) {
      return $this->getTagModels($tags);
    }

    if ($tags instanceof Model) {
      return $this->getTagModels([$tags->slug]);
    }

    return $tags;
  }

  private function filterTagsCollection(Collection $tags)
  {
    return $tags->filter(function ($tag) {
      return $tag instanceof Model;
    });
  }

  private function getTagModels(array $tags)
  {
    return Tag::whereIn('slug', $this->normaliseTagNames($tags))->get();
  }

  private function normaliseTagNames(array $tags)
  {
    return array_map(function ($tag) {
      return str_slug($tag);
    }, $tags);
  }
}
