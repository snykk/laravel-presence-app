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
                    <h3 class="card-title">Create New Tips Service</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        <div class="form-group">
                            <label for="tipsService.image_type">Image Type</label>
                            <select class="form-control" required="" wire:model.defer="tipsService.image_type" id="tipsService.image_type" name="tipsService.image_type">
                                <option value="icon">Icon</option>
                                <option value="logo">Logo</option>
                            </select>
                            <div class="font-size-sm mt-2 text-info">Title will not be shown if you choose logo but required as identifier in CMS</div>
                        </div>
    
                        <div class="form-group">
                            <label for="tipsServiceImage">Image</label>
                            <x-media-library-attachment name="tipsServiceImage" rules="{{ $mediaRules['image'] }}" />
                        </div>
                        {!! CmsForm::number('tipsService.order') !!}
                        {!! CmsForm::select('published', $publishedOptions) !!}

                        @multilingual
                            {!! CmsForm::text('title') !!}
                            {!! CmsForm::textarea('description') !!}
                            {!! CmsForm::text('url') !!}                            
                        @endmultilingual

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Tips Service</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
