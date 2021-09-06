<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;

class Staff extends User
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Staff::class;

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('is_staff', true);
    }
}
