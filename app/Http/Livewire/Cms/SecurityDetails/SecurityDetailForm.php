<?php

namespace App\Http\Livewire\Cms\SecurityDetails;

use App\Models\SecurityDetail;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

abstract class SecurityDetailForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;
    use WithMedia;

    /**
     * The related security detail instance.
     *
     * @var SecurityDetail
     */
    public SecurityDetail $securityDetail;

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * The validation rules for component.
     *
     * @var array
     */
    public array $mediaRules = [
        'image' => 'mimes:png,jpeg,jpg|max:10240',
    ];

    /**
     * Register the media component names.
     *
     * @var string[]
     */
    public array $mediaComponentNames = [
        'securityImageEn',
        'securityImageId',
    ];

    /**
     * The Media Library Pro's Request instance.
     *
     * @var mixed
     */
    public $securityImageEn;

    /**
     * The Media Library Pro's Request instance.
     *
     * @var mixed
     */
    public $securityImageId;

    /**
     * The menu published instance.
     *
     * @var string
     */
    public string $published = '';

    /**
     * Defines the options of published value.
     *
     * @var array
     */
    public array $publishedOptions = [
        'true'  => 'Yes',
        'false' => 'No',
    ];

    /**
     * The validation rules for security detail model.
     *
     * @var string[]
     */
    protected array $rules = [
        'published'                   => 'required|in:true,false',
        'securityDetail.order'        => 'required|integer|between:0,4294967295',
        'translations.title.en'       => 'required|string|min:2|max:255',
        'translations.title.id'       => 'required|string|min:2|max:255',
        'translations.description.en' => 'required|string|min:2|max:65535',
        'translations.description.id' => 'required|string|min:2|max:65535',
        'securityImageEn'             => 'file_name',
        'securityImageId'             => 'file_name',
    ];

    /**
     * The validation attributes for security detail model.
     *
     * @var string[]
     */
    protected array $validationAttributes = [
        'published'                   => 'Published',
        'securityDetail.order'        => 'Order',
        'translations.title.en'       => 'English Title',
        'translations.title.id'       => 'Bahasa Title',
        'translations.description.en' => 'English Description',
        'translations.description.id' => 'Bahasa Description',
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
            route('cms.security_details.index')
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
        $permission = 'cms.'.$this->securityDetail->getTable().'.'.$this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit security detail page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.security_details.edit', ['securityDetail' => $this->securityDetail])
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
                'title' => 'Security Details',
                'url'   => route('cms.security_details.index'),
            ],
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
            'The new security detail has been saved.' :
            'The security detail has been updated.';
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

        //Get published value
        $this->published = $this->securityDetail->getAttribute('published') ? 'true' : 'false';
        if ($this->operation == 'view') {
            $this->published = $this->securityDetail->getAttribute('published_name');
        }

        $this->securityImageEn = $this->securityDetail->getFirstMedia(SecurityDetail::IMAGE_COLLECTION.'-en') ?? null;
        $this->securityImageId = $this->securityDetail->getFirstMedia(SecurityDetail::IMAGE_COLLECTION.'-id') ?? null;

        $this->translations = $this->securityDetail->getAllTranslatableValues();
    }

    /**
     * Save the security detail model.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     *
     * @return mixed
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.security_details.index'));
        }

        $this->confirmAuthorization();

        $this->validate();

        $this->securityDetail->fill($this->translations);
        $this->securityDetail->published = $this->published;
        $this->securityDetail->save();

        $this->securityDetail->addFromMediaLibraryRequest($this->securityImageEn)
            ->toMediaCollection(SecurityDetail::IMAGE_COLLECTION.'-en');

        $this->securityDetail->addFromMediaLibraryRequest($this->securityImageId)
            ->toMediaCollection(SecurityDetail::IMAGE_COLLECTION.'-id');

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.security_details.index'));
    }
}
