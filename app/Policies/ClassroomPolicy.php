<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomPolicy extends AbstractPolicy
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
        return $this->can($user, new Classroom(), 'viewAny');
    }

    /**
     * Determine whether the User can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Classroom $classroom
     *
     * @return bool
     */
    public function view(User $user, Classroom $classroom): bool
    {
        return $this->can($user, $classroom, 'view');
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
        return $this->can($user, new Classroom(), 'create');
    }

    /**
     * Determine whether the User can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Classroom $classroom
     *
     * @return bool
     */
    public function update(User $user, Classroom $classroom): bool
    {
        return $this->can($user, $classroom, 'update');
    }

    /**
     * Determine whether the User can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Classroom $classroom
     *
     * @return bool
     */
    public function delete(User $user, Classroom $classroom): bool
    {
        return $this->can($user, $classroom, 'delete');
    }

    /**
     * Determine whether the User can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Classroom $classroom
     *
     * @return bool
     */
    public function restore(User $user, Classroom $classroom): bool
    {
        return $this->can($user, $classroom, 'restore');
    }

    /**
     * Determine whether the User can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Classroom $classroom
     *
     * @return bool
     */
    public function forceDelete(User $user, Classroom $classroom): bool
    {
        return $this->can($user, $classroom, 'forceDelete');
    }
}
