@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.subject_schedules.index') }}';
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
                    <h3 class="card-title">Subject Schedule Detail #{{ $subjectSchedule->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('subjectSchedule.subject_id', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('subjectSchedule.schedule_id', ['disabled' => 'disabled']) !!}

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.subject_schedules.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Subject Schedule
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
