<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Organisation extends Model
{
    use NodeTrait;

    protected $fillable = ['org_name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Organisation::class, 'parent_id')->with('parent');
    }

    public function daughters()
    {
        return $this->hasMany(Organisation::class, 'parent_id')->with('daughters');
    }

    public function sisters()
    {
        return $this->hasMany(Organisation::class, 'parent_id', 'parent_id');
    }

}
