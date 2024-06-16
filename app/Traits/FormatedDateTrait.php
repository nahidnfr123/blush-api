<?php

namespace App\Traits;

trait FormatedDateTrait
{
    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the created at date in a formatted way.
     *
     * @param string|null $value
     * @return string
     */
    public function getCreatedAtAttribute(string|null $value): string
    {
        return $value ? date('d M, Y', strtotime($value)) : '';
    }

    /**
     * Get the updated at date in a formatted way.
     *
     * @param string|null $value
     * @return string
     */
    public function getUpdatedAtAttribute(string|null $value): string
    {
        return $value ? date('d M, Y', strtotime($value)) : '';
    }

    /**
     * Get the deleted at date in a formatted way.
     *
     * @param string|null $value
     * @return string
     */
    public function getDeletedAtAttribute(string|null $value): string
    {
        return $value ? date('d M, Y', strtotime($value)) : '';
    }
}
