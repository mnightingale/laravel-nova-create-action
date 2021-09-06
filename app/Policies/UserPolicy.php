<?php

namespace App\Policies;

use App\Models\User;
use App\Nova\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return \Nova::whenServing(function (NovaRequest $request) use ($user) {
                \Log::info($request->url(), [
                    'resource'                  => $request->route('resource'),
                    'isCreateOrAttachRequest()' => $request->isCreateOrAttachRequest(),
                    'viaRelationship()'         => $request->viaRelationship(),
                    'viaResource()'             => $request->viaResource(),
                ]);

                if ($request->viaRelationship() && $request->viaResource() === Customer::class) {
                    return true;
                }

                return !$user->is_staff && $request->route('resource') === 'users';
            }) ?? (function () {
                // Initial load of /resources/users is not a NovaRequest but clicking the button causes 403 because that is a NovaRequest.
                return true;

//                // This doesn't work properly, caused the button to appear/disappear inconsistently on login, refresh and navigation
//                if (Str::startsWith(Route::current()->parameter('view'), 'resources/customers')) {
//                    return true;
//                }
//
//                return false;
            })();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        return true;
    }
}
