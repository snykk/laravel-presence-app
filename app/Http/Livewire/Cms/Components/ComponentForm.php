<?php

namespace App\Http\Livewire\Cms\Components;

use App\Http\Livewire\Cms\Extensions\MediaTrait;
use App\Models\Component;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component as LivewireComponent;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use RichanFongdasen\I18n\I18nService;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

abstract class ComponentForm extends LivewireComponent
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;
    use MediaTrait;
    use WithMedia;
    use WithFileUploads;

    /**
     * Defines the component images.
     *
     * @var array
     */
    public array $componentImagesEn = [];

    /**
     * Defines the component images.
     *
     * @var array
     */
    public array $componentImagesId = [];

    /**
     * Add File Item.
     *
     * @param string $locale
     *
     * @return void
     */
    public function addFileItem($locale): void
    {
        array_push($this->{'componentImages'.$locale}, [
            'image' => null,
        ]);
    }

    /**
     * Remove File Item.
     *
     * @param string $locale
     * @param int    $index
     *
     * @return void
     */
    public function removeFileItem($locale, $index)
    {
        array_splice($this->{'componentImages'.$locale}, $index, 1);
    }

    /**
     * Share media.
     *
     * @var mixed
     */
    public $mediaEn;

    /**
     * Share media.
     *
     * @var mixed
     */
    public $mediaId;

    /**
     * The related component instance.
     *
     * @var Component
     */
    public Component $component;

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
        'attachments',
    ];

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
     * Defines the options of type value.
     *
     * @var array
     */
    public array $typeOptions = Component::TYPES;

    /**
     * The validation rules for component model.
     *
     * @return array
     */
    public array $rules = [
        'published'                   => 'required|in:true,false',
        'component.name'              => 'required|string|min:2|max:255',
        'component.order'             => 'nullable|integer|between:0,2147483647',
        'component.type'              => 'required|string|min:2|max:45',
        'component.slug'              => 'nullable|string|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255|unique:components,slug,NULL,id',
        'translations.title.en'       => 'required|string|min:2|max:500',
        'translations.title.id'       => 'required|string|min:2|max:500',
        'translations.description.en' => 'nullable|string|min:2|max:500',
        'translations.description.id' => 'nullable|string|min:2|max:500',
        'translations.content.en'     => 'nullable|string|min:2|max:65535',
        'translations.content.id'     => 'nullable|string|min:2|max:65535',
        'componentImagesEn'           => 'nullable|array',
        'componentImagesId'           => 'nullable|array',
    ];

    /**
     * The validation attributes for component model.
     *
     * @var string[]
     */
    protected array $validationAttributes = [
        'published'                   => 'Published',
        'component.name'              => 'Name',
        'component.slug'              => 'Slug',
        'component.order'             => 'Order',
        'component.type'              => 'Type',
        'translations.title.en'       => 'English Title',
        'translations.title.id'       => 'Bahasa Title',
        'translations.description.en' => 'English Description',
        'translations.description.id' => 'Bahasa Description',
        'translations.content.en'     => 'English Content',
        'translations.content.id'     => 'Bahasa Content',
        'componentImagesEn'           => 'English Images',
        'componentImagesId'           => 'Bahasa Images',
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
            route('cms.components.index')
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
        $permission = 'cms.'.$this->component->getTable().'.'.$this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit component page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.components.edit', ['componentId' => $this->component->id])
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
                'title' => 'Components',
                'url'   => route('cms.components.index'),
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
            'The new component has been saved.' :
            'The component has been updated.';
    }

    /**
     * Get Empty Locale Attribute.
     *
     * @return mixed
     */
    protected function getEmptyLocale()
    {
        $result = [];
        $locales = app(I18nService::class)->getLocaleKeys() ?? [];

        foreach ($locales as $locale) {
            $result[$locale] = null;
        }

        return $result;
    }

    /**
     * Handle the `mount` lifecycle event.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function mount(int $componentId = 0): void
    {
        $temp = Component::find($componentId);
        $this->component = ($componentId == 0 || $temp == null) ? new Component() : $temp;

        $this->confirmAuthorization();

        $type = $this->component->getAttribute('type') ?? 'default';
        $this->component->type = $type;

        //Get published value
        $this->published = $this->component->getAttribute('published') ? 'true' : 'false';
        if ($this->operation == 'view') {
            $this->published = $this->component->getAttribute('published_name');
        }

        $this->translations = $this->component->getAllTranslatableValues();
        $this->mediaEn = $this->component->getMedia(Component::IMAGE_COLLECTION.'-en') ?? null;
        $this->mediaId = $this->component->getMedia(Component::IMAGE_COLLECTION.'-id') ?? null;

        if ($this->operation == 'create') {
            $this->translations['title'] = $this->translations['title'] ?? $this->getEmptyLocale();
            $this->translations['description'] = $this->translations['description'] ?? $this->getEmptyLocale();
            $this->translations['content'] = $this->translations['content'] ?? $this->getEmptyLocale();
        }
    }

    /**
     * Provide the custom rules for the current livewire component.
     *
     * @return void
     */
    protected function customRules(): void
    {
        if (optional($this->component)->getKey()) {
            $this->rules['component.slug'] = str_replace(
                'NULL,id',
                $this->component->getKey().',id',
                $this->rules['component.slug']
            );
        }

        foreach (array_keys($this->componentImagesEn) as $key) {
            $this->rules['componentImagesEn.'.$key.'.image'] = 'nullable|string';
            if ($this->componentImagesEn[$key]['image'] instanceof TemporaryUploadedFile) {
                $this->rules['componentImagesEn.'.$key.'.image'] = 'nullable|mimes:jpg,jpeg,png|max:10000';
            }
        }

        foreach (array_keys($this->componentImagesId) as $key) {
            $this->rules['componentImagesId.'.$key.'.image'] = 'nullable|string';
            if ($this->componentImagesId[$key]['image'] instanceof TemporaryUploadedFile) {
                $this->rules['componentImagesId.'.$key.'.image'] = 'nullable|mimes:jpg,jpeg,png|max:10000';
            }
        }
    }

    /**
     * Save the component model.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     *
     * @return mixed
     */
    public function save()
    {
        $this->customRules();

        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.components.index'));
        }

        $this->confirmAuthorization();

        if (trim($this->component->slug) == '') {
            unset($this->component->slug);
        }

        if ($this->component->order == '') {
            $this->component->order = null;
        }

        $this->validate();

        $this->component->published = $this->published;
        $this->component->fill($this->translations);
        $this->component->save();

        foreach ($this->componentImagesEn as $file) {
            if ($file['image'] instanceof TemporaryUploadedFile) {
                $this->component->addMediaFromDisk('livewire-tmp/'.$file['image']->getFilename(), config('livewire.temporary_file_upload.disk'))
                    ->toMediaCollection(Component::IMAGE_COLLECTION.'-en');
            }
        }

        foreach ($this->componentImagesId as $file) {
            if ($file['image'] instanceof TemporaryUploadedFile) {
                $this->component->addMediaFromDisk('livewire-tmp/'.$file['image']->getFilename(), config('livewire.temporary_file_upload.disk'))
                    ->toMediaCollection(Component::IMAGE_COLLECTION.'-id');
            }
        }

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.components.index'));
    }
}
