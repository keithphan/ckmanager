@extends('layouts.app')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="info"></i></div>
                            {{ __('Order information') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Order information here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        {{-- <form action="" method="post"> --}}
            {{-- @csrf --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Customer Information') }}
                    <div>
                        <a class="btn btn-primary btn-icon" href="{{ route('orders.index') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Back to all orders">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customerName">{{ __('Full name') }}</label>
                                <input class="form-control" id="customerName" type="text" name="customerName" value="{{ $order->customer_name }}" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customerPhoneNumber">{{ __('Phone number') }}</label>
                                <input class="form-control" id="customerPhoneNumber" type="text" name="customerPhoneNumber" value="{{ $order->customer_phoneNumber }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="customerEmailAddress">{{ __('Email address') }}</label>
                        <input class="form-control" id="customerEmailAddress" type="text" name="customerEmailAddress" value="{{ $order->customer_email }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="customerDeliverAddress">{{ __('Deliver address') }}</label>
                        <input class="form-control" id="customerDeliverAddress" type="text" name="customerDeliverAddress" value="{{ $order->customer_address }}" readonly>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>{{ __('Order Details') }}</div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th width="130px">Quantity</th>
                                    {{-- <th data-sortable="false" width="100px" style="text-align: center">Actions</th> --}}
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($order->orderDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->product->category->name }}</td>
                                        <td>AU ${{ $detail->product->price  / 100 }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                <p>{{ __("Deliver to") }}: {{ $order->customer_address }}</p>
                            </div>
                            <div class="mb-3">
                                <p>{{ __("Payment method") }}: {{ Str::upper($order->payment_method) }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="shipping_fee">{{ __("Shipping fee") }}</label>
                                <div class="input-group">
                                    <div class="input-group-text">AU$</div>
                                    <input class="form-control" type="number" name="shipping_fee" step="any" value="{{ $order->shipping_fee / 100 }}" readonly>
                                </div>
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
                                <p>{{ __("Status") }}: @if ($order->deleted_at)
                                                            <span class="badge bg-danger">{{ __("deleted") }}</span>
                                                        @else
                                                            @if ($order->status == 'waitting')
                                                                <span class="badge bg-warning">{{ $order->status }}</span>
                                                            @endif
                                                            @if ($order->status == 'delivering')
                                                                <span class="badge bg-info">{{ $order->status }}</span>
                                                            @endif
                                                            @if ($order->status == 'successful')
                                                                <span class="badge bg-success">{{ $order->status }}</span>
                                                            @endif
                                                        @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <p>{{ __("Date") }}: {{ $order->created_at }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="total">{{ __("Total") }}</label>
                                <div class="input-group">
                                    <div class="input-group-text">AU$</div>
                                    <input class="form-control" id="total" type="number" name="total" step="any" value="{{ ($order->total + $order->shipping_fee) / 100 }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="form-control" rows="6" id="description" type="text" name="description" readonly>{{ $order->description }}</textarea>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button class="btn btn-danger delete" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-id={{ $order->id }}>{{ __($order->deleted_at ? "Remove" : "Delete") }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </form> --}}
    </div>
</main>
@endsection
