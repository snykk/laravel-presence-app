@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.ctas.index') }}';
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
                    <h3 class="card-title">Create New Cta</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::select('cta.ctable_type', $modelTypeOptions) !!}
                        {!! CmsForm::number('cta.ctable_id') !!}
                        {!! CmsForm::select('cta.action_type', $typeOptions) !!}
                        {!! CmsForm::text('cta.slug', ['required' => false])->setTitle('Cta Slug (optional)') !!}

                        @multilingual
                            {!! CmsForm::text('title') !!}
                            {!! CmsForm::text('url') !!}
                        @endmultilingual

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Cta</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
