@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.static_pages.index') }}';
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
                    <h3 class="card-title">Static Page Detail #{{ $staticPage->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('staticPage.layout', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('published', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('private', ['disabled' => 'disabled'])->setTitle('Set Private') !!}
                        {!! CmsForm::text('slug', ['disabled' => 'disabled']) !!}

                        @multilingual
                            {!! CmsForm::text('name', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('youtube_video', ['disabled' => 'disabled']) !!}
                            @php
                                $localeKey = config('i18n.language_key', 'language');
                                $label = 'English';
                                if($_locale->{$localeKey} == 'id'){
                                    $label = 'Bahasa';
                                }
                            @endphp
                            <x-input.tinymce_readonly labelName="{{ $label }} Content" wire:model="translations.content.{{ $_locale->{$localeKey} }}" />
                        @endmultilingual

                        @include($seoMetaBlade, ['component' => $this])

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.static_pages.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Static Page
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
