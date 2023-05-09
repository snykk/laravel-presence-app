@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.promos.index') }}';
</script>
@include('components.promo_scripts')
@endsection

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <livewire:cms.nav.breadcrumb :items="$this->breadcrumbItems" />

            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Create New Promo</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        <div class="mb-16">
                            <div class="mb-8">
                                <h3>Banner</h3>
                            </div>
                            <div class="example-preview mb-7">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item active">
                                        <a class="nav-link active" data-toggle="tab" href="#-en-banner">English</a>
                                    </li><li class="nav-item ">
                                        <a class="nav-link " data-toggle="tab" href="#-id-banner">Bahasa</a>
                                    </li>
                                </ul>

                                <div class="tab-content pt-5">
                                    <div class="tab-pane fade p-2 active show" id="-en-banner" role="tabpanel">
                                        <div class="form-group">
                                            <label for="bannerImageEn">Banner</label>
                                            <x-media-library-attachment name="promoBannerEn" rules="{{ $mediaRules['image'] }}" />
                                            {!! \App\Models\Banner::renderResolutionInfo() !!}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade p-2" id="-id-banner" role="tabpanel">
                                        <div class="form-group">
                                            <label for="bannerImageId">Banner</label>
                                            <x-media-library-attachment name="promoBannerId" rules="{{ $mediaRules['image'] }}" />
                                            {!! \App\Models\Banner::renderResolutionInfo() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="{{ ($promoBannerEn && $promoBannerId) ? 'd-block' : 'd-none' }}">
                                {!! CmsForm::number('banner.rank')->setTitle('Banner\'s Rank') !!}
                                {!! CmsForm::select('isMainBanner', $isMainBannerOptions)->setTitle('Main Banner') !!}
                            </div>
                        </div>

                        <div class="mt-16 mb-16">
                            <div class="mb-8">
                                <h3>Promo</h3>
                            </div>

                            <div class="mb-6">
                                <label>Thumbnail</label>
                                <x-media-library-attachment name="promoThumbnail" rules="{{ $mediaRules['image'] }}" />
                                <div class="font-size-sm mt-2 text-info">It is recommended to upload an image with 290x163 resolution.</div>
                            </div>

                            {!! CmsForm::select('selectedLocations', $this->locationIds, ['class' => 'form-control input-select2', 'multiple' => 'multiple'])->setTitle("Select Locations") !!}
                            {!! CmsForm::select('selectedCategories', $this->categoryIds, ['class' => 'form-control input-select2', 'multiple' => 'multiple'])->setTitle("Select Categories") !!}
                            {!! CmsForm::select('promo.brand_id', $this->brandIds)->setTitle("Brand") !!}
                            {!! CmsForm::number('promo.rank')->setTitle("Promo's Rank") !!}
                            {!! CmsForm::text('promo.cta_url', ['required' => false])->setTitle("Call To Action URL (optional)") !!}
                            {!! CmsForm::select('promo.type', $promoTypeOptions)->setTitle("Promo Type") !!}
                            {!! CmsForm::text('promo.voucher_url', ['required' => false])->setTitle("Voucher URL (Optional)") !!}
                            {!! CmsForm::date('promo.start_date', ['required']) !!}
                            {!! CmsForm::date('promo.end_date', ['required']) !!}
                            {!! CmsForm::text('slug', ['required' => false]) !!}
                            <div class="font-size-sm mt-2 mb-6 text-info">If left empty, it will be generated based on title.</div>

                            <div class="example-preview mb-7">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item active">
                                        <a class="nav-link active" data-toggle="tab" href="#-en-promo">English</a>
                                    </li><li class="nav-item ">
                                        <a class="nav-link " data-toggle="tab" href="#-id-promo">Bahasa</a>
                                    </li>
                                </ul>
                                <div class="tab-content pt-5">
                                    <div class="tab-pane fade p-2 active show" id="-en-promo" role="tabpanel">
                                        {!! CmsForm::text('translations.headline.en', ['required'])->setTitle("Headline") !!}
                                        {!! CmsForm::text('translations.title.en', ['required'])->setTitle("Title") !!}
                                        {!! CmsForm::text('translations.cta_title.en', ['required' => false])->setTitle("Call to Action Title (optional)") !!}
                                    </div>

                                    <div class="tab-pane fade p-2 " id="-id-promo" role="tabpanel">
                                        {!! CmsForm::text('translations.headline.id', ['required'])->setTitle("Headline") !!}
                                        {!! CmsForm::text('translations.title.id', ['required'])->setTitle("Title") !!}
                                        {!! CmsForm::text('translations.cta_title.id', ['required' => false])->setTitle("Call to Action Title (optional)") !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <x-input.tinymce labelName="English Content" wire:model.defer="translations.terms.en" />
                        </div>
                        <div class="form-group">
                            <x-input.tinymce labelName="Bahasa Content" wire:model.defer="translations.terms.id" />
                        </div>

                        @include($seoMetaBlade, ['component' => $this])

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Promo</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let select2Callback = function () {
            const selects = $('.input-select2');
            selects.off('change');
            selects.on('change', function () {
                let data = $(this).select2("val");
                let name = $(this).attr('name');
                @this.set(name, data);
            });
        }

        document.addEventListener('livewire:load', function () {
            CmsApp.initSelect2(select2Callback)
        })

        window.addEventListener('LiveWireComponentRefreshed', function () {
            CmsApp.initSelect2(select2Callback)
        })
    </script>
</div>
