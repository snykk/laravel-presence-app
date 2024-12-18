<?php

namespace App\Http\Livewire\Cms\SubjectSchedules;

use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SubjectSchedule;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

abstract class SubjectScheduleForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;

    /**
     * The related subject schedule instance.
     *
     * @var SubjectSchedule
     */
    public SubjectSchedule $subjectSchedule;

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * The validation rules for subject schedule model.
     *
     * @var string[]
     */
    protected array $rules = [
        'subjectSchedule.subject_id' => 'required|integer',
        'subjectSchedule.schedule_id' => 'required|integer',
        'subjectSchedule.class_index' => 'required',
    ];
// translations property

    /**
     * The subject value options.
     *
     * @var array|string[]
     */
    public array $subjectOptions = [];

    /**
     * The scheduel value options.
     *
     * @var array|string[]
     */
    public array $scheduleOptions = [];

    /**
     * The scheduel value options.
     *
     * @var array|string[]
     */
    public array $classIndexOptions = [];

    /**
     * Redirect and go back to index page.
     *
     * @return mixed
     */
    public function backToIndex()
    {
        return redirect()->to(
            route('cms.subject_schedules.index')
        );
    }

    /**
     * Confirm Admin authorization to access the datatable resources.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    protected function confirmAuthorization(): void
    {
        dd($this);
        $permission = 'cms.' . $this->subjectSchedule->getTable() . '.' . $this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit subject schedule page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.subject_schedules.edit', ['subjectSchedule' => $this->subjectSchedule])
        );
    }

    /**
     * Provide the breadcrumb items for the current livewire component.
     *
     * @return array[]
     */
    public function getBreadcrumbItemsProperty(): array
    {
        return [
            [
                'title' => 'Subject Schedules',
                'url' => route('cms.subject_schedules.index'),
            ]
        ];
    }

    /**
     * Get the success message after `save` action called successfully.
     *
     * @return string
     */
    protected function getSuccessMessage(): string
    {
        return ($this->operation === 'create') ?
            'The new subject schedule has been saved.' :
            'The subject schedule has been updated.';
    }

    /**
     * Handle the `mount` lifecycle event.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function mount(): void
    {
        $this->confirmAuthorization();

        $this->subjectOptions = Subject::all()->pluck('title','id')->toArray();
        $this->classIndexOptions = [
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
        ];

        if (!$this->subjectSchedule->subject_id) {
            $this->subjectSchedule->subject_id =array_keys($this->subjectOptions)[0];
            $this->subjectSchedule->class_index =array_keys($this->classIndexOptions)[0];
        }

        $scheduleList = [];

        foreach(Schedule::all() as $schedule) {
            $scheduleList[$schedule->id] = $schedule->start_time->format('H:i:s') . ' - ' . $schedule->end_time->format('H:i:s');
        }

        $this->scheduleOptions = $scheduleList;
    }

    /**
     * Save the subject schedule model.
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.subject_schedules.index'));
        }

        $this->confirmAuthorization();
        $this->validate();

// assign translation values to current model
        $this->subjectSchedule->save();

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.subject_schedules.index'));
    }
}
