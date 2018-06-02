<?php

namespace App\Taggy\Models;

use Illuminate\Database\Eloquent\Model;
use App\Taggy\Scopes\TagUsedScopesTrait;

class Tag extends Model
{
    use TagUsedScopesTrait;
}
