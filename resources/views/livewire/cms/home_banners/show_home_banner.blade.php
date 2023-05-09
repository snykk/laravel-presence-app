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
                    <h3 class="card-title">Home Banner Detail #{{ $homeBanner->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('homeBanner.rank', ['disabled' => 'disabled']) !!}
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
                                    <x-image_preview title="Current Desktop Home Banner"
                                      :imageUrl="$homeBannerImageUrl['desktop']['en']" />
                                    <x-image_preview title="Current Mobile Home Banner"
                                      :imageUrl="$homeBannerImageUrl['mobile']['en']" />
                                    {!! CmsForm::text('translations.title.en', ['disabled']) !!}
                                    {!! CmsForm::text('translations.url.en', ['required' => false,
                                    'disabled'])->setTitle('Banner URL (optional)') !!}
                                    {!! CmsForm::text('translations.description.en',['disabled'])->setTitle('Banner
                                    Description')
                                    !!}
                                    {!! CmsForm::text('translations.subdescription.en',['disabled'])->setTitle('Banner
                                    Sub
                                    Description') !!}
                                    {!! CmsForm::text('translations.cta_text.en',['disabled'])->setTitle('CTA Text') !!}
                                    {!! CmsForm::text('translations.cta_url.en',['disabled'])->setTitle('CTA URL') !!}
                                </div>
                                <div class="tab-pane fade p-2" id="-id" role="tabpanel">
                                    <x-image_preview title="Current Desktop Home Banner"
                                      :imageUrl="$homeBannerImageUrl['desktop']['id']" />
                                    <x-image_preview title="Current Mobile Home Banner"
                                      :imageUrl="$homeBannerImageUrl['mobile']['id']" />
                                    {!! CmsForm::text('translations.title.id', ['disabled']) !!}
                                    {!! CmsForm::text('translations.url.id', ['required' => false,
                                    'disabled'])->setTitle('Banner URL (optional)') !!}
                                    {!! CmsForm::text('translations.description.id',['disabled'])->setTitle('Banner
                                    Description')
                                    !!}
                                    {!! CmsForm::text('translations.subdescription.id',['disabled'])->setTitle('Banner
                                    Sub
                                    Description') !!}
                                    {!! CmsForm::text('translations.cta_text.id',['disabled'])->setTitle('CTA Text') !!}
                                    {!! CmsForm::text('translations.cta_url.id',['disabled'])->setTitle('CTA URL') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.home_banners.update'))
                            <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                Edit Home Banner
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