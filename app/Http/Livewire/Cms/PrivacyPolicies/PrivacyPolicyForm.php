<?php

namespace App\Http\Livewire\Cms\PrivacyPolicies;

use App\Models\PrivacyPolicy;
use Carbon\Carbon;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use Cms\Livewire\Concerns\WithSeoMeta;
use DateTime;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Str;

abstract class PrivacyPolicyForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;
    use WithSeoMeta;
    use WithMedia;

    /**
     * The related privacy policy instance.
     *
     * @var PrivacyPolicy
     */
    public PrivacyPolicy $privacyPolicy;

    /**
     * Define the main model name which implements
     * the SeoAttachedModel interface.
     *
     * @var string
     */
    protected string $mainModelName = 'privacyPolicy';

    /**
     * @var array
     */
    public array $mediaComponentNames = [
        'policyImage',
        'seoMediaEn',
        'seoMediaId',
    ];

    /**
     * The validation rules for component.
     *
     * @var array
     */
    public array $mediaRules = [
        'image' => 'required|mimes:png,jpeg|max:2048',
    ];

    /**
     * The Media Library Pro's Request instance.
     *
     * @var mixed
     */
    public $policyImage;

    /**
     * The Media Library Pro's Request instance URL.
     *
     * @var string|null
     */
    public string|null $policyImageUrl;

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * A property to store all of the translations data.
     *
     * @var array
     */
    public array $translations = [];

    /**
     * A property to store all of the contents data.
     *
     * @var string
     */
    public string $publishedAt;

    /**
     * Determine if user want to publish now.
     *
     * @var bool
     */
    public bool $setPublishNow = false;

    /**
     * Determine if user want to unpublish.
     *
     * @var bool
     */
    public bool $setUnpublish = false;

    /**
     * A property to store slug data.
     *
     * @var string
     */
    public string $slug;

    /**
     * The private value options.
     *
     * @var array|string[]
     */
    public array $privateOptions = [
        0 => 'No',
        1 => 'Yes',
    ];

    /**
     * The validation rules for privacy policy model.
     *
     * @var string[]
     */
    protected array $rules = [
        'privacyPolicy.slug'            => 'nullable|string|different:privacy_policies.id|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255',
        'slug'                          => 'nullable|string|different:privacy_policies.id|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|min:2|max:255',
        'privacyPolicy.order'           => 'required|integer|between:0,4294967295',
        'publishedAt'                   => 'nullable|date',
        'privacyPolicy.published_at'    => 'nullable|date',

        'translations.title.en'         => 'required|string|min:2|max:255',
        'translations.description.en'   => 'required|string|min:2|max:65535',

        'translations.title.id'         => 'required|string|min:2|max:255',
        'translations.description.id'   => 'required|string|min:2|max:65535',

        'policyImage'                   => 'nullable|file_name',
        'privacyPolicy.is_private'      => 'required',

        'seoMeta.seo_title.en'       => 'required|string|min:2|max:60',
        'seoMeta.seo_title.id'       => 'required|string|min:2|max:60',
        'seoMeta.seo_description.en' => 'required|string|min:2|max:150',
        'seoMeta.seo_description.id' => 'required|string|min:2|max:150',
        'seoMeta.open_graph_type.en' => 'required|in:article,website,promo,privacyPolicy',
        'seoMeta.open_graph_type.id' => 'required|in:article,website,promo,privacyPolicy',

        'seoMediaEn'         => 'file_name',
        'seoMediaId'         => 'file_name',
    ];

    /**
     * Action for publish now and unpublish,.
     *
     * @return void
     */
    protected function publishAction(): void
    {
        if ($this->setPublishNow) {
            $this->privacyPolicy->published_at = Carbon::now();
            $this->rules['privacyPolicy.published_at'] = str_replace(
                $this->rules['privacyPolicy.published_at'],
                'nullable|date',
                $this->rules['privacyPolicy.published_at']
            );
            $this->setPublishNow = false;
        }

        if ($this->setUnpublish) {
            $this->privacyPolicy->published_at = null;
            $this->setUnpublish = false;
        }
    }

    /**
     * Publish privacy policy now.
     *
     * @return void
     */
    public function publishNow(): void
    {
        $this->setPublishNow = true;
        $this->setUnpublish = false;
        $this->save();
    }

    /**
     * Redirect and go back to index page.
     *
     * @return mixed
     */
    public function backToIndex()
    {
        return redirect()->to(
            route('cms.privacy_policies.index')
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
        $permission = 'cms.'.$this->privacyPolicy->getTable().'.'.$this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit privacy policy page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.privacy_policies.edit', ['privacyPolicyId' => $this->privacyPolicy->id])
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
                'title' => 'Privacy Policies',
                'url'   => route('cms.privacy_policies.index'),
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
            'The new privacy policy has been saved.' :
            'The privacy policy has been updated.';
    }

    /**
     * Handle the `mount` lifecycle event.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     */
    public function mount(int $privacyPolicyId = 0): void
    {
        $temp = PrivacyPolicy::find($privacyPolicyId);
        $this->privacyPolicy = ($privacyPolicyId == 0 || $temp == null) ? new PrivacyPolicy() : $temp;

        $this->confirmAuthorization();

        $this->policyImage = $this->privacyPolicy->getFirstMedia(PrivacyPolicy::IMAGE_COLLECTION) ?? null;
        $this->policyImageUrl = $this->policyImage?->getUrl('large');
        $this->translations = $this->privacyPolicy->getAllTranslatableValues();

        if ($this->operation == 'update' || $this->operation == 'view') {
            $date = $this->privacyPolicy->published_at
                ? new DateTime((string) $this->privacyPolicy->published_at)
                : null;
            $this->publishedAt = $date ? $date->format('Y-m-d') : '';
            $this->slug = $this->privacyPolicy->slug ?? '';
        }

        if ($this->operation == 'create') {
            $this->slug = '';
            $this->privacyPolicy->slug = '';
            $this->publishedAt = '';
            $this->privacyPolicy->published_at = '';
            $this->translations['description']['en'] = '';
            $this->translations['description']['id'] = '';
            $this->privacyPolicy->is_private = false;
        }
    }

    /**
     * Save the privacy policy model.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     *
     * @return mixed
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.privacy_policies.index'));
        }

        $this->confirmAuthorization();

        if ($this->privacyPolicy->is_private == null) {
            $this->privacyPolicy->is_private = false;
        }

        $this->privacyPolicy->published_at = $this->publishedAt == '' ? null : $this->publishedAt;
        $this->publishAction();

        $this->privacyPolicy->slug = Str::slug($this->slug);

        $this->validate();

        $this->privacyPolicy->fill($this->translations);

        $this->privacyPolicy->save();
        $this->saveSeoMeta();

        if ($this->policyImage) {
            $this->privacyPolicy->addFromMediaLibraryRequest($this->policyImage)->toMediaCollection(PrivacyPolicy::IMAGE_COLLECTION);
            $this->clearMedia();
        }

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.privacy_policies.index'));
    }

    /**
     * Delete existing thumbnail.
     */
    public function deleteImage(): void
    {
        $this->privacyPolicy->clearMediaCollection(PrivacyPolicy::IMAGE_COLLECTION);
        $this->policyImageUrl = null;
    }

    /**
     * Get computed SEO content meta data.
     *
     * @param PrivacyPolicy $privacy
     * @param string        $locale
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getSeoContent(PrivacyPolicy $privacy, string $locale): string
    {
        return strip_tags((string) $privacy->getAttribute('content'));
    }

    /**
     * Get computed SEO url meta data.
     *
     * @param PrivacyPolicy $privacy
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getSeoUrl(PrivacyPolicy $privacy): string
    {
        return '/'.$privacy->getAttribute('slug');
    }
}
