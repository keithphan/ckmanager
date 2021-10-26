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
        <form action="{{ route('products.store') }}" method="post">
            @csrf
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Product Information') }}
                    <div>
                        <a class="btn btn-primary btn-icon" href="{{ route('products.create') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Back to all categories">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="name">{{ __('Name') }}<span class="required-input">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}">
                                    <input type="text" hidden name="category_id" value="{{ $category->id }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="company_id">{{ __('Company') }}<span class="required-input">*</span></label>
                                    <select name="company_id" id="company_id" style="width: 100%;" class="form-control @error('company_id') is-invalid @enderror">
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" class="thumbnail-wp">
                            <label for="thumbnail">{{ __('Thumbnail') }} ({{ __('Optional') }})</label>
                            <div class="input-group">
                                <input id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" type="text" name="thumbnail" value="{{ old('thumbnail') }}">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    {{ __('Choose') }}
                                </a>
                                @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div id="holder" style="margin-top:15px;margin-bottom:15px;max-height:200px;">
                            </div>
                        </div>

                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Gallery') }}
                    <div>
                        <button id="btnImgAdd" type="button" class="btn btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="left" title="Add an image">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="rows">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="gallery">{{ __('Url Image') }} ({{ __('Optional') }})</label>
                                    <div class="input-group">
                                        <input id="gallery" class="form-control" type="text" name="gallery[]">
                                        <a id="lfm-1" data-input="gallery" data-preview="holder-1" class="btn btn-primary">
                                            {{ __('Choose') }}
                                        </a>
                                    </div>
                                    <div id="holder-1" style="margin-top:15px;margin-bottom:15px;max-height:200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('pages.products.forms.' . $category->slug . '.create')

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Inventory') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="quantity">{{ __('Quantity') }}<span class="required-input">*</span></label>
                                <div class="input-group">
                                    <input class="form-control @error('quantity') is-invalid @enderror" id="quantity" type="number" name="quantity" value="{{ old('quantity') }}">
                                </div>
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="unit">{{ __('Unit') }}</label>
                                <div class="input-group">
                                    <input class="form-control @error('unit') is-invalid @enderror" id="unit" type="text" name="unit" placeholder="1kg" value="{{ old('unit') }}">
                                </div>
                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3"></div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Price') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="price">Price<span class="required-input">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text">$</div>
                                    <input class="form-control @error('price') is-invalid @enderror" id="price" type="number" name="price" step="any" value="{{ old('price') / 100 }}">
                                </div>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="original_price">Original Price</label>
                                <div class="input-group">
                                    <div class="input-group-text">$</div>
                                    <input class="form-control @error('original_price') is-invalid @enderror" id="original_price" type="number" name="original_price" step="any" value="{{ old('original_price') / 100 }}">
                                </div>
                                @error('original_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3"></div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Description') }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="short_description">{{ __('Short Description') }}</label>
                        <textarea name="short_description" id="short_description" rows="10" class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description')}}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="long_description">{{ __('Long Description') }}</label>
                        <textarea name="long_description" id="long_description" rows="50" class="form-control @error('long_description') is-invalid @enderror">{{ old('long_description')}}</textarea>
                    </div>

                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
