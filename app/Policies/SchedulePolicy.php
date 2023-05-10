<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy extends AbstractPolicy
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
        return $this->can($user, new Schedule(), 'viewAny');
    }

    /**
     * Determine whether the User can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Schedule $schedule
     *
     * @return bool
     */
    public function view(User $user, Schedule $schedule): bool
    {
        return $this->can($user, $schedule, 'view');
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
        return $this->can($user, new Schedule(), 'create');
    }

    /**
     * Determine whether the User can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Schedule $schedule
     *
     * @return bool
     */
    public function update(User $user, Schedule $schedule): bool
    {
        return $this->can($user, $schedule, 'update');
    }

    /**
     * Determine whether the User can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Schedule $schedule
     *
     * @return bool
     */
    public function delete(User $user, Schedule $schedule): bool
    {
        return $this->can($user, $schedule, 'delete');
    }

    /**
     * Determine whether the User can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Schedule $schedule
     *
     * @return bool
     */
    public function restore(User $user, Schedule $schedule): bool
    {
        return $this->can($user, $schedule, 'restore');
    }

    /**
     * Determine whether the User can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Schedule $schedule
     *
     * @return bool
     */
    public function forceDelete(User $user, Schedule $schedule): bool
    {
        return $this->can($user, $schedule, 'forceDelete');
    }
}
