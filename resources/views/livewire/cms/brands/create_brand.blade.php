@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.brands.index') }}';
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
                    <h3 class="card-title">Create New Brand</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        <div class="form-group">
                            <label for="brandLogo">Brand Logo</label>
                            <x-media-library-attachment name="brandLogo" rules="{{ $mediaRules['image'] }}" />
                            <div class="font-size-sm mt-2 text-info">It is recommended to upload an image with 290x163 resolution.</div>
                        </div>

                        {!! CmsForm::text('brand.title') !!}
                        {!! CmsForm::number('brand.rank')->setTitle("Promo's Rank") !!}
                        {!! CmsForm::select('brand.highlighted', $highlightedOptions) !!}

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Brand</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
