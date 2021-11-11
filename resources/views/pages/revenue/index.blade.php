@extends('layouts.app')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="dollar-sign"></i></div>
                            {{ __('Companies') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Choose a company.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Choose a company') }}
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th data-sortable="false" width="100px" style="text-align: center">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($companies as $company)
                            <tr>
                                <td>{{ $company->name }}</td>
                                <td style="text-align: center">
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('revenue.company', [$company->slug, 'startDate' => Carbon\Carbon::now()->format('Y-m-d'), 'endDate' => Carbon\Carbon::now()->format('Y-m-d')]) }}"><i class="fas fa-arrow-right"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
