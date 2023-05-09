<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy extends AbstractPolicy
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
        return $this->can($user, new Department(), 'viewAny');
    }

    /**
     * Determine whether the User can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Department $department
     *
     * @return bool
     */
    public function view(User $user, Department $department): bool
    {
        return $this->can($user, $department, 'view');
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
        return $this->can($user, new Department(), 'create');
    }

    /**
     * Determine whether the User can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Department $department
     *
     * @return bool
     */
    public function update(User $user, Department $department): bool
    {
        return $this->can($user, $department, 'update');
    }

    /**
     * Determine whether the User can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Department $department
     *
     * @return bool
     */
    public function delete(User $user, Department $department): bool
    {
        return $this->can($user, $department, 'delete');
    }

    /**
     * Determine whether the User can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Department $department
     *
     * @return bool
     */
    public function restore(User $user, Department $department): bool
    {
        return $this->can($user, $department, 'restore');
    }

    /**
     * Determine whether the User can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Department $department
     *
     * @return bool
     */
    public function forceDelete(User $user, Department $department): bool
    {
        return $this->can($user, $department, 'forceDelete');
    }
}
