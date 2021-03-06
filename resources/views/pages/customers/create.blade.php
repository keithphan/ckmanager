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
                            {{ __('Create your orders') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Create a new order here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <form action="{{ route('customers.store') }}" method="post">
            @csrf
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Customer Information') }}
                    <div>
                        <a class="btn btn-primary btn-icon" href="{{ route('customers.index') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Back to all customers">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customerName">{{ __('Full name') }}<span class="required-input">*</span></label>
                                <input class="form-control @error('customerName') is-invalid @enderror" id="customerName" type="text" name="customerName" value="{{ old('customerName') }}">
                                @error('customerName')
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

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customerEmailAddress">{{ __('Email address') }}<span class="required-input">*</span></label>
                                <input class="form-control @error('customerEmailAddress') is-invalid @enderror" id="customerEmailAddress" type="text" name="customerEmailAddress" value="{{ old('customerEmailAddress') }}">
                                @error('customerEmailAddress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customerPhoneNumber">{{ __('Phone number') }}<span class="required-input">*</span></label>
                                <input class="form-control @error('customerPhoneNumber') is-invalid @enderror" id="customerPhoneNumber" type="text" name="customerPhoneNumber" value="{{ old('customerPhoneNumber') }}">
                                @error('customerPhoneNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        {{ __('Deliver addresses') }}<span class="required-input">*</span>
                    </div>
                    <div>
                        <button id="btnAddressAdd" type="button" class="btn btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="left" title="Add an address (Max 5)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="rows">
                        {{-- <label for="customerDeliverAddress">{{ __('Deliver addresses') }}</label> --}}
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" data-bs-toggle="tooltip" data-bs-placement="left" title="Set as default"><input type="radio" checked name="default" value="0"></span>
                                    <input class="form-control @error('deliverAddresses.*') is-invalid @enderror" id="customerDeliverAddress" type="text" name="deliverAddresses[]" placeholder="Address">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <input class="form-control @error('suburbs.*') is-invalid @enderror" id="suburb" type="text" name="suburbs[]" placeholder="City / Suburb">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group mb-3">
                                    <input class="form-control @error('zipCodes.*') is-invalid @enderror" id="zipCode" type="text" name="zipCodes[]" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <select name="states[]" id="state-select" style="width: 100%;" class="form-control @error('states.*') is-invalid @enderror">
                                        <option value="New South Wales">New South Wales</option>
                                        <option value="Victoria">Victoria</option>
                                        <option value="Queensland">Queensland</option>
                                        <option value="South Australia">South Australia</option>
                                        <option value="Western Australia">Western Australia</option>
                                        <option value="Tasmania">Tasmania</option>
                                        <option value="North Territory">North Territory</option>
                                        <option value="Australian Capital Territory">Australian Capital Territory</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
