@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.tips_services.index') }}';
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
                    <h3 class="card-title">Tips Service Detail #{{ $tipsService->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::select('tipsService.image_type', $imageTypeOptions, ['disabled' => 'disabled']) !!}
                        <label for="preview">Current Image</label>
                        <div class="form-group">
                        @if($tipsService->getAttribute('extra_small_image'))
                            <img src="{{ $tipsService->getAttribute('extra_small_image') }}" style="border: 1px solid #333;" />
                        @else
                            <p class="text-muted">No image available</p>
                        @endif
                        </div>
                        {!! CmsForm::number('tipsService.order', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('published', ['disabled' => 'disabled']) !!}
                        @multilingual
                            {!! CmsForm::text('title', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::textarea('description', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('url', ['disabled' => 'disabled']) !!}
                        @endmultilingual

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.tips_services.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Tips Service
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
