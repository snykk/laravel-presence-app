@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.banners.index') }}';
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
                    <h3 class="card-title">Edit Banner #{{ $banner->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('banner.rank') !!}
                        {!! CmsForm::select('isMainBanner', $isMainBannerOptions)->setTitle('Main Banner') !!}
                        @if ($banner->promo_id)
                            {!! CmsForm::number('banner.promo_id', ['disabled' => 'disabled']) !!}
                        @endif

                        <div class="example-preview mb-7">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link active" data-toggle="tab" href="#-en">English</a>
                                </li><li class="nav-item ">
                                    <a class="nav-link " data-toggle="tab" href="#-id">Bahasa</a>
                                </li>
                            </ul>

                            <div class="tab-content pt-5">
                                <div class="tab-pane fade p-2 active show" id="-en" role="tabpanel">
                                    <div class="form-group">
                                        <label for="bannerImageEn">Banner</label>
                                        <x-media-library-attachment name="bannerImageEn" rules="{{ $mediaRules['image'] }}" />
                                        {!! \App\Models\Banner::renderResolutionInfo() !!}
                                    </div>
                                    <x-image_preview title="Current Promo Banner" :imageUrl="$bannerImageUrlEn"/>
                                    {!! CmsForm::text('translations.standalone_url.en', ['required' => false])->setTitle('Standalone CTA URL  (optional)') !!}
                                </div>
                                <div class="tab-pane fade p-2" id="-id" role="tabpanel">
                                    <div class="form-group">
                                        <label for="bannerImageId">Banner</label>
                                        <x-media-library-attachment name="bannerImageId" rules="{{ $mediaRules['image'] }}" />
                                        {!! \App\Models\Banner::renderResolutionInfo() !!}
                                    </div>
                                    <x-image_preview title="Current Promo Banner" :imageUrl="$bannerImageUrlId"/>
                                    {!! CmsForm::text('translations.standalone_url.id', ['required' => false])->setTitle('Standalone CTA URL  (optional)') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update Banner</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
