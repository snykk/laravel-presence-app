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
                    <h3 class="card-title">Create New Admin</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save" autocomplete="off">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('data.name') !!}
                        {!! CmsForm::email('data.email', [
                            'readonly' => 'none', 'onfocus' => 'this.removeAttribute(\'readonly\');'
                        ]) !!}
                        {!! CmsForm::password('data.password', [
                            'readonly' => 'none', 'onfocus' => 'this.removeAttribute(\'readonly\');'
                        ]) !!}
                        {!! CmsForm::password('data.password_confirmation') !!}
                        {!! CmsForm::select('data.roles', $roleOptions, ['class' => 'form-control input-select2', 'multiple' => 'multiple']) !!}

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Admin</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
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
            selects.on('change', function () {
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
