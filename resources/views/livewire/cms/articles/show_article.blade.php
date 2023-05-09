@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.articles.index') }}';
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
                    <h3 class="card-title">Article Detail #{{ $article->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('article.author', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::select('article.highlighted', $highlightedOptions, ['disabled' => 'disabled']) !!}
                        {!! CmsForm::datetimeLocal('publishedAt', ['disabled' => 'disabled'])->setTitle('Publish
                        Schedule') !!}
                        {!! CmsForm::select('article.is_private', $privateOptions, ['disabled' =>
                        'disabled'])->setTitle('Set Private') !!}
                        {!! CmsForm::text('slug', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::select('article.rank', $rankOptions, ['required' => false,'disabled' =>
                        'disabled']) !!}
                        {!! CmsForm::select('selectedTags', $tagIds, ['class' => 'form-control
                        input-select2', 'multiple' => 'multiple', 'disabled' => 'disabled'])->setTitle("Selected
                        Tags") !!}

                        <div class="example-preview mb-7">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link active" data-toggle="tab" href="#-en-article">English</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link " data-toggle="tab" href="#-id-article">Bahasa</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-5">
                                <div class="tab-pane fade p-2 active show" id="-en-article" role="tabpanel">
                                    {!! CmsForm::text('translations.title.en', ['disabled' => 'disabled']) !!}
                                    {!! CmsForm::text('translations.read_time.en', ['disabled' => 'disabled']) !!}

                                    {!! CmsForm::textarea('translations.description.en', ['disabled' => 'disabled']) !!}
                                    <x-input.tinymce_readonly labelName="English Content" wire:model="content.en" />
                                    <label for="preview">Current English Thumbnail</label>
                                    @if($article->getAttribute('thumbnail_extra_small_en'))
                                    <div class="form-group">
                                        <img src="{{ $article->getAttribute('thumbnail_extra_small_en') }}"
                                          style="border: 1px solid #333;" />
                                    </div>
                                    @else
                                    <p class="text-muted">No thumbnail available</p>
                                    @endif

                                </div>

                                <div class="tab-pane fade p-2 " id="-id-article" role="tabpanel">
                                    {!! CmsForm::text('translations.title.id', ['disabled' => 'disabled']) !!}
                                    {!! CmsForm::text('translations.read_time.id', ['disabled' => 'disabled']) !!}
                                    {!! CmsForm::textarea('translations.description.id', ['disabled' => 'disabled']) !!}
                                    <x-input.tinymce_readonly labelName="Bahasa Content" wire:model="content.id" />
                                    <label for="preview">Current Bahasa Thumbnail</label>
                                    @if($article->getAttribute('thumbnail_extra_small_id'))
                                    <div class="form-group">
                                        <img src="{{ $article->getAttribute('thumbnail_extra_small_id') }}"
                                          style="border: 1px solid #333;" />
                                    </div>
                                    @else
                                    <p class="text-muted">No thumbnail available</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @include($seoMetaBlade, ['component' => $this])

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.articles.update'))
                            <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                Edit Article Page
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