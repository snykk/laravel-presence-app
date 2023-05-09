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
                    <h3 class="card-title">Edit Article #{{ $article->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('article.author') !!}
                        {!! CmsForm::select('selectedTags', $this->tagIds, ['class' => 'form-control input-select2',
                        'multiple' => 'multiple'])->setTitle("Select Tags") !!}
                        {!! CmsForm::select('article.highlighted', $highlightedOptions) !!}
                        {!! CmsForm::select('article.article_category_id', $categoryOptions)->setTitle("Category") !!}
                        {!! CmsForm::datetimeLocal('publishedAt', ['required' => false])->setTitle('Publish Schedule')
                        !!}
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
                                    $options=['onkeydown=countCharactersTitle(this)']) !!}
                                    <div class="font-size-m text-info">
                                        <p id="titleCharNumEn">
                                            {{ strlen($this->article->translations[0]->title) }} characters.
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
                                    $options=['onkeydown=countCharactersDescription(this)']) !!}
                                    <div class="font-size-m text-info">
                                        <p id="descCharNumEn">
                                            {{ strlen($this->article->translations[0]->description) }} characters.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="articleThumbnailEn">English Thumbnail</label>
                                        <x-media-library-attachment name="articleThumbnailEn"
                                          rules="{{ $mediaRules['image'] }}" />
                                        <div class="font-size-sm mt-2 text-info">It is recommended to upload an image
                                            with 1280x720 resolution.</div>
                                    </div>

                                    <label for="preview">Current English Thumbnail</label>
                                    <div class="form-group">
                                        @if($article->getAttribute('thumbnail_extra_small_en'))
                                        <div class="mt-6">
                                            <img src="{{ $article->getAttribute('thumbnail_extra_small_en') }}"
                                              style="border: 1px solid #333;" />
                                        </div>
                                        @else
                                        <p class="text-muted">No thumbnail available</p>
                                        @endif
                                    </div>

                                </div>

                                <div class="tab-pane fade p-2 " id="-id-article" role="tabpanel">
                                    {!! CmsForm::text('translations.title.id',
                                    $options=['onkeydown=countCharactersTitle(this)']) !!}
                                    <div class="font-size-m text-info">
                                        <p id="titleCharNumId">
                                            {{ strlen($this->article->translations[1]->title) }} characters.
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
                                        on total words of content.</div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>
                                    {!! CmsForm::textarea('translations.description.id',
                                    $options=['onkeydown=countCharactersDescription(this)']) !!}
                                    <div class="font-size-m text-info">
                                        <p id="descCharNumId">
                                            {{ strlen($this->article->translations[1]->description) }} characters.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="articleThumbnailId">Bahasa Thumbnail</label>
                                        <x-media-library-attachment name="articleThumbnailId"
                                          rules="{{ $mediaRules['image'] }}" />
                                        <div class="font-size-sm mt-2 text-info">It is recommended to upload an image
                                            with 1280x720 resolution.</div>
                                    </div>

                                    <label for="preview">Current Bahasa Thumbnail</label>
                                    <div class="form-group">
                                        @if($article->getAttribute('thumbnail_extra_small_id'))
                                        <div class="mt-6">
                                            <img src="{{ $article->getAttribute('thumbnail_extra_small_id') }}"
                                              style="border: 1px solid #333;" />
                                        </div>
                                        @else
                                        <p class="text-muted">No thumbnail available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        @error('content.en')
                        <p class="text-danger"> {{ $message }} </p>
                        @enderror
                        <x-input.tinymce labelName="English Content" wire:model="content.en" />
                        @error('content.id')
                        <p class="text-danger"> {{ $message }} </p>
                        @enderror
                        <x-input.tinymce labelName="Bahasa Content" wire:model="content.id" />

                        @include($seoMetaBlade, ['component' => $this])

                        <div class="form-group text-center">
                            @if($this->publishedAt <= date('Y-m-d H:i:s') && $this->publishedAt != "")
                                <button
                                  onclick="confirm('Are you sure you want to unpublish?') || event.stopImmediatePropagation()"
                                  wire:click="unpublish()" type="button"
                                  class="btn btn-danger active dt-publish">Unpublish and Save</button>
                                @else
                                <button
                                  onclick="confirm('Are you sure you want to publish now?') || event.stopImmediatePropagation()"
                                  wire:click="publishNow()" type="button"
                                  class="btn btn-warning active dt-publish">Publish Now</button>
                                @endif
                                <button type="submit" class="btn btn-primary"
                                  onclick="return confirm('Are you sure about the changes made?')">Save Article</button>
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
            CmsApp.initSelect2(select2Callback);
        })

        window.addEventListener('LiveWireComponentRefreshed', function () {
            CmsApp.initSelect2(select2Callback)
        })

        document.addEventListener('livewire:load', function () {
            $('.dt-delete').click(function (event) {
                event.preventDefault();
                event.stopPropagation();
                if (confirm('Do you really wish to continue?')) {
                    if  (!$(this).attr('data-local'))
                    {
                        @this.deleteImageThumbnail();
                    }
                    const locale = $(this).attr('data-locale');
                    @this.deleteImage(locale);
                }
            });
        })
    </script>
</div>