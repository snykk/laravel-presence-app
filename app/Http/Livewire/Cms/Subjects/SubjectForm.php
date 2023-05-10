<?php

namespace App\Http\Livewire\Cms\Subjects;

use App\Models\Subject;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

abstract class SubjectForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;

    /**
     * The related subject instance.
     *
     * @var Subject
     */
    public Subject $subject;

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * The validation rules for subject model.
     *
     * @var string[]
     */
    protected array $rules = [
        'subject.department_id' => 'required|integer|between:0,18446744073709551615',
        'subject.code' => 'required|string|min:2|max:8',
        'subject.score_credit' => 'required|integer|between:0,65535',
        'translations.title.en' => 'required|string|min:2|max:120',
        'translations.title.id' => 'required|string|min:2|max:120',
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
            route('cms.subjects.index')
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
        $permission = 'cms.' . $this->subject->getTable() . '.' . $this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit subject page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.subjects.edit', ['subject' => $this->subject])
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
                'title' => 'Subjects',
                'url' => route('cms.subjects.index'),
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
            'The new subject has been saved.' :
            'The subject has been updated.';
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
     * Save the subject model.
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.subjects.index'));
        }

        $this->confirmAuthorization();
        $this->validate();

// assign translation values to current model
        $this->subject->save();

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.subjects.index'));
    }
}
