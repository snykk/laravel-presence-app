@section('additional_scripts')
<script type="text/javascript">
    window.resourceUrl = '{{ route('cms.topup_methods.index') }}';
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
                    <h3 class="card-title">Create New Topup Method</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" wire:submit.prevent="save">
                        {{ CmsForm::setErrorBag($errors) }}

                        {!! CmsForm::number('topupMethod.order') !!}
                        <div class="form-group">
                            <label for="topupMethod.methodable_type">Methodable Type</label>
                            <select class="form-control" required="" wire:model="topupMethod.methodable_type" id="topupMethod.methodable_type" name="topupMethod.methodable_type">
                                <option value="App\Models\TopupAnchor">Anchor</option>
                                <option value="App\Models\TopupVendor">Vendor</option>
                            </select>
                        </div>
                        @php
                            if($this->topupMethod->methodable_type != $this->methodableType)
                            {
                                $this->switched();
                            }
                        @endphp
                        @if($this->topupMethod->methodable_type == 'App\Models\TopupAnchor')
                        {!! CmsForm::select('topupMethod.methodable_id', $topupAnchorIds, ['wire:model' => 'topupMethod.methodable_id'])->setTitle('Anchor') !!}
                        @else
                        {!! CmsForm::select('topupMethod.methodable_id', $topupVendorIds, ['wire:model' => 'topupMethod.methodable_id'])->setTitle('Vendor') !!}
                        @endif
                        {!! CmsForm::select('published', $publishedOptions) !!}
                        @multilingual
                            {!! CmsForm::text('name') !!}
                        @endmultilingual

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Topup Method</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
