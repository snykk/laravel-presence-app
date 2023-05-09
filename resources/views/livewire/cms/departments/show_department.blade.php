@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.departments.index') }}';
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
                    <h3 class="card-title">Department Detail #{{ $department->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('department.code', ['disabled' => 'disabled']) !!}

                        @multilingual
                            {!! CmsForm::text('name', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::textarea('description', ['disabled' => 'disabled']) !!}
                        @endmultilingual

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.departments.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Department
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
