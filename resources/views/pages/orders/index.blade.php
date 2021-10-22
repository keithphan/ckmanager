@extends('layouts.app')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="shopping-cart"></i></div>
                            {{ __('Orders') }}
                        </h1>
                        <div class="page-header-subtitle">{{ __('Manage all orders here.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{ __('Orders') }}
                <div>
                    <a class="btn btn-primary btn-icon" href="{{ route('orders.create') }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Create an order">
                        <i class="fas fa-plus"></i>
                    </a>
                    <div style="display: inline-block;" data-bs-toggle="tooltip" data-bs-placement="left" title="Delete selected orders">
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
                            <th>Customer name</th>
                            <th>Total (Shipping fee included)</th>
                            <th data-sortable="false" width="50px" >Status</th>
                            <th width="180px">Date</th>
                            <th data-sortable="false" width="100px" style="text-align: center">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Customer name</th>
                            <th>Total (Shipping fee included)</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td style="text-align: center">
                                <input class="selectedItems" type="checkbox" name="selectedItems[]" value="{{ $order->id }}">
                            </td>
                            <td>{{ $order->customer->name }}</td>
                            <td>AU ${{ ($order->total + $order->shipping_fee) /100 }}</td>
                            <td>
                                @if ($order->deleted_at)
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
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td style="text-align: center">
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('orders.show', $order->id) }}"><i class="far fa-edit"></i></a>
                                {{-- <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button> --}}
                                <button class="btn btn-datatable btn-icon btn-transparent-dark delete" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-id={{ $order->id }}>
                                  @if ($order->deleted_at)
                                    <i class="fas fa-ban"></i>
                                  @else
                                    <i class="far fa-trash-alt"></i>
                                  @endif
                                </button>
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
