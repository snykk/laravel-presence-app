@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.topup_anchors.index') }}';
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
                    <h3 class="card-title">Topup Anchor Detail #{{ $topupAnchor->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('topupAnchor.admin_fee', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('topupAnchor.minimum', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('topupAnchor.order', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('published', ['disabled' => 'disabled']) !!}

                        <label for="preview">Current Image</label>
                        <div class="form-group">
                        @if($topupAnchor->getAttribute('small_image'))
                            <img src="{{ $topupAnchor->getAttribute('small_image') }}" style="border: 1px solid #333;" />
                        @else
                            <p class="text-muted">No image available</p>
                        @endif
                        </div>

                        @multilingual
                            {!! CmsForm::text('anchor', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('title', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('headline', ['disabled' => 'disabled']) !!}
                        @endmultilingual

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.topup_anchors.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Topup Anchor
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
