@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.articles.index') }}';
</script>
@include('components.article_scripts')
@endsection

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <livewire:cms.nav.breadcrumb :items="$this->breadcrumbItems" />

            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Create New Article</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('article.author') !!}
                        {!! CmsForm::select('article.highlighted', $highlightedOptions) !!}
                        {!! CmsForm::select('article.article_category_id', $categoryOptions)->setTitle("Category") !!}
                        {!! CmsForm::select('selectedTags', $this->tagIds, ['class' => 'form-control
                        input-select2', 'multiple' => 'multiple'])->setTitle("Select Tags") !!}
                        {!! CmsForm::datetimeLocal('publishedAt', ['required' => false])->setTitle('Publish Schedule')
                        !!}
                        <div class="font-size-sm mt-2 mb-12 text-info">Let it empty if you're not planning to publish it
                            yet.</div>
                        {!! CmsForm::select('private', $privateOptions)->setTitle('Set Private') !!}
                        {!! CmsForm::text('slug', ['required' => false]) !!}
                        {!! CmsForm::select('article.rank', $rankOptions, ['required' => false]) !!}
                        <div class="font-size-sm mt-2 text-info">If left empty, it will be generated based on title.
                        </div>

                        <div class="form-group">
                            <label> </label>
                        </div>

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
                                    {!! CmsForm::text('translations.title.en',
                                    $options=['onkeyup=countCharactersTitle(this)']) !!}
                                    <div class="font-size-m text-info">
                                        <p id="titleCharNumEn">
                                            0 characters.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>

                                    <div class="form-group">
                                        <label> Read Time (In Minutes)</label>
                                        <div class="input-group">
                                            <div class="col-xs-2">
                                                <input type="number" wire:model.defer="readTime.en"
                                                  class="form-control" />
                                                @error('readTime.en')
                                                <p class="text-danger"> {{ $message }} </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="font-size-sm mt-2 text-info">If left empty, it will be generated based
                                        on total words of content.</div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>
                                    {!! CmsForm::textarea('translations.description.en',
                                    $options=['onkeyup=countCharactersDescription(this)']) !!}
                                    <div class="font-size-m text-info">
                                        <p id="descCharNumEn">
                                            0 characters.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="articleThumbnail">Thumbnail English</label>
                                        <x-media-library-attachment name="articleThumbnailEn"
                                          rules="{{ $mediaRules['image'] }}" />
                                        <div class="font-size-sm mt-2 text-info">It is recommended to upload an image
                                            with 1280x720 resolution.</div>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-2 " id="-id-article" role="tabpanel">
                                    {!! CmsForm::text('translations.title.id',
                                    $options=['onkeyup=countCharactersTitle(this)']) !!}
                                    <div class="font-size-m text-info">
                                        <p id="titleCharNumId">
                                            0 characters.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>

                                    <div class="form-group">
                                        <label> Read Time (In Minutes)</label>
                                        <div class="input-group">
                                            <div class="col-xs-2">
                                                <input type="number" wire:model.defer="readTime.id"
                                                  class="form-control" />
                                                @error('readTime.id')
                                                <p class="text-danger"> {{ $message }} </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="font-size-sm mt-2 text-info">If left empty, it will be generated based
                                        on content words count.</div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>
                                    {!! CmsForm::textarea('translations.description.id',
                                    $options=['onkeyup=countCharactersDescription(this)']) !!}
                                    <div class="font-size-m text-info">
                                        <p id="descCharNumId">
                                            0 characters.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="articleThumbnail">Thumbnail Bahasa</label>
                                        <x-media-library-attachment name="articleThumbnailId"
                                          rules="{{ $mediaRules['image'] }}" />
                                        <div class="font-size-sm mt-2 text-info">It is recommended to upload an image
                                            with 1280x720 resolution.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            @error('content.en')
                            <p class="text-danger"> {{ $message }} </p>
                            @enderror
                            <x-input.tinymce labelName="English Content" wire:model="content.en" />
                            @error('content.id')
                            <p class="text-danger"> {{ $message }} </p>
                            @enderror
                            <x-input.tinymce labelName="Bahasa Content" wire:model="content.id" />
                        </div>
                        @include($seoMetaBlade, ['component' => $this])

                        <div class="form-group text-center">

                            <button
                              onclick="confirm('Are you sure you want to publish now? Your publish schedule will be ignored.') || event.stopImmediatePropagation()"
                              wire:click="publishNow()" type="button" class="btn btn-warning active dt-publish">Publish
                                Now</button>
                            <button type="submit" class="btn btn-primary">Save Article</button>
                            <button wire:click="backToIndex()" type="button"
                              class="btn btn-light-primary ml-2">Cancel</button>
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