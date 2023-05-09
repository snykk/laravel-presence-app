@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.promos.index') }}';
</script>
@endsection

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <livewire:cms.nav.breadcrumb :items="$this->breadcrumbItems" />

            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Promo Detail #{{ $promo->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
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
                                        <x-image_preview title="Current Banner" :imageUrl="$promoBannerUrlEn"/>
                                    </div>
                                    <div class="tab-pane fade p-2" id="-id-banner" role="tabpanel">
                                        <x-image_preview title="Current Banner" :imageUrl="$promoBannerUrlId"/>
                                    </div>
                                </div>
                            </div>
                            @if($promoBannerUrlEn && $promoBannerUrlId)
                                {!! CmsForm::number('banner.rank', ['disabled' => 'disabled'])->setTitle('Banner\'s Rank') !!}
                                {!! CmsForm::text('isMainBanner', ['disabled' => 'disabled'])->setTitle('Main Banner') !!}
                            @endif
                        </div>

                        <div class="mt-16 mb-16">
                            <div class="mb-8">
                                <h3>Promo</h3>
                            </div>

                            <div class="mb-6">
                                <x-image_preview title="Thumbnail" :imageUrl="$promoThumbnailUrl"/>
                            </div>

                            {!! CmsForm::select('selectedLocations', $locationIds, ['class' => 'form-control input-select2', 'multiple' => 'multiple', 'disabled' => 'disabled'])->setTitle("Selected Locations") !!}
                            {!! CmsForm::select('selectedCategories', $categoryIds, ['class' => 'form-control input-select2', 'multiple' => 'multiple', 'disabled' => 'disabled'])->setTitle("Selected Categories") !!}
                            {!! CmsForm::text('brandName', ['disabled' => 'disabled'])->setTitle('Brand\'s name') !!}
                            {!! CmsForm::number('promo.rank', ['disabled' => 'disabled'])->setTitle("Promo's Rank") !!}
                            {!! CmsForm::text('promo.cta_url', ['disabled' => 'disabled'])->setTitle("Call To Action URL (optional)") !!}
                            {!! CmsForm::select('promo.type', $promoTypeOptions, ['disabled' => 'disabled'])->setTitle("Promo Type") !!}
                            {!! CmsForm::text('promo.voucher_url', ['disabled' => 'disabled'])->setTitle("Voucher URL (Optional)") !!}
                            {!! CmsForm::text('date.start', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('date.end', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('slug', ['disabled' => 'disabled']) !!}

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
                                        {!! CmsForm::text('translations.headline.en', ['disabled' => 'disabled']) !!}
                                        {!! CmsForm::text('translations.title.en', ['disabled' => 'disabled']) !!}
                                        {!! CmsForm::text('translations.cta_title.en', ['disabled' => 'disabled'])->setTitle('Call to Action Title (optional)') !!}
                                        {!! CmsForm::text('translations.slug.en', ['disabled' => 'disabled']) !!}
                                        {!! CmsForm::textarea('translations.terms.en', ['disabled' => 'disabled']) !!}
                                    </div>

                                    <div class="tab-pane fade p-2 " id="-id-promo" role="tabpanel">
                                        {!! CmsForm::text('translations.headline.id', ['disabled' => 'disabled']) !!}
                                        {!! CmsForm::text('translations.title.id', ['disabled' => 'disabled']) !!}
                                        {!! CmsForm::text('translations.cta_title.id', ['disabled' => 'disabled'])->setTitle('Call to Action Title (optional)') !!}
                                        {!! CmsForm::text('translations.slug.id', ['disabled' => 'disabled']) !!}
                                        {!! CmsForm::textarea('translations.terms.id', ['disabled' => 'disabled']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include($seoMetaBlade, ['component' => $this])

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.promos.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Promo
                                </button>
                            @endif

                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary">Back</button>
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
                @this.set('selectedLocations', data);
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
