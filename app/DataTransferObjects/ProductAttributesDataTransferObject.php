<?php

namespace App\DataTransferObjects;

use App\Enums\ProductStatus;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\ProductRequest;

class ProductAttributesDataTransferObject
{
    public function __construct(
        public readonly array $product_attributes_ids,
        public readonly array $product_attributes_names,
        public readonly array $product_attributes_values,
    )
    {
        //
    }

    public static function fromAppRequest(ProductRequest $request): ProductAttributesDataTransferObject
    {
        return new self(
            product_attributes_ids: $request->validated('product_attributes_ids'),
            product_attributes_names: $request->validated('product_attributes_names'),
            product_attributes_values: $request->validated('product_attributes_values'),
        );
    }
}
