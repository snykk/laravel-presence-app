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
                    <h3 class="card-title">Edit Subject Schedule #{{ $subjectSchedule->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::select('subjectSchedule.subject_id', $subjectOptions)->setTitle('Subject') !!}
                        {!! CmsForm::select('subjectSchedule.schedule_id', $scheduleOptions)->setTitle('Schedule') !!}
                        {!! CmsForm::select('subjectSchedule.class_index', $classIndexOptions)->setTitle('Class Index')
                        !!}

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update Subject Schedule</button>
                            <button wire:click="backToIndex()" type="button"
                              class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>