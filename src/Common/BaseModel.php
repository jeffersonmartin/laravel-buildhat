<?php

namespace Jeffersonmartin\Buildhat\Common;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BaseModel extends EloquentModel
{

    use SoftDeletes;

    // Disable auto incrementing ID since we use UUID
    public $incrementing = false;

    // Since primary key is not an integer, set to a string
    protected $keyType = string;

    // Mutate the following fields to timestamp format
    protected $dates = ['deleted_at'];

    // Hide these fields from arrays
    protected $hidden = [];

    // Append these fields to arrays
    protected $appends = ['short_id'];

    // Run whenever a new model is instantiated
    protected static function boot()
    {
        parent::boot();

        // Attach to the 'creating' Model Event to provide a UUID
        // for the `uuid` field
        static::creating(function ($model) {
            $model->id = (string)Str::uuid();
        });

        if (auth()->guest()) {
            return;
        }

        if(! method_exists(static::class, 'getHasSoftDeletesDates')) {
            return;
        }

    }

    //
    // Attributes
    //

    public function getShortIdAttribute()
    {
        return substr($this->id, -6);
    }

}
