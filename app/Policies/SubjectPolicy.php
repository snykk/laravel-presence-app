<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy extends AbstractPolicy
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
        return $this->can($user, new Subject(), 'viewAny');
    }

    /**
     * Determine whether the User can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Subject $subject
     *
     * @return bool
     */
    public function view(User $user, Subject $subject): bool
    {
        return $this->can($user, $subject, 'view');
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
        return $this->can($user, new Subject(), 'create');
    }

    /**
     * Determine whether the User can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Subject $subject
     *
     * @return bool
     */
    public function update(User $user, Subject $subject): bool
    {
        return $this->can($user, $subject, 'update');
    }

    /**
     * Determine whether the User can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Subject $subject
     *
     * @return bool
     */
    public function delete(User $user, Subject $subject): bool
    {
        return $this->can($user, $subject, 'delete');
    }

    /**
     * Determine whether the User can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Subject $subject
     *
     * @return bool
     */
    public function restore(User $user, Subject $subject): bool
    {
        return $this->can($user, $subject, 'restore');
    }

    /**
     * Determine whether the User can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Subject $subject
     *
     * @return bool
     */
    public function forceDelete(User $user, Subject $subject): bool
    {
        return $this->can($user, $subject, 'forceDelete');
    }
}
