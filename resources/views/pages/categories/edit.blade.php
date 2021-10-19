@extends('layouts.app')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="edit"></i></div>
                            {{ __('Update your brands') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Update your brand here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Brand information') }}
                <a class="btn btn-primary btn-icon" href="{{ route('categories.index') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Back to all categories">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('categories.update', $category->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name">{{ __('Name') }}</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ $category->name }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="parent_id">{{ __('Parent') }} ({{ __('Optional') }})</label>
                                {{-- <input class="form-control @error('parent_id') is-invalid @enderror" id="parent_id" type="text" name="parent_id"> --}}
                                <select name="parent_id" id="parent_id" style="width: 100%;" class="selectParent form-control @error('parent_id') is-invalid @enderror">
                                    <option value="">None</option>
                                    @foreach ($categories as $cate)
                                        @if ($category->id != $cate->id)
                                            @if (isset($category->parent_id))
                                                <option {{ $cate->id == $category->parent_id ? 'selected' : '' }} value="{{ $cate->id }}">{{ $cate->name }} @isset($cate->brand->name) ({{ $cate->brand->name }}) @endisset</option>
                                            @else
                                                <option value="{{ $cate->id }}">{{ $cate->name }} @isset($cate->brand->name) ({{ $cate->brand->name }}) @endisset</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description">{{ __('Description') }} ({{ __('Optional') }})</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="10">{{ $category->description }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
