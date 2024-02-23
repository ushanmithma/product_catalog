@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row g-2 align-items-center mb-4">
                <div class="col">
                    <h3>{{ __('Create Product') }}</h3>
                </div>
                <div class="col-auto ms-auto d-print-none">
                  <div class="btn-list">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary d-none d-sm-inline-block">Go Back</a>
                  </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif

                    <form method="POST" action="@if(isset($product)) {{ route('products.update', $product->id) }} @else {{ route('products.store') }} @endif" enctype="multipart/form-data">
                        @csrf

                        @if(isset($product))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" maxlength="100" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($product) ? $product->name : old('name') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('Category') }}</label>

                            <div class="col-md-6">
                                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ isset($product) ? $product->category : old('category') }}" required>
                                    <option value="Category #1">Category #1</option>
                                    <option value="Category #2">Category #2</option>
                                    <option value="Category #3">Category #3</option>
                                    <option value="Category #4">Category #4</option>
                                    <option value="Category #5">Category #5</option>
                                </select>

                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" value="">{{ isset($product) ? $product->description : old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="selling_price" class="col-md-4 col-form-label text-md-end">{{ __('Selling Price') }}</label>

                            <div class="col-md-6">
                                <input id="selling_price" type="number" min="0" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" name="selling_price" value="{{ isset($product) ? $product->selling_price : old('selling_price') }}" required>

                                @error('selling_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="special_price" class="col-md-4 col-form-label text-md-end">{{ __('Special Price') }}</label>

                            <div class="col-md-6">
                                <input id="special_price" type="number" min="0" step="0.01" class="form-control @error('special_price') is-invalid @enderror" name="special_price" value="{{ isset($product) ? $product->special_price : old('special_price') }}">

                                @error('special_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status-draft" value="Draft" {{ isset($product) ? $product->status == \App\Enums\ProductStatus::Draft ? 'checked' : '' : 'checked' }}>
                                    <label class="form-check-label" for="status-draft">Draft</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status-published" value="Published" {{ isset($product) ? $product->status == \App\Enums\ProductStatus::Published ? 'checked' : '' : '' }}>
                                    <label class="form-check-label" for="status-published">Published</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status-out-of-stock" value="Out of Stock" {{ isset($product) ? $product->status == \App\Enums\ProductStatus::OutofStock ? 'checked' : '' : '' }}>
                                    <label class="form-check-label" for="status-out-of-stock">Out of Stock</label>
                                </div>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_delivery_available" value="1" id="is_delivery_available" {{ isset($product) ? $product->is_delivery_available == 1 ? 'checked' : '' : '' }}>

                                    <label class="form-check-label" for="is_delivery_available">
                                        {{ __('Is Delivary Available') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Attributes') }}</label>

                            <div id="input_fields_wrap" class="col-md-8">
                                @if(isset($product) && $product->attributes != null && $product->attributes != '')
                                    <?php $i = 0; ?>
                                    @foreach($product->attributes as $key => $value)
                                        <div class="row gutter mb-2">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <input type="hidden" name="product_attributes_ids[]" value="{{$value->id}}">
                                                    <input type="text" name="product_attributes_names[]" value="{{$value->name ?? ''}}" placeholder="Name" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <input type="text" name="product_attributes_values[]" value="{{$value->attribute_value ?? ''}}" class="form-control form-control-sm" placeholder="Value">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                @if($i == 0)
                                                    <button class="add_field_button btn btn-success btn-sm">Add</button>
                                                @else
                                                    <button class="remove_field btn btn-danger btn-sm">Remove</button>
                                                @endif
                                            </div>

                                        </div>
                                        <?php $i++; ?>
                                    @endforeach
                                @else
                                    <div class="row gutter mb-2">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input type="hidden" name="product_attributes_ids[]" value="0">
                                                <input type="text" class="form-control form-control-sm" name="product_attributes_names[]"  placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm" name="product_attributes_values[]" placeholder="Value">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="add_field_button btn btn-success btn-sm">Add</button>
                                        </div>

                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script type="module">
$(document).ready(function () {

    var wrapper = $("#input_fields_wrap");

    $(".add_field_button").click(function (e) { //on add input button click

        e.preventDefault();

        $(wrapper).append('<div class="row gutter mb-2"><div class="col-sm-5"><div class="form-group"><input type="hidden" name="product_attributes_ids[]" value="0"><input type="text" class="form-control form-control-sm" name="product_attributes_names[]" placeholder="Name"></div></div><div class="col-sm-5"><div class="form-group"><input type="text" class="form-control form-control-sm" name="product_attributes_values[]" placeholder="Value"></div></div><div class="col-sm-2"><button class="remove_field btn btn-danger btn-sm">Remove</button></div></div>'); //add input box

    });
    $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
        var option = $(this);

        if (confirm("Are you sure you want remove this one?")) {
            e.preventDefault();
            option.closest('.gutter').remove();
        }
    });

});
</script>
@endpush
