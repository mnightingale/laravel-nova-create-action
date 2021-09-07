<?php

namespace App\Nova;

use Illuminate\Http\Request;
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

    public static function availableForNavigation(Request $request)
    {
        return true;
    }

    public static function label()
    {
        return 'Staff';
    }
}
