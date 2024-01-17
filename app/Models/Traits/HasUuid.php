<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * @return void
     */
    public static function bootHasUuid(): void
    {
        static::creating(function (self $model): void {
            if (empty($model->{$model->uuidColumn()})) {
                $model->{$model->uuidColumn()} = $model->newUniqueId();
            }
        });
    }

    /**
     * @return string
     */
    public function uuidColumn(): string
    {
        return 'uuid';
    }

    /**
     * Generate a new UUID for the model.
     *
     * @return string
     */
    public function newUniqueId(): string
    {
        return (string) Str::orderedUuid();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return $this->uuidColumn();
    }
}
