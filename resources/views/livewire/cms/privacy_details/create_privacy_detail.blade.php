@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.privacy_details.index') }}';
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
                    <h3 class="card-title">Create New Privacy Detail</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::select('privacyDetail.privacy_policy_id', $privacyOptions, ['title' => 'Privacy Policy']) !!}
                        {!! CmsForm::datetimeLocal('privacyDetail.published_at', ['required' => false])->setTitle('Publish Schedule') !!}
                        {!! CmsForm::number('privacyDetail.order') !!}
                        <div class="form-group">
                            <label for="detailImage">Image</label>
                            <x-media-library-attachment name="detailImage" rules="{{ $mediaRules['image'] }}" />
                            <div class="font-size-sm mt-2 text-info">It is recommended to upload an image with 900x510 resolution.</div>
                        </div>

                        <div class="example-preview mb-7">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link active" data-toggle="tab" href="#-en-privacy_details">English</a>
                                </li><li class="nav-item ">
                                    <a class="nav-link " data-toggle="tab" href="#-id-privacy_details">Bahasa</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-5">
                                <div class="tab-pane fade p-2 active show" id="-en-privacy_details" role="tabpanel">
                                    {!! CmsForm::text('translations.title.en', ['required'])->setTitle("Title") !!}
                                    <x-input.tinymce labelName="English Content" wire:model="translations.content.en" />
                                </div>

                                <div class="tab-pane fade p-2 " id="-id-privacy_details" role="tabpanel">
                                    {!! CmsForm::text('translations.title.id', ['required'])->setTitle("Title") !!}
                                    <x-input.tinymce labelName="Indonesia Content" wire:model="translations.content.id" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Privacy Detail</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
