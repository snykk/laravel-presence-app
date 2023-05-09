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
                    <h3 class="card-title">Brand Detail #{{ $brand->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        <div>
                            <label for="preview">Current Logo</label>
                            @if($brandLogoUrl)
                                <div class="form-group">
                                    <img src="{{ $brandLogoUrl }}" style="border: 1px solid #333;" />
                                </div>
                            @else
                                <p class="text-muted">No Logo available</p>
                            @endif
                        </div>
                        {!! CmsForm::text('brand.title', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('brand.rank', ['disabled' => 'disabled'])->setTitle("Promo's Rank") !!}
                        {!! CmsForm::select('brand.highlighted', $highlightedOptions, ['disabled' => 'disabled']) !!}

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.brands.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Brand
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
