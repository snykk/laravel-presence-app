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
                    <h3 class="card-title">Privacy Detail Detail #{{ $privacyDetail->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}
                        {!! CmsForm::text('privacyTitle', ['disabled' => 'disabled', 'title' => 'Privacy Policy\'s Title']) !!}
                        {!! CmsForm::datetime('privacyDetail.published_at', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('privacyDetail.order', ['disabled' => 'disabled']) !!}
                        <div>
                            <label for="preview">Current Image</label>
                            @if($detailImageUrl)
                                <div class="form-group">
                                    <img src="{{ $detailImageUrl }}" style="border: 1px solid #333;" />
                                </div>
                            @else
                                <p class="text-muted">No image available</p>
                            @endif
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
                                    {!! CmsForm::text('translations.title.en', ['disabled' => 'disabled'])->setTitle("Title") !!}
                                    <x-input.tinymce_readonly labelName="English Description" wire:model="translations.content.en" />
                                </div>

                                <div class="tab-pane fade p-2 " id="-id-privacy_details" role="tabpanel">
                                    {!! CmsForm::text('translations.title.id', ['disabled' => 'disabled'])->setTitle("Title") !!}
                                    <x-input.tinymce_readonly labelName="Indonesia Description" wire:model="translations.content.id" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.privacy_details.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Privacy Detail
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
