<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SubjectSchedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectSchedulePolicy extends AbstractPolicy
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
        return $this->can($user, new SubjectSchedule(), 'viewAny');
    }

    /**
     * Determine whether the User can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @return bool
     */
    public function view(User $user, SubjectSchedule $subjectSchedule): bool
    {
        return $this->can($user, $subjectSchedule, 'view');
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
        return $this->can($user, new SubjectSchedule(), 'create');
    }

    /**
     * Determine whether the User can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @return bool
     */
    public function update(User $user, SubjectSchedule $subjectSchedule): bool
    {
        return $this->can($user, $subjectSchedule, 'update');
    }

    /**
     * Determine whether the User can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @return bool
     */
    public function delete(User $user, SubjectSchedule $subjectSchedule): bool
    {
        return $this->can($user, $subjectSchedule, 'delete');
    }

    /**
     * Determine whether the User can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @return bool
     */
    public function restore(User $user, SubjectSchedule $subjectSchedule): bool
    {
        return $this->can($user, $subjectSchedule, 'restore');
    }

    /**
     * Determine whether the User can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SubjectSchedule $subjectSchedule
     *
     * @return bool
     */
    public function forceDelete(User $user, SubjectSchedule $subjectSchedule): bool
    {
        return $this->can($user, $subjectSchedule, 'forceDelete');
    }
}
