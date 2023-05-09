@section('additional_scripts')
    <script type="text/javascript">
        window.resourceUrl = '{{ route('cms.promos.index') }}';
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
                    <h3 class="card-title">Import Promos</h3>
                </div>
                <div class="card-body">
                    @include('cms::_partials.alert')

                    <form class="form" action="{{url('/promos/import/')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel" class="form-control">

                        <div class="form-group text-center" style="margin-top: 15px">
                            <button type="submit" class="btn btn-primary">Import Promo</button>
                            <button wire:click="backToIndex()" type="button" class="btn btn-light-primary ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
