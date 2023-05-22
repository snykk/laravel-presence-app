<?php

namespace App\Http\Livewire\Cms\Classrooms;

use App\Models\Building;
use App\Models\Classroom;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

abstract class ClassroomForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;

    /**
     * The related classroom instance.
     *
     * @var Classroom
     */
    public Classroom $classroom;

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * The building value options.
     *
     * @var array|string[]
     */
    public array $buildingOptions = [];

    /**
     * The validation rules for classroom model.
     *
     * @var string[]
     */
    protected array $rules = [
        'classroom.building_id' => 'required|integer|between:0,18446744073709551615',
        'classroom.room_number' => 'required|string|min:1|max:1',
        'classroom.capacity' => 'required|integer|between:0,65535',
        'classroom.floor' => 'required|integer|between:0,65535',
        'classroom.status' => 'required|string|min:2|max:30',
    ];
// translations property

    /**
     * Redirect and go back to index page.
     *
     * @return mixed
     */
    public function backToIndex()
    {
        return redirect()->to(
            route('cms.classrooms.index')
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
        $permission = 'cms.' . $this->classroom->getTable() . '.' . $this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit classroom page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.classrooms.edit', ['classroom' => $this->classroom])
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
                'title' => 'Classrooms',
                'url' => route('cms.classrooms.index'),
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
            'The new classroom has been saved.' :
            'The classroom has been updated.';
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

        $this->buildingOptions += Building::all()->pluck('name', 'id')->toArray();

        if (!$this->classroom->building_id) {
            $this->classroom->building_id = array_keys($this->buildingOptions)[0];
        }
    }

    /**
     * Save the classroom model.
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.classrooms.index'));
        }

        $this->confirmAuthorization();
        $this->validate();

// assign translation values to current model
        $this->classroom->save();

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.classrooms.index'));
    }
}
