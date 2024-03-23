@extends('layouts.template')


@push('style')
<style>
    #match-results-table_wrapper > .row:first-child {
        display: none !important;
        visibility: hidden;
    }
</style>
@endpush

@section('content')
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Match Result List</h1>
        <p class="fs-5 text-body-secondary">
            List of match results
        </p>
    </div>

    <div class="row col-12 mb-3 text-center">
        <div class="table-responsive">
            {{ $dataTable->table() }}
        </div>
    </div>
@endsection

@push('script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
