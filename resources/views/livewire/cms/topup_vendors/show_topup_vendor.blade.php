@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.topup_vendors.index') }}';
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
                    <h3 class="card-title">Topup Vendor Detail #{{ $topupVendor->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::select('topupVendor.topup_anchor_id', $this->topupAnchorIds, ['disabled' => 'disabled'])->setTitle("Anchors") !!}
                        {!! CmsForm::number('topupVendor.admin_fee', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('topupVendor.minimum', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('topupVendor.order', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('published', ['disabled' => 'disabled']) !!}
                        
                        @multilingual
                            {!! CmsForm::text('name', ['disabled' => 'disabled']) !!}
                        @endmultilingual

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.topup_vendors.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Topup Vendor
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
