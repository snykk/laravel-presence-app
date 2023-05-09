<?php

namespace App\Http\Livewire\Cms\StaticPages;

use App\Models\StaticPage;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Cms\Livewire\Concerns\WithSeoMeta;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use RichanFongdasen\I18n\I18nService;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Str;

abstract class StaticPageForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;
    use WithMedia;
    use WithSeoMeta;

    /**
     * Define the main model name which implements
     * the SeoAttachedModel interface.
     *
     * @var string
     */
    protected string $mainModelName = 'staticPage';

    /**
     * Register the media component names.
     *
     * @var string[]
     */
    public array $mediaComponentNames = [
        'seoMediaEn',
        'seoMediaId',
    ];

    /**
     * Defines the options of layout value.
     *
     * @var string[]
     */
    public array $layoutOptions = [
        'default' => 'default',
    ];

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * The menu published instance.
     *
     * @var string
     */
    public string $published = '';

    /**
     * The menu private instance.
     *
     * @var string
     */
    public string $private = '';

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
     * The private value options.
     *
     * @var array|string[]
     */
    public array $privateOptions = [
        'false' => 'No',
        'true'  => 'Yes',
    ];

    /**
     * A property to store slug data.
     *
     * @var string
     */
    public string $slug;

    /**
     * The validation rules for static page model.
     *
     * @var string[]
     */
    protected array $rules = [
        'staticPage.layout'         => 'required|string|min:2|max:255',
        'staticPage.slug'           => 'nullable|string|min:2|max:255',
        'staticPage.is_private'     => 'required',
        'slug'                      => 'nullable|string|min:2|max:255',
        'published'                 => 'required|string|in:true,false',
        'seoMediaEn'                => 'file_name',
        'seoMediaId'                => 'file_name',
    ];

    /**
     * The validation attributes for static page model.
     *
     * @var string[]
     */
    protected array $validationAttributes = [
        'staticPage.layout'             => 'Layout',
        'staticPage.slug'               => 'Slug',
        'staticPage.is_private'         => 'Set Private',
        'slug'                          => 'Slug',
        'published'                     => 'Published',
        'translations.name.en'          => 'English Name',
        'translations.name.id'          => 'Bahasa Name',
        'translations.content.en'       => 'English Content',
        'translations.content.id'       => 'Bahasa Content',
        'translations.youtube_video.en' => 'English Youtube Video',
        'translations.youtube_video.id' => 'Bahasa Youtube Video',
    ];

    /**
     * The validation messages for static page model.
     *
     * @var string[]
     */
    protected array $messages = [
        'translations.slug.en.not_in' => 'The combination of English slug and auto generated Bahasa slug will result in not unique value!',
        'translations.slug.id.not_in' => 'The combination of Bahasa slug and auto generated English slug will result in not unique value!',
    ];

    /**
     * A property to store all of the translations data.
     *
     * @var array
     */
    public array $translations = [];

    /**
     * The related static page instance.
     *
     * @var StaticPage
     */
    public StaticPage $staticPage;

    /**
     * Redirect and go back to index page.
     *
     * @return mixed
     */
    public function backToIndex()
    {
        return redirect()->to(
            route('cms.static_pages.index')
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
        $permission = 'cms.'.$this->staticPage->getTable().'.'.$this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit static page page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.static_pages.edit', ['staticPageId' => $this->staticPage->id])
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
                'title' => 'Static Pages',
                'url'   => route('cms.static_pages.index'),
            ],
        ];
    }

    /**
     * Get computed SEO content meta data.
     *
     * @param StaticPage $staticPage
     * @param string     $locale
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getSeoContent(StaticPage $staticPage, string $locale): string
    {
        return strip_tags((string) $staticPage->getAttribute('content'));
    }

    /**
     * Get computed SEO url meta data.
     *
     * @param StaticPage $staticPage
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getSeoUrl(StaticPage $staticPage): string
    {
        return '/'.$staticPage->getAttribute('slug');
    }

    /**
     * Get the success message after `save` action called successfully.
     *
     * @return string
     */
    protected function getSuccessMessage(): string
    {
        return ($this->operation === 'create') ?
            'The new static page has been saved.' :
            'The static page has been updated.';
    }

    /**
     * Provide the custom rules for the current livewire component.
     *
     * @return void
     */
    protected function customRules(): void
    {
        $locales = app(I18nService::class)->getLocaleKeys() ?? [];

        foreach ($locales as $locale) {
            $this->rules['translations.name.'.$locale] = 'required|string|min:2|max:255';
            $this->rules['translations.content.'.$locale] = 'required|string|min:2|max:16777215';
            $this->rules['translations.youtube_video.'.$locale] = 'nullable|string|min:2|max:255';
            $this->rules['seoMeta.seo_title.'.$locale] = 'required|string|min:2|max:60';
            $this->rules['seoMeta.seo_description.'.$locale] = 'required|string|min:2|max:150';
            $this->rules['seoMeta.open_graph_type.'.$locale] = 'required|in:article,website';
        }

        if (optional($this->staticPage)->getKey()) {
            $enId = $this->staticPage->getAllTranslatableValues()['id']['en'];
            $this->rules['translations.slug.en'] = str_replace(
                'NULL,id',
                $enId.',id',
                $this->rules['translations.slug.en']
            );
        }

        if (optional($this->staticPage)->getKey()) {
            $bahasaId = $this->staticPage->getAllTranslatableValues()['id']['id'];
            $this->rules['translations.slug.id'] = str_replace(
                'NULL,id',
                $bahasaId.',id',
                $this->rules['translations.slug.id']
            );
        }
    }

    /**
     * Handle non unique slug input.
     *
     * @return void
     */
    protected function handleNonUniqueSlug(): void
    {
        if (
            Str::slug($this->translations['name']['en']) == $this->translations['slug']['id']
            && trim($this->translations['slug']['en']) == ''
        ) {
            $this->rules['translations.slug.id'] = str_replace(
                'string|',
                'string|not_in:'.Str::slug($this->translations['name']['en']).'|',
                $this->rules['translations.slug.id']
            );
        }

        if (
            Str::slug($this->translations['name']['id']) == $this->translations['slug']['en']
            && trim($this->translations['slug']['id']) == ''
        ) {
            $this->rules['translations.slug.en'] = str_replace(
                'string|',
                'string|not_in:'.Str::slug($this->translations['name']['id']).'|',
                $this->rules['translations.slug.en']
            );
        }
    }

    /**
     * Get empty locale.
     *
     * @return array
     */
    protected function getEmptyLocale(): array
    {
        return [
            'en' => '',
            'id' => '',
        ];
    }

    /**
     * Handle the `mount` lifecycle event.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function mount(int $staticPageId = 0): void
    {
        $temp = StaticPage::find($staticPageId);
        $this->staticPage = ($staticPageId == 0 || $temp == null) ? new StaticPage() : $temp;

        $this->confirmAuthorization();

        if ($this->staticPage->getAttribute('layout') === null) {
            $this->staticPage->setAttribute('layout', 'default');
        }

        //Get published value
        $this->published = $this->staticPage->getAttribute('published') ? 'true' : 'false';

        $translationsData = $this->staticPage->getAllTranslatableValues();
        unset($this->translations['slug']);
        $this->translations['name'] = $translationsData['name'] ?? $this->getEmptyLocale();
        $this->translations['content'] = $translationsData['content'] ?? $this->getEmptyLocale();
        $this->translations['youtube_video'] = $translationsData['youtube_video'] ?? $this->getEmptyLocale();

        $this->setDefaultValues();
    }

    /**
     * Set default values.
     *
     * @throws \ErrorException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Livewire\Exceptions\PropertyNotFoundException
     *
     * @return void
     */
    private function setDefaultValues(): void
    {
        if ($this->operation == 'view') {
            $this->published = $this->staticPage->getAttribute('published_name');
            $this->private = $this->staticPage->is_private ? 'Yes' : 'No';
        }

        if ($this->operation == 'update' || $this->operation == 'view') {
            $this->slug = $this->staticPage->slug ?? '';
            $this->private = $this->staticPage->is_private ? 'true' : 'false';
        }

        if ($this->operation == 'create') {
            $this->slug = '';
            $this->staticPage->is_private = false;
            $this->private = 'false';
        }
    }

    /**
     * Save the static page model.
     *
     * @throws \ErrorException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Livewire\Exceptions\PropertyNotFoundException
     *
     * @return mixed
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.static_pages.index'));
        }

        $this->confirmAuthorization();

        //Prevent trailing white spaces input in slug
        $this->staticPage->slug = Str::slug($this->slug);
        $this->staticPage->is_private = $this->private == 'true' ? true : false;

        $this->validate();

        $this->staticPage->fill($this->translations);
        $this->staticPage->published = $this->published;

        $this->staticPage->save();
        $this->saveSeoMeta();

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.static_pages.index'));
    }
}
