@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.components.index') }}';
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
                    <h3 class="card-title">Component Detail #{{ $component->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::text('published', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('component.type', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::number('component.order', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('component.name', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('component.slug', ['disabled' => 'disabled']) !!}

                        @multilingual
                            {!! CmsForm::text('title', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('description', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::textarea('content', ['disabled' => 'disabled']) !!}
                        @endmultilingual

                        <div class="form-group mb-12">
                            <div class="form-group">
                                <label>English Attachments</label>
                            </div>
                            <div class="form-group">
                                @if (count($mediaEn) > 0)
                                    @foreach ($mediaEn as $image)
                                        <img src="{{ $image->getUrl() }}"
                                            style="border: 1px solid #333; max-width:300px; max-height:300px;" />
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-12">
                            <div class="form-group">
                                <label>Bahasa Attachments</label>
                            </div>
                            <div class="form-group">
                                @if (count($mediaId) > 0)
                                    @foreach ($mediaId as $image)
                                        <img src="{{ $image->getUrl() }}"
                                            style="border: 1px solid #333; max-width:300px; max-height:300px;" />
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.components.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Component
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
