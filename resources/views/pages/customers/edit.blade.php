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
                            {{ __('Edit your customers') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Edit your order here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <form action="{{ route('customers.update', $customer->id) }}" method="post">
            @csrf
            @method('PUT')
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
                                <input class="form-control @error('customerName') is-invalid @enderror" id="customerName" type="text" name="customerName" value="{{ $customer->name }}">
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
                                        @if ($company->id == $customer->company_id)
                                            <option selected value="{{ $company->id }}">{{ $company->name }}</option>
                                        @else
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endif
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
                                <input class="form-control @error('customerEmailAddress') is-invalid @enderror" id="customerEmailAddress" type="text" name="customerEmailAddress" value="{{ $customer->email }}">
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
                                <input class="form-control @error('customerPhoneNumber') is-invalid @enderror" id="customerPhoneNumber" type="text" name="customerPhoneNumber" value="{{ $customer->phone_number }}">
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
                        {{-- <label for="customerDeliverAddress">{{ __('Deliver address') }}</label> --}}
                        @if ($customer->addresses)
                            @php
                                $addressJson = json_decode($customer->addresses);
                            @endphp
                            @foreach ($addressJson->addresses as $index => $address)
                                {{-- <div class="row">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" data-bs-toggle="tooltip" data-bs-placement="left" title="Set as default">
                                            <input type="radio" {{ $index == $addressJson->default ?  "checked" : "" }}  name="default" value="{{ $index }}">
                                        </span>
                                        <input class="form-control" id="customerDeliverAddress" type="text" name="customerDeliverAddresses[]" value="">
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="col-4">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" data-bs-toggle="tooltip" data-bs-placement="left" title="Set as default">
                                                <input type="radio" {{ $index == $addressJson->default ?  "checked" : "" }} name="default" value="{{ $index }}">
                                            </span>
                                            <input class="form-control @error('deliverAddresses.' . $index) is-invalid @enderror" id="customerDeliverAddress" type="text" name="deliverAddresses[]" placeholder="Address" value="{{ $address->address }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group mb-3">
                                            <input class="form-control @error('suburbs.' . $index) is-invalid @enderror" id="suburb" type="text" name="suburbs[]" placeholder="City / Suburb" value="{{ $address->suburb }}">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group mb-3">
                                            <input class="form-control @error('zipCodes.' . $index) is-invalid @enderror" id="zipCode" type="text" name="zipCodes[]" placeholder="Zip Code" value="{{ $address->zip }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group mb-3">
                                            <select name="states[]" id="state-select-{{ $index }}" style="width: 100%;" class="form-control @error('states.*') is-invalid @enderror">
                                                <option {{ $address->state == "New South Wales" ? "selected": "" }} value="New South Wales">New South Wales</option>
                                                <option {{ $address->state == "Victoria" ? "selected": "" }} value="Victoria">Victoria</option>
                                                <option {{ $address->state == "Queensland" ? "selected": "" }} value="Queensland">Queensland</option>
                                                <option {{ $address->state == "South Australia" ? "selected": "" }} value="South Australia">South Australia</option>
                                                <option {{ $address->state == "Western Australia" ? "selected": "" }} value="Western Australia">Western Australia</option>
                                                <option {{ $address->state == "Tasmania" ? "selected": "" }} value="Tasmania">Tasmania</option>
                                                <option {{ $address->state == "North Territory" ? "selected": "" }} value="North Territory">North Territory</option>
                                                <option {{ $address->state == "Australian Capital Territory" ? "selected": "" }} value="Australian Capital Territory">Australian Capital Territory</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        
                        @else  
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
                        @endif
                    </div>

                    @error('customerDeliverAddress')
                        <span class="invalid-feedback d-block mb-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
