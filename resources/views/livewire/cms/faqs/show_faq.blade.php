@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.faqs.index') }}';
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
                    <h3 class="card-title">Faq Detail #{{ $faq->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('faq.order', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::text('faq.slug', ['disabled' => 'disabled']) !!}
                        {!! CmsForm::datetime('publishedAt', ['disabled' => 'disabled'])->setTitle('Published at') !!}
                        {!! CmsForm::select('faq.faq_topic_id', $this->faqTopicOptions, ['disabled' => 'disabled'])->setTitle('Topic') !!}

                        @multilingual
                            {!! CmsForm::text('title', ['disabled' => 'disabled']) !!}
                            {!! CmsForm::text('cta_text', ['disabled' => 'disabled']) !!}
                        @endmultilingual

                        <div class="form-group">
                            <x-input.tinymce_readonly labelName="English Content" wire:model.defer="content.en" />
                            <x-input.tinymce_readonly labelName="Bahasa Content" wire:model.defer="content.id" />
                        </div>

                        <div class="form-group text-center">
                            @if($this->currentAdmin->can('cms.faqs.update'))
                                <button wire:click="edit()" type="button" class="btn btn-warning mr-2">
                                    Edit Faq
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
