<?php

namespace App\Policies;

use App\Models\Component;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComponentPolicy extends AbstractPolicy
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
        return $this->can($user, new Component(), 'viewAny');
    }

    /**
     * Determine whether the User can view the model.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\Component $component
     *
     * @return bool
     */
    public function view(User $user, Component $component): bool
    {
        return $this->can($user, $component, 'view');
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
        return $this->can($user, new Component(), 'create');
    }

    /**
     * Determine whether the User can update the model.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\Component $component
     *
     * @return bool
     */
    public function update(User $user, Component $component): bool
    {
        return $this->can($user, $component, 'update');
    }

    /**
     * Determine whether the User can delete the model.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\Component $component
     *
     * @return bool
     */
    public function delete(User $user, Component $component): bool
    {
        return $this->can($user, $component, 'delete');
    }

    /**
     * Determine whether the User can restore the model.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\Component $component
     *
     * @return bool
     */
    public function restore(User $user, Component $component): bool
    {
        return $this->can($user, $component, 'restore');
    }

    /**
     * Determine whether the User can permanently delete the model.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\Component $component
     *
     * @return bool
     */
    public function forceDelete(User $user, Component $component): bool
    {
        return $this->can($user, $component, 'forceDelete');
    }
}
