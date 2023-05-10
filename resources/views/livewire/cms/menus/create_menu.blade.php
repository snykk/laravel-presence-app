@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.menus.index') }}';
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
                    <h3 class="card-title">Create New Menu</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('menu.order') !!}
                        {!! CmsForm::number('menu.level') !!}
                        {!! CmsForm::select('menu.parent_id', $parents)->setTitle('Parent Menu/Group') !!}
                        {!! CmsForm::select('menu.type', $typeOptions)->setTitle('Type') !!}
                        {!! CmsForm::select('isPublished', $isPublishedOptions)->setTitle('Publish Menu') !!}

                        @multilingual
                            {!! CmsForm::text('title') !!}
                            {!! CmsForm::text('url') !!}
                        @endmultilingual

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Menu</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
