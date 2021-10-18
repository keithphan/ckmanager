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
                            {{ __('Create your companies') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Create a new company here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Create a company') }}
                <a class="btn btn-primary btn-icon" href="{{ route('companies.index') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Back to all companies">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('companies.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name">{{ __('Name') }}<span class="required-input">*</span></label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail">{{ __('Logo') }}</label>
                        <div class="input-group">
                            <input id="thumbnail" class="form-control @error('logo') is-invalid @enderror" type="text" name="logo">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                {{ __('Choose') }}
                            </a>
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div id="holder" style="margin-top:15px;margin-bottom:15px;max-height:200px;">
                        </div>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="categories">{{ __('Categories') }} ({{ __('Optional') }})</label>
                        <select name="categoryIds[]" id="categories" style="width: 100%;" class="form-control" multiple="multiple">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="mb-3">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="10"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
