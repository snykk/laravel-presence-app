@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.home_banners.index') }}';
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
                    <h3 class="card-title">Create New Home Banner</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('homeBanner.rank') !!}
                        <div class="example-preview mb-7">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link active" data-toggle="tab" href="#-en">English</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link " data-toggle="tab" href="#-id">Bahasa</a>
                                </li>
                            </ul>

                            <div class="tab-content pt-5">
                                <div class="tab-pane fade p-2 active show" id="-en" role="tabpanel">
                                    <div class="form-group">
                                        <label for="homeBannerDesktopEn">Desktop Home Banner</label>
                                        <x-media-library-attachment name="homeBannerDesktopEn"
                                          rules="{{ $mediaRules['image'] }}" />
                                        <div class="font-size-sm mt-2 text-info">It is recommended to upload an image
                                            with 2400x1200 resolution.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="homeBannerMobileEn">Mobile Home Banner</label>
                                        <x-media-library-attachment name="homeBannerMobileEn"
                                          rules="{{ $mediaRules['image'] }}" />
                                        <div class="font-size-sm mt-2 text-info">It is recommended to upload an image
                                            with 1200x1200 resolution.</div>
                                    </div>
                                    {!! CmsForm::text('translations.title.en') !!}
                                    {!! CmsForm::text('translations.url.en', ['required' => false])->setTitle('Banner
                                    URL (optional)') !!}
                                    {!! CmsForm::text('translations.description.en', ['required' =>
                                    false])->setTitle('Banner Description (optional)')
                                    !!}
                                    {!! CmsForm::text('translations.subdescription.en', ['required' =>
                                    false])->setTitle('Banner Sub
                                    Description (optional)') !!}
                                    {!! CmsForm::text('translations.cta_text.en', ['required' => false])->setTitle('CTA
                                    Text (optional)') !!}
                                    {!! CmsForm::text('translations.cta_url.en', ['required' => false])->setTitle('CTA
                                    URL (optional)') !!}
                                </div>
                                <div class="tab-pane fade p-2" id="-id" role="tabpanel">
                                    <div class="form-group">
                                        <label for="homeBannerDesktopId">Desktop Home Banner</label>
                                        <x-media-library-attachment name="homeBannerDesktopId"
                                          rules="{{ $mediaRules['image'] }}" />
                                        <div class="font-size-sm mt-2 text-info">It is recommended to upload an image
                                            with 2400x1200 resolution.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="homeBannerMobileId">Mobile Home Banner</label>
                                        <x-media-library-attachment name="homeBannerMobileId"
                                          rules="{{ $mediaRules['image'] }}" />
                                        <div class="font-size-sm mt-2 text-info">It is recommended to upload an image
                                            with 1200x1200 resolution.</div>
                                    </div>
                                    {!! CmsForm::text('translations.title.id') !!}
                                    {!! CmsForm::text('translations.url.id', ['required' => false])->setTitle('Banner
                                    URL (optional)') !!}
                                    {!! CmsForm::text('translations.description.id', ['required' =>
                                    false])->setTitle('Banner Description (optional)')
                                    !!}
                                    {!! CmsForm::text('translations.subdescription.id', ['required' =>
                                    false])->setTitle('Banner Sub
                                    Description (optional)') !!}
                                    {!! CmsForm::text('translations.cta_text.id', ['required' => false])->setTitle('CTA
                                    Text (optional)') !!}
                                    {!! CmsForm::text('translations.cta_url.id', ['required' => false])->setTitle('CTA
                                    URL (optional)') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Home Banner</button>
                            <button wire:click="backToIndex()" type="button"
                              class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>