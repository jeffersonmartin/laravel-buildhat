<?php

namespace Jeffersonmartin\Buildhat\Common;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class BaseModel extends EloquentModel
{

    use SoftDeletes;

    // Mutate the following fields to timestamp format
    protected $dates = ['deleted_at'];

    // Hide these fields from arrays
    protected $hidden = [];

    // Append these fields to arrays
    protected $appends = ['short_uuid'];

    // Run whenever a new model is instantiated
    protected static function boot()
    {
        parent::boot();

        // Attach to the 'creating' Model Event to provide a UUID
        // for the `uuid` field
        static::creating(function ($model) {
            $model->uuid = (string)$model->generateNewId();
        });

        if (auth()->guest()) {
            return;
        }

        if(! method_exists(static::class, 'getHasSoftDeletesDates')) {
            return;
        }

    }

    // Get a new version 4 (random) UUID.
    public function generateNewId()
    {
        return Uuid::uuid4();
    }

    public function getShortUuidAttribute()
    {
        return substr($this->uuid, -6);
    }

}
