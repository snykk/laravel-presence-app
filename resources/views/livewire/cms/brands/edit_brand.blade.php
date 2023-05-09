@section('additional_heads')
    <link href="{{ asset('css/close-btn.css') }}" rel="stylesheet">
@endsection

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
                    <h3 class="card-title">Edit Brand #{{ $brand->getKey() }}</h3>
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

                        <div>
                            <label for="preview">Current Logo</label>
                            @if($brandLogoUrl)
                                <div class="form-group img-container">
                                    <img src="{{ $brandLogoUrl }}" style="border: 1px solid #333;" />
                                    <button class="btn btn-danger dt-delete">
                                        Delete image
                                    </button>
                                </div>
                            @else
                                <p class="text-muted">No Logo available</p>
                            @endif
                        </div>

                        {!! CmsForm::text('brand.title') !!}
                        {!! CmsForm::number('brand.rank')->setTitle("Promo's Rank") !!}
                        {!! CmsForm::select('brand.highlighted', $highlightedOptions) !!}

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update Brand</button>
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
