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
                            {{ __('Edit your orders') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Edit your order here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <form action="{{ route('orders.update', $order->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Order Information') }}
                    <h4>
                        @if ($order->status == 'waitting')
                            <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                        @endif
                        @if ($order->status == 'delivering')
                            <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                        @endif
                        @if ($order->status == 'successful')
                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                        @endif
                    </h4>
                    
                    <div>
                        <a class="btn btn-primary btn-icon" href="{{ route('orders.index') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Back to all orders">
                            <i class="fas fa-chevron-left"></i>
                        </a>

                        <div style="display: inline-block;" data-bs-toggle="tooltip" data-bs-placement="left" title="Delete this order">
                            <button class="btn btn-danger btn-icon delete" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-id={{ $order->id }}>
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                        <div style="display: inline-block;" data-bs-toggle="tooltip" data-bs-placement="left" title="Deliver this order" >
                            <button class="btn btn-info btn-icon deliver" type="button" data-bs-toggle="modal" data-bs-target="#deliverOrder" data-id={{ $order->id }}>
                                <i class="fas fa-truck"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customer">{{ __('Choose customer') }}<span class="required-input">*</span></label>
                                <select name="customer" id="customer" style="width: 100%;" class="form-control @error('customer') is-invalid @enderror">
                                    <option value="">None</option>
                                    @foreach ($customers as $customer)
                                        <option {{ $customer->id == $order->customer->id ? 'selected' : '' }}  value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone_number }} - {{ $customer->email }}</option>
                                    @endforeach
                                </select>
                                @error('customer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <input type="text" class="company_id" name="company_id" value="{{ $order->customer->company_id }}" hidden>
                            </div>
                        </div>
                        <p class="mt-4 mb-5">Or create a new customer:</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customerName">{{ __('Full name') }}<span class="required-input">*</span></label>
                                <input class="form-control @error('customerName') is-invalid @enderror" id="customerName" type="text" name="customerName" value="{{ $order->customer_name }}">
                                @error('customerName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customerPhoneNumber">{{ __('Phone number') }}<span class="required-input">*</span></label>
                                <input class="form-control @error('customerPhoneNumber') is-invalid @enderror" id="customerPhoneNumber" type="text" name="customerPhoneNumber" value="{{ $order->customer_phoneNumber }}">
                                @error('customerPhoneNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="customerEmailAddress">{{ __('Email address') }}</label>
                        <input class="form-control @error('customerEmailAddress') is-invalid @enderror" id="customerEmailAddress" type="text" name="customerEmailAddress" value="{{ $order->customer_email }}">
                        @error('customerEmailAddress')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="customerDeliverAddress">{{ __('Deliver address') }}<span class="required-input">*</span></label>
                        <input class="form-control @error('customerDeliverAddress') is-invalid @enderror" id="customerDeliverAddress" type="text" name="customerDeliverAddress" value="{{ $order->customer_address }}">
                        @error('customerDeliverAddress')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>{{ __('Order Details') }}<span class="required-input">*</span></div>
                    <div>
                        <span id="filled_total">${{ $order->total / 100 }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th data-sortable="false" width="50px" style="text-align: center;">
                                    </th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Inventory</th>
                                    <th width="130px">Quantity</th>
                                    {{-- <th data-sortable="false" width="100px" style="text-align: center">Actions</th> --}}
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Inventory</th>
                                    <th>Quantity</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($orderDetails as $orderDetail)
                                    <tr>
                                        <td style="text-align: center">
                                            <input class="selectedItems" type="checkbox" checked name="selectedItems[]" value="{{ $orderDetail->product_id }}">
                                        </td>
                                        <td>{{ $orderDetail->product->name }}</td>
                                        <td>{{ $orderDetail->product->category->name }}</td>
                                        <td>AU ${{ $orderDetail->product->price  / 100 }}</td>
                                        <td>{{ $orderDetail->product->quantity }}</td>
                                        <td><input class="form-control itemsQty" type="number" name="itemsQty[]" product-id="{{ $orderDetail->product_id }}" value="{{ $orderDetail->quantity }}" min="1"></td>
                                    </tr>
                                @endforeach

                                @foreach ($products as $product)
                                    @if (!in_array($product->id, $orderDetails->pluck('product_id')->toArray()))
                                        <tr>
                                            <td style="text-align: center">
                                                <input class="selectedItems" type="checkbox" name="selectedItems[]" value="{{ $product->id }}">
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>AU ${{ $product->price  / 100 }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td><input class="form-control itemsQty" type="number" name="itemsQty[]" product-id="{{ $product->id }}" value="1" min="1"></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        @error('selectedItems')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            {{ __('Delivery') }}
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p>Deliver to: <span id="filled_address">{{ $order->customer_address }}</span></p>
                            </div>
                            <div class="mb-3">
                                <label for="">{{ __("Payment method") }}<span class="required-input">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" id="flexRadioDefault1" type="radio" name="payment_method" {{ $order->payment_method == 'cod' ? 'checked' : '' }} value="cod">
                                    <label class="form-check-label" for="flexRadioDefault1">COD</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="flexRadioDefault2" type="radio" name="payment_method" {{ $order->payment_method == 'bank' ? 'checked' : '' }} value="bank">
                                    <label class="form-check-label" for="flexRadioDefault2">Bank Transfer</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="shipping_fee">{{ __("Shipping fee") }}</label>
                                <div class="input-group">
                                    <div class="input-group-text">$</div>
                                    <input class="form-control @error('shipping_fee') is-invalid @enderror" id="shipping_fee" type="number" name="shipping_fee" step="any" value="{{ $order->shipping_fee / 100 }}">
                                </div>
                                @error('shipping_fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            {{ __('Summary') }}
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="total">{{ __("Total") }}</label>
                                <div class="input-group">
                                    <div class="input-group-text">$</div>
                                    <input class="form-control" id="total" type="number" name="total" step="any" value="{{ $order->total / 100 }}" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="6" id="description" type="text" name="description">{{ old('description') }}</textarea>
                                @error('original_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
</main>
@endsection
