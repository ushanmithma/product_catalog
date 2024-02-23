<?php

namespace App\DataTransferObjects;

use App\Enums\ProductStatus;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\ProductRequest;

class ProductDataTransferObject
{
    public function __construct(
        public readonly string $category,
        public readonly string $name,
        public readonly string|null $description,
        public readonly float $selling_price,
        public readonly float|null $special_price,
        public readonly ProductStatus $status,
        public readonly bool $is_delivery_available,
        public readonly UploadedFile|null $image,
    )
    {
        //
    }

    public static function fromAppRequest(ProductRequest $request): ProductDataTransferObject
    {
        $status = ProductStatus::class;

        return new self(
            category: $request->validated('category'),
            name: $request->validated('name'),
            description: $request->validated('description'),
            selling_price: $request->validated('selling_price'),
            special_price: $request->validated('special_price'),
            status: !enum_exists($status) ? ProductStatus::Draft : $status::from($request->validated('status')),
            is_delivery_available: filter_var($request->validated('is_delivery_available'), FILTER_VALIDATE_BOOLEAN) ? true : false,
            image: $request->validated('image'),
        );
    }
}
