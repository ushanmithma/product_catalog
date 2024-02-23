@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row g-2 align-items-center mb-4">
                <div class="col">
                    <h3>{{ __('Show Product') }}</h3>
                </div>
                <div class="col-auto ms-auto d-print-none">
                  <div class="btn-list">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary d-none d-sm-inline-block">Go Back</a>
                  </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset("images/$product->image") }}" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <h2>{{ $product->name }} <span class="badge {{ $product->status->value == "Draft" ? 'text-bg-warning' : '' }}{{ $product->status->value == "Published" ? 'text-bg-success' : '' }}{{ $product->status->value == "Out of Stock" ? 'text-bg-danger' : '' }}">{{ $product->status }}</span></h2>
                            <p>{{ $product->code }}</p>

                            <div class="row">
                                <div class="col-3">Category:</div>
                                <div class="col-9"><strong>{{ $product->category }}</strong></div>
                                <div class="col-3">Description:</div>
                                <div class="col-9"><strong>{{ $product->description }}</strong></div>
                                <div class="col-3">Selling Price:</div>
                                <div class="col-9"><strong>Rs. {{ $product->selling_price }}</strong></div>
                                <div class="col-3">Special Price:</div>
                                <div class="col-9"><strong>Rs. {{ $product->special_price }}</strong></div>
                                <div class="col-3">Is Delivery Available:</div>
                                <div class="col-9">
                                    @if ($product->is_delivery_available)
                                    <span class="badge text-bg-success">Yes</span>
                                    @else
                                    <span class="badge text-bg-warning">No</span>
                                    @endif
                                </div>
                            </div>

                            <p class="mt-4">Attributes,</p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($product->attributes as $item)
                                    <tr>
                                        <td><small>{{ $item->name }}</small></td>
                                        <td><small>{{ $item->attribute_value }}</small></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2">No attributes</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script type="module">
</script>
@endpush
