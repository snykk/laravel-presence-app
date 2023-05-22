<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Building;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuildingPolicy extends AbstractPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the User can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $this->can($user, new Building(), 'viewAny');
    }

    /**
     * Determine whether the User can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     *
     * @return bool
     */
    public function view(User $user, Building $building): bool
    {
        return $this->can($user, $building, 'view');
    }

    /**
     * Determine whether the User can create models.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $this->can($user, new Building(), 'create');
    }

    /**
     * Determine whether the User can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     *
     * @return bool
     */
    public function update(User $user, Building $building): bool
    {
        return $this->can($user, $building, 'update');
    }

    /**
     * Determine whether the User can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     *
     * @return bool
     */
    public function delete(User $user, Building $building): bool
    {
        return $this->can($user, $building, 'delete');
    }

    /**
     * Determine whether the User can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     *
     * @return bool
     */
    public function restore(User $user, Building $building): bool
    {
        return $this->can($user, $building, 'restore');
    }

    /**
     * Determine whether the User can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     *
     * @return bool
     */
    public function forceDelete(User $user, Building $building): bool
    {
        return $this->can($user, $building, 'forceDelete');
    }
}
