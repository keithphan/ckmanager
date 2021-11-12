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
                            {{ __('Edit your products') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Edit your product here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <form action="{{ route('products.update', $product->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Product Information') }}
                    <div>
                        <a class="btn btn-primary btn-icon" href="{{ route('products.index') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Back to all products">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ $product->name }}">
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
                                    <label for="company_id">{{ __('Company') }}</label>
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
                        <div class="mb-3">
                            <label for="thumbnail">{{ __('Thumbnail') }} ({{ __('Optional') }})</label>
                            <div class="input-group">
                                <input id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" type="text" name="thumbnail" value="{{ $product->thumbnail }}">
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
                                <img src={{ $product->thumbnail }} style="height: 5rem;">
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
                        @php
                            $number = 1
                        @endphp
                        @foreach (explode('|', $product->gallery) as $image)
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        @if ($number == 1)
                                            <label for="gallery">{{ __('Url Image') }} ({{ __('Optional') }})</label>
                                        @endif
                                        <div class="input-group">
                                            <input id="gallery-{{ $number }}" class="form-control" type="text" name="gallery[]" value="{{ $image }}">
                                            <a id="lfm-{{ $number }}" data-input="gallery-{{ $number }}" data-preview="holder-{{ $number }}" class="btn btn-primary">
                                                {{ __('Choose') }}
                                            </a>
                                        </div>
                                        <div id="holder-{{ $number }}" style="margin-top:15px;margin-bottom:15px;max-height:200px;">
                                            @if ($image)
                                                <img src={{ $image }} style="height: 5rem;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $number += 1
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>

            @include('pages.products.forms.' . $category->slug . '.edit')

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Inventory') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="quantity">Quantity</label>
                                <div class="input-group">
                                    <input class="form-control @error('quantity') is-invalid @enderror" id="quantity" type="number" name="quantity" value="{{ $product->quantity }}">
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
                                    <input class="form-control @error('unit') is-invalid @enderror" id="unit" type="text" name="unit" placeholder="1kg" value="{{ $product->unit }}">
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
                                <label for="price">Price</label>
                                <div class="input-group">
                                    <div class="input-group-text">$</div>
                                    <input class="form-control @error('price') is-invalid @enderror" id="price" type="number" name="price" value="{{ $product->price / 100 }}" step="any">
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
                                    <input class="form-control @error('original_price') is-invalid @enderror" id="original_price" type="number" name="original_price" value="{{ $product->original_price / 100 }}" step="any">
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
                    {{ __('Variants') }}
                    <div>
                        <button id="addVariant" type="button" class="btn btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="left" title="Add a variant">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="variant-wrapper">
                        @empty($product->variants->first())
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="variant_name">Name</label>
                                        <input class="form-control" id="variant_name" type="text" name="variant_name[]" value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="variant_price">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-text">$</div>
                                            <input class="form-control" id="variant_price" type="number" name="variant_price[]" step="any" min="0" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="variant_quantity">Quantity</label>
                                        <input class="form-control" id="variant_quantity" type="number" name="variant_quantity[]" step="any" min="0" value="0">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="mb-3">
                                        <label for="variant_gallery">Image</label>
                                            <div class="input-group">
                                                <input class="form-control" id="variant_gallery" type="text" name="variant_gallery[]">
                                                <a id="variant_gallery_button-1" data-input="variant_gallery" data-preview="variant-gallery-holder-1" class="btn btn-primary">
                                                    Choose
                                                </a>
                                            </div>
                                            <div id="variant-gallery-holder-1" style="margin-top:15px;margin-bottom:15px;max-height:200px;"></div>
                                    </div>
                                </div>
                            </div>
                        @endempty
                        @foreach ($product->variants as $key => $variant)
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="variant_name">Name</label>
                                        <input hidden name="variant_ids[]" value="{{ $variant->id }}">
                                        <input class="form-control" id="variant_name" type="text" name="variant_name[]" value="{{ $variant->name }}">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label for="variant_price">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-text">$</div>
                                            <input class="form-control" id="variant_price" type="number" name="variant_price[]" step="any" min="0" value="{{ $variant->price / 100 }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="mb-3">
                                        <label for="variant_quantity">Quantity</label>
                                        <input class="form-control" id="variant_quantity" type="number" name="variant_quantity[]" step="any" min="0" value="{{ $variant->quantity }}">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="mb-3">
                                        <label for="variant_gallery">Image</label>
                                            <div class="input-group">
                                                <input class="form-control" id="variant_gallery-{{ $key + 1 }}" type="text" name="variant_gallery[]" value="{{ $variant->gallery }}">
                                                <a id="variant_gallery_button-{{ $key + 1 }}" data-input="variant_gallery-{{ $key + 1 }}" data-preview="variant-gallery-holder-{{ $key + 1 }}" class="btn btn-primary">
                                                    Choose
                                                </a>
                                            </div>
                                            <div id="variant-gallery-holder-{{ $key + 1 }}" style="margin-top:15px;margin-bottom:15px;max-height:200px;">
                                                <img src="{{ $variant->gallery }}" style="height: 5rem;">
                                            </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    {{ __('* Leave the name as a blank to delete') }}
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Description') }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="short_description">{{ __('Short Description') }}</label>
                        <textarea name="short_description" id="short_description" rows="10" class="form-control @error('short_description') is-invalid @enderror">{{ $product->short_description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="long_description">{{ __('Long Description') }}</label>
                        <textarea name="long_description" id="long_description" rows="50" class="form-control @error('long_description') is-invalid @enderror">{{ $product->long_description }}</textarea>
                    </div>

                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
