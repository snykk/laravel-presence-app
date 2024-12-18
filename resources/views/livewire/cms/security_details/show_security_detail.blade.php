@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.security_details.index') }}';
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
                    <h3 class="card-title">Security Detail Detail #{{ $securityDetail->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('securityDetail.order', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('published', ['disabled' => 'disabled']) !!}

                        @multilingual
                            {!! CmsForm::text('title', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::textarea('description', ['disabled' => 'disabled']) !!}
                            @php
                                $localeKey = config('i18n.language_key', 'language');
                            @endphp
                            <label for="preview">Current Image</label>
                            <div class="form-group">
                                @if($securityDetail->getAttribute('thumbnail_' . $_locale->{$localeKey}))
                                    <div class="mt-6">
                                        <img src="{{ $securityDetail->getAttribute('thumbnail_' . $_locale->{$localeKey} ) }}" style="border: 1px solid #333;" />
                                    </div>
                                @else
                                    <p class="text-muted">No image available</p>
                                @endif
                            </div>
                        @endmultilingual

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.security_details.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Security Detail
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
