<?php

namespace App\Http\Livewire\Cms\Departments;

use App\Models\Department;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

abstract class DepartmentForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;

    /**
     * The related department instance.
     *
     * @var Department
     */
    public Department $department;

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * The validation rules for department model.
     *
     * @var string[]
     */
    protected array $rules = [
        'department.code' => 'required|string|min:2|max:8',
        'translations.name.en' => 'required|string|min:2|max:50',
        'translations.name.id' => 'required|string|min:2|max:50',
        'translations.description.en' => 'required|string|min:2|max:65535',
        'translations.description.id' => 'required|string|min:2|max:65535',
    ];

    /**
     * A property to store all of the translations data.
     *
     * @var array
     */
    public array $translations = [];

    /**
     * Redirect and go back to index page.
     *
     * @return mixed
     */
    public function backToIndex()
    {
        return redirect()->to(
            route('cms.departments.index')
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
        $permission = 'cms.' . $this->department->getTable() . '.' . $this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit department page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.departments.edit', ['department' => $this->department])
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
                'title' => 'Departments',
                'url' => route('cms.departments.index'),
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
            'The new department has been saved.' :
            'The department has been updated.';
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

        $this->translations = $this->department->getAllTranslatableValues();
    }

    /**
     * Save the department model.
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.departments.index'));
        }

        $this->confirmAuthorization();
        $this->validate();

        // assign translation values to current model
        $this->department->fill($this->translations);
        $this->department->save();

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.departments.index'));
    }
}
