<?php

namespace App\Http\Livewire\Cms\PrivacyDetails;

use App\Models\PrivacyDetail;
use App\Models\PrivacyPolicy;
use Cms\Livewire\Concerns\ResolveCurrentAdmin;
use DateTime;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

abstract class PrivacyDetailForm extends Component
{
    use AuthorizesRequests;
    use ResolveCurrentAdmin;
    use WithMedia;

    /**
     * The related privacy detail instance.
     *
     * @var PrivacyDetail
     */
    public PrivacyDetail $privacyDetail;

    /**
     * @var array
     */
    public array $mediaComponentNames = [
        'detailImage',
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
    public $detailImage;

    /**
     * Stores a list of role options.
     *
     * @var string[]
     */
    public array $privacyOptions;

    /**
     * The Media Library Pro's Request instance URL.
     *
     * @var string|null
     */
    public string|null $detailImageUrl;

    /**
     * The related privacy policy instance.
     *
     * @var string
     */
    public string $privacyTitle;

    /**
     * Define the current operation of the livewire component.
     * The valid options for operation values are: create, view, update.
     *
     * @var string
     */
    protected string $operation;

    /**
     * The validation rules for privacy detail model.
     *
     * @var string[]
     */
    protected array $rules = [
        'privacyDetail.privacy_policy_id' => 'required|integer|between:0,18446744073709551615',
        'privacyDetail.published_at'      => 'required|date',
        'privacyDetail.order'             => 'required|integer|between:-2147483647,2147483647',
        'translations.title.en'           => 'required|string|min:2|max:255',
        'translations.title.id'           => 'required|string|min:2|max:255',
        'translations.content.en'         => 'required|string|min:2|max:65535',
        'translations.content.id'         => 'required|string|min:2|max:65535',
        'privacyTitle'                    => 'nullable|string|min:2|max:65535',
        'detailImage'                     => 'nullable|file_name',
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
            route('cms.privacy_details.index')
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
        $permission = 'cms.'.$this->privacyDetail->getTable().'.'.$this->operation;

        if (!$this->getCurrentAdminProperty()->can($permission)) {
            throw new AuthorizationException();
        }
    }

    /**
     * Redirect to the edit privacy detail page.
     *
     * @return mixed
     */
    public function edit()
    {
        return redirect()->to(
            route('cms.privacy_details.edit', ['privacyDetail' => $this->privacyDetail])
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
                'title' => 'Privacy Details',
                'url'   => route('cms.privacy_details.index'),
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
            'The new privacy detail has been saved.' :
            'The privacy detail has been updated.';
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

        $this->translations = $this->privacyDetail->getAllTranslatableValues();
        $this->privacyTitle = $this->privacyDetail->privacyPolicy ? $this->privacyDetail->privacyPolicy->title : '';
        $this->privacyOptions = PrivacyPolicy::joinTranslation()->get()->pluck('title', 'id')->toArray();

        $this->detailImage = $this->privacyDetail->getFirstMedia(PrivacyDetail::IMAGE_COLLECTION) ?? null;
        $this->detailImageUrl = $this->detailImage?->getUrl('large');

        if ($this->operation == 'update') {
            $date = $this->privacyDetail->published_at
                ? new DateTime((string) $this->privacyDetail->published_at)
                : null;
            $this->privacyDetail->published_at = $date ? $date->format('Y-m-d H:i') : '';
        }

        if ($this->operation == 'create') {
            $firstPrivacyOptions = array_key_first($this->privacyOptions);
            $this->privacyDetail->privacy_policy_id = $firstPrivacyOptions;
            $this->translations['content']['en'] = '';
            $this->translations['content']['id'] = '';
        }
    }

    /**
     * Save the privacy detail model.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \ErrorException
     *
     * @return mixed
     */
    public function save()
    {
        if (($this->operation !== 'create') && ($this->operation !== 'update')) {
            return redirect()->to(route('cms.privacy_details.index'));
        }

        $this->confirmAuthorization();
        $this->validate();

        $this->privacyDetail->fill($this->translations);
        $this->privacyDetail->save();

        if ($this->detailImage) {
            $this->privacyDetail->addFromMediaLibraryRequest($this->detailImage)->toMediaCollection(PrivacyDetail::IMAGE_COLLECTION);
            $this->clearMedia();
        }

        session()->flash('alertType', 'success');
        session()->flash('alertMessage', $this->getSuccessMessage());

        return redirect()->to(route('cms.privacy_details.index'));
    }

    /**
     * Delete existing thumbnail.
     */
    public function deleteImage(): void
    {
        $this->privacyDetail->clearMediaCollection(PrivacyPolicy::IMAGE_COLLECTION);
        $this->detailImageUrl = null;
    }
}
