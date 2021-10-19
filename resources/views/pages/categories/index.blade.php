@extends('layouts.app')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            {{ __('Categories') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Manage all categories here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Categories') }}
                <div>
                    <a class="btn btn-primary btn-icon" href="{{ route('categories.create') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Create a category">
                        <i class="fas fa-plus"></i>
                    </a>
                    <div style="display: inline-block;" data-bs-toggle="tooltip" data-bs-placement="left" title="Delete selected categories">
                        <button id="deleteItems" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th data-sortable="false" width="50px" style="text-align: center;">
                                <input type="checkbox" id="selectAll" data-bs-toggle="tooltip" data-bs-placement="left" title="Select all">
                            </th>
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
                        @foreach ($categories as $category)
                            <tr>
                                <td style="text-align: center">
                                    <input class="selectedItems" type="checkbox" name="selectedItems[]" value="{{ $category->id }}">
                                </td>
                                <td>
                                    @foreach ($category->ancestors as $ancestor)
                                        {{ $ancestor->name }} &nbsp;<i class="fal fa-long-arrow-right"></i>
                                    @endforeach
                                    {{ $category->name }}
                                </td>
                                <td style="text-align: center">
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('categories.edit', $category->id) }}"><i class="far fa-edit"></i></a>
                                    {{-- <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button> --}}
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark delete" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-id={{ $category->id }}><i class="far fa-trash-alt"></i></button>
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
