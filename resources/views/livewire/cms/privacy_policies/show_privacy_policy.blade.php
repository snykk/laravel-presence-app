@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.privacy_policies.index') }}';
</script>
@include('components.privacy_scripts')
@endsection

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <livewire:cms.nav.breadcrumb :items="$this->breadcrumbItems" />

            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Privacy Policy Detail #{{ $privacyPolicy->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('slug', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('privacyPolicy.order', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::select('privacyPolicy.is_private', $privateOptions, ['disabled' => 'disabled'])->setTitle('Set Private') !!}
                        {!! CmsForm::date('publishedAt', ['disabled' => 'disabled'])->setTitle('Publish Schedule') !!}

                        <div>
                            <label for="preview">Current Image</label>
                            @if($policyImageUrl)
                                <div class="form-group">
                                    <img src="{{ $policyImageUrl }}" style="border: 1px solid #333;" />
                                </div>
                            @else
                                <p class="text-muted">No image available</p>
                            @endif
                        </div>

                        <div class="example-preview mb-7">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link active" data-toggle="tab" href="#-en-privacy_policies">English</a>
                                </li><li class="nav-item ">
                                    <a class="nav-link " data-toggle="tab" href="#-id-privacy_policies">Bahasa</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-5">
                                <div class="tab-pane fade p-2 active show" id="-en-privacy_policies" role="tabpanel">
                                    {!! CmsForm::text('translations.title.en', ['disabled' => 'disabled'])->setTitle("Title") !!}
                                    <x-input.tinymce_readonly labelName="English Description" wire:model="translations.description.en" />
                                </div>

                                <div class="tab-pane fade p-2 " id="-id-privacy_policies" role="tabpanel">
                                    {!! CmsForm::text('translations.title.id', ['disabled' => 'disabled'])->setTitle("Title") !!}
                                    <x-input.tinymce_readonly labelName="Indonesia Description" wire:model="translations.description.id" />
                                </div>
                            </div>
                        </div>
                        @include($seoMetaBlade, ['component' => $this])

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.privacy_policies.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Privacy Policy
                                </button>
                            @endif

                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
