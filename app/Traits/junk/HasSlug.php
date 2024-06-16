<?php

namespace App\Traits\junk;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected string $slugField = 'name';

    protected function getSlugColumnName(): string
    {
        return 'name';
    }

    public static function bootHasSlug()
    {
        static::creating(function (Model $model) {
            $model->generateSlugOnCreate();
        });

        static::updating(function (Model $model) {
            $model->generateSlugOnUpdate();
        });
    }

    public function initializeHasSlug(): void
    {
        static::saving(function (Model $model) {
            $slug = $model?->slug ?? null;
            if ($slug) {
                $model->slug = self::generateSlugFromSlug($slug, $model);
            } else {
                $model->slug = self::generateSlug($model->{self::getSlugColumnName()});
            }
        });
    }

    public static function generateSlug($value): string
    {
        if (empty($value)) {
            return '';
        }
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $count = static::where('slug', 'like', $value . '%')->count();
            return $slug . '-' . $count;
        }

        return $slug;
    }

    public static function generateSlugFromSlug($slug, $model = null)
    {
        $count = static::where('slug', 'like', $slug . '%')->where('id', '!=', $model->id)->count();
        $originalSlug = $slug;
        if ($count > 0) {
            $slug = $originalSlug . '-' . $count;
        }
        return $slug;
    }

    /**
     * Find a model by its primary key or slug.
     *
     * @param mixed $value
     * @param null $field
     * @return Model|Collection|HasSlug
     */
    public function resolveRouteBinding($value, $field = null): Model|Collection|static
    {
        return $this->where('id', $value)->orWhere('slug', $value)->firstOrFail();
//        if (is_numeric($value)) {
//            return $this->findOrFail($value);
//        }

//        return $this->where('slug', $value)->firstOrFail();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
