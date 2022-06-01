<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

trait UUIDTrait
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            //if (! $model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            //}
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}