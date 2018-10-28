<?php

namespace Jeffersonmartin\Buildhat\Common;

use Exception;

//abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
abstract class BaseRepository
{
    public $counters = [];
    public $has = [];
    public $relationships = [];
}
