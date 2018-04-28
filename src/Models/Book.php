<?php

namespace Bishopm\Bookclub\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Book extends Model implements TaggableInterface
{
    use TaggableTrait;

    protected $guarded = array('id');

    public function author()
    {
        return $this->belongsTo('Bishopm\Bookclub\Models\Author');
    }

    public function loans()
    {
        return $this->hasMany('Bishopm\Bookclub\Models\Loan');
    }
}
