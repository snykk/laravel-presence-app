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
                    <h3 class="card-title">Cta Detail #{{ $cta->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('cta.ctable_type', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('cta.ctable_id', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('cta.action_type', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('cta.slug', ['disabled' => 'disabled'])->setTitle('Cta Slug (optional)') !!}

                        @multilingual
                            {!! CmsForm::text('title', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('url', ['disabled' => 'disabled']) !!}
                        @endmultilingual

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.ctas.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Cta
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
