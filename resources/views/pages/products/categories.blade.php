@extends('layouts.app')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="plus-circle"></i></div>
                            {{ __('Create your products') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Create a new product here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Choose a category for your product') }}
                <div>
                    <a class="btn btn-primary btn-icon" href="{{ route('products.index') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Back to all products">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th data-sortable="false" width="100px" style="text-align: center">Choose</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Choose</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    @foreach ($category->ancestors as $ancestor)
                                        {{ $ancestor->name }} &nbsp;<i class="fal fa-long-arrow-right"></i>
                                    @endforeach
                                    {{ $category->name }}
                                </td>
                                <td style="text-align: center">
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('products.create', ['category' => $category->slug]) }}"><i class="fas fa-arrow-right"></i></a>
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
