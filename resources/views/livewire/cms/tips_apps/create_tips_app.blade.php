@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.tips_apps.index') }}';
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
                    <h3 class="card-title">Create New Tips App</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('tipsApp.order') !!}
                        {!! CmsForm::select('published', $publishedOptions) !!}

                        @multilingual
                            {!! CmsForm::text('title') !!}
                            {!! CmsForm::textarea('description') !!}
                            @php
                                $localeKey = config('i18n.language_key', 'language');
                            @endphp
                            <div class="form-group">
                                <label for="appsImage{{ ucfirst($_locale->{$localeKey}) }}">Image</label>
                                <x-media-library-attachment name="appsImage{{ ucfirst($_locale->{$localeKey}) }}" rules="{{ $mediaRules['image'] }}" />
                            </div>
                        @endmultilingual

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Tips App</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
