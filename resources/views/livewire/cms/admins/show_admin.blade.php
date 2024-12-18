@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.admins.index') }}';
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
                    <h3 class="card-title">Admin Detail #{{ $admin->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('data.name', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::email('data.email', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::select('data.roles', $roleOptions, ['class' => 'form-control input-select2', 'multiple' => 'multiple', 'disabled' => 'disabled']) !!}

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.admins.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Admin
                                </button>
                            @endif

                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let select2Callback = function () {
            const selects = $('.input-select2');
            selects.off('change');
            selects.on('change', function (e) {
                let data = $(this).select2("val");
            @this.set('data.roles', data);
            });
        }

        document.addEventListener('livewire:load', function () {
            CmsApp.initSelect2(select2Callback)
        })

        window.addEventListener('LiveWireComponentRefreshed', function () {
            CmsApp.initSelect2(select2Callback)
        })
    </script>
</div>
