<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class CustomerUser extends User
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CustomerUser::class;

    public static $title = 'Users';

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query
            ->where('is_staff', false)
            ->where(function ($q) use ($request) {
                if ($request->viaRelationship() && $request->viaResource() === Customer::class) {
                    return $q->where('customer_id', $request->viaResourceId);
                } else {
                    return $q->whereNotNull('customer_id')->where('customer_id', $request->user()->customer_id);
                }
            });
    }

    public static function availableForNavigation(Request $request)
    {
        return !$request->user()->isStaff();
    }

    public static function label()
    {
        return 'Users';
    }
}
