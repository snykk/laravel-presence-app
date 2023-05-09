@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.components.index') }}';
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
                    <h3 class="card-title">Edit Component #{{ $component->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::select('published', $publishedOptions) !!}
                        {!! CmsForm::select('component.type', $typeOptions) !!}
                        {!! CmsForm::number('component.order', ['required' => false]) !!}
                        {!! CmsForm::text('component.name') !!}
                        {!! CmsForm::text('component.slug', ['required' => false]) !!}

                        @multilingual
                            {!! CmsForm::text('title') !!}
                            {!! CmsForm::text('description', ['required' => false]) !!}
                            {!! CmsForm::textarea('content', ['required' => false]) !!}
                        @endmultilingual

                        <div class="mt-16 mb-16">
                            <div class="mb-8">
                                <h3>Attached English Files</h3>
                            </div>

                            @foreach ($componentImagesEn as $key => $image)
                                <div class="example-preview mb-7" x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    {!! CmsForm::file('componentImagesEn.' . $key . '.image', [
                                            'accept' => implode(',', ['image/png', 'image/jpg', 'image/jpeg']),
                                            'required' => false,
                                        ])->setTitle('File') !!}

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>

                                    <button wire:click="removeFileItem('En', {{ $key }})" type="button"
                                        class="btn btn-danger">Remove File Item</button>
                                </div>
                            @endforeach

                            <button wire:click="addFileItem('En')" type="button" class="btn btn-primary">Add File
                                Item</button>
                        </div>


                        <div class="form-group">
                            @if (count($mediaEn) > 0)
                                @foreach ($mediaEn as $image)
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-icon btn-danger btn-icon-md"
                                            onclick="confirm('Are you sure you want to delete this item?') || event.stopImmediatePropagation()"
                                            wire:click.prevent="mediaRemove({{ $image->id }})"><i
                                                class="fa fa-trash"></i></button>
                                        <img src="{{ $image->getUrl() }}"
                                            style="border: 1px solid #333; max-width:300px; max-height:300px;" />
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="mt-16 mb-16">
                            <div class="mb-8">
                                <h3>Attached Bahasa Files</h3>
                            </div>

                            @foreach ($componentImagesId as $key => $image)
                                <div class="example-preview mb-7" x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    {!! CmsForm::file('componentImagesId.' . $key . '.image', [
                                            'accept' => implode(',', ['image/png', 'image/jpg', 'image/jpeg']),
                                            'required' => false,
                                        ])->setTitle('File') !!}

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>

                                    <button wire:click="removeFileItem('Id', {{ $key }})" type="button"
                                        class="btn btn-danger">Remove File Item</button>
                                </div>
                            @endforeach

                            <button wire:click="addFileItem('Id')" type="button" class="btn btn-primary">Add File
                                Item</button>
                        </div>


                        <div class="form-group">
                            @if (count($mediaId) > 0)
                                @foreach ($mediaId as $image)
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-icon btn-danger btn-icon-md"
                                            onclick="confirm('Are you sure you want to delete this item?') || event.stopImmediatePropagation()"
                                            wire:click.prevent="mediaRemove({{ $image->id }})"><i
                                                class="fa fa-trash"></i></button>
                                        <img src="{{ $image->getUrl() }}"
                                            style="border: 1px solid #333; max-width:300px; max-height:300px;" />
                                    </div>
                                @endforeach
                            @endif
                        </div>


                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update Component</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
