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
                    <h3 class="card-title">Edit Faq #{{ $faq->getKey() }}</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('faq.order') !!}
                        {!! CmsForm::text('slug', ['required' => false]) !!}
                        {!! CmsForm::datetimeLocal('publishedAt')->setTitle('Published at')  !!}
                        {!! CmsForm::select('faq.faq_topic_id', $this->faqTopicOptions)->setTitle('Topic') !!}

                        @multilingual
                            {!! CmsForm::text('title') !!}
                            {!! CmsForm::text('cta_text') !!}
                        @endmultilingual

                        <div class="form-group">
                            @error('content.en')
                            <p class="text-danger"> {{ $message }} </p>
                            @enderror
                            <x-input.tinymce labelName="English Content" wire:model.defer="content.en" />

                            @error('content.id')
                            <p class="text-danger"> {{ $message }} </p>
                            @enderror
                            <x-input.tinymce labelName="Bahasa Content" wire:model.defer="content.id" />
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update Faq</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
