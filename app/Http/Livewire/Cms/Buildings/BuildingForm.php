<?php

namespace App\Http\Livewire\Cms\Buildings;

use App\Models\Building;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

abstract class BuildingForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;

    /**
     * The related building instance.
     *
     * @var Building
     */
    public Building $building;

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * The validation rules for building model.
     *
     * @var string[]
     */
    protected array $rules = [
        'building.name' => 'required|string|min:2|max:60',
        'building.address' => 'required|string|min:2|max:255',
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
            route('cms.buildings.index')
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
        $permission = 'cms.' . $this->building->getTable() . '.' . $this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit building page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.buildings.edit', ['building' => $this->building])
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
                'title' => 'Buildings',
                'url' => route('cms.buildings.index'),
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
            'The new building has been saved.' :
            'The building has been updated.';
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
// translations initialization
    }

    /**
     * Save the building model.
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.buildings.index'));
        }

        $this->confirmAuthorization();
        $this->validate();

// assign translation values to current model
        $this->building->save();

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.buildings.index'));
    }
}
