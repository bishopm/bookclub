<?php

namespace Bishopm\Bookclub\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Action extends Model implements TaggableInterface
{
    use TaggableTrait;

    protected $guarded = array('id');

    public function project()
    {
        return $this->belongsTo('Bishopm\Bookclub\Models\Project');
    }

    public function individual()
    {
        return $this->belongsTo('Bishopm\Bookclub\Models\Individual');
    }

    public function user()
    {
        return $this->belongsTo('Bishopm\Bookclub\Models\User');
    }

    public function folder()
    {
        return $this->belongsTo('Bishopm\Bookclub\Models\Folder');
    }
}
