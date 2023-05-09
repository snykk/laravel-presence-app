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
                    <h3 class="card-title">Edit Privacy Policy #{{ $privacyPolicy->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('slug', ['required' => false]) !!}
                        {!! CmsForm::number('privacyPolicy.order') !!}
                        {!! CmsForm::select('privacyPolicy.is_private', $privateOptions)->setTitle('Set Private') !!}
                        {!! CmsForm::date('publishedAt', ['required' => false])->setTitle('Publish Schedule') !!}

                        <div class="form-group">
                            <label>Image</label>
                            <x-media-library-attachment name="policyImage" rules="{{ $mediaRules['image'] }}" />
                            <div class="font-size-sm mt-2 text-info">It is recommended to upload an image with 900x510 resolution.</div>
                        </div>

                        <label for="preview">Current Image</label>
                        <p class="text-muted {{ $policyImageUrl ? 'd-none' : 'd-block' }}">No image available</p>
                        <div class="form-group {{ ($policyImageUrl) ? 'd-block' : 'd-none' }} img-container">
                            <img src="{{ $policyImageUrl }}" style="border: 1px solid #333;" />
                            <button class="btn btn-danger dt-delete">
                                Delete policy image
                            </button>
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
                                    {!! CmsForm::text('translations.title.en', ['required'])->setTitle("Title") !!}
                                    <x-input.tinymce labelName="English Description" wire:model="translations.description.en" />
                                </div>

                                <div class="tab-pane fade p-2 " id="-id-privacy_policies" role="tabpanel">
                                    {!! CmsForm::text('translations.title.id', ['required'])->setTitle("Title") !!}
                                    <x-input.tinymce labelName="Indonesia Description" wire:model="translations.description.id" />
                                </div>
                            </div>
                        </div>
                        @include($seoMetaBlade, ['component' => $this])

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update Privacy Policy</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            $('.dt-delete').click(function (event) {
                event.preventDefault();
                event.stopPropagation();
                if (confirm('Do you really wish to continue?')) {
                @this.deleteImage();
                }
            });
        })
    </script>
</div>
