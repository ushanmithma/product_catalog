<?php

namespace App\Services;

use App\Models\{Product, ProductAttribute};
use App\Enums\ProductStatus;
use App\DataTransferObjects\{ProductDataTransferObject, ProductAttributesDataTransferObject};
use Illuminate\Support\Facades\DB;

class ProductService
{
    private function getCode(): string
    {
        $code = '';
        $last_record = Product::orderBy('created_at', 'desc')->first();
        $number = $last_record == null ? 1 : (int)$last_record->id + 1;

        $code = "P" . str_pad($number, 11, "0", STR_PAD_LEFT);
        $is_exists = Product::where('code', $code)->first();

        if ($is_exists != null) throw new \Exception("$code was duplidated.");

        return $code;
    }

    public function index()
    {
        return Product::with('attributes')->latest();
    }

    private function imageUpload($image)
    {
        if ($image == null) return null;

        $file_name = time() . '.' . $image->extension();

        if (file_exists(public_path('images') . '/' . $file_name)) unlink(public_path('images') . '/' . $file_name);

        $image->move(public_path('images'), $file_name);

        return $file_name;
    }

    public function store(ProductDataTransferObject $dto): Product
    {
        return Product::create([
            'code' => $this->getCode(),
            'category' => $dto->category,
            'name' => $dto->name,
            'description' => $dto->description,
            'selling_price' => $dto->selling_price,
            'special_price' => $dto->special_price,
            'status' => $dto->status->value,
            'is_delivery_available' => $dto->is_delivery_available ? 1 : 0,
            'image' => $this->imageUpload($dto->image),
        ]);
    }

    public function update(string $id, ProductDataTransferObject $dto): Product
    {
        $product = $this->find($id);

        return tap($product)->update([
            'category' => $dto->category,
            'name' => $dto->name,
            'description' => $dto->description,
            'selling_price' => $dto->selling_price,
            'special_price' => $dto->special_price,
            'status' => $dto->status->value,
            'is_delivery_available' => $dto->is_delivery_available ? 1 : 0,
            'image' => $this->imageUpload($dto->image) ?? $product->image,
        ]);
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function findWithAttributes($id)
    {
        return Product::with('attributes')->where('id', $id)->first();
    }

    public function storeAttributes(Product $product, ProductAttributesDataTransferObject $dto)
    {
        try {

            $attributes = [];

            foreach ($dto->product_attributes_ids as $index => $id) {
                $attributes[] = array(
                    'id' => $id,
                    'name' => $dto->product_attributes_names[$index],
                    'attribute_value' => $dto->product_attributes_values[$index],
                );
            }

            $current_attributes = ProductAttribute::where('product_id', $product->id)->get();
            $current_attributes_arr = $current_attributes->toArray();

            if ($current_attributes->count() == 0) {
                foreach ($attributes as $key => $item) {
                    ProductAttribute::create([
                        'product_id' => $product->id,
                        'name' => $item['name'],
                        'attribute_value' => $item['attribute_value'],
                    ]);
                }
            } else if ($current_attributes->count() == count($attributes)) {
                foreach ($attributes as $key => $item) {
                    ProductAttribute::find($current_attributes_arr[$key]['id'])->update([
                        'product_id' => $product->id,
                        'name' => $item['name'],
                        'attribute_value' => $item['attribute_value'],
                    ]);
                }
            } else if ($current_attributes->count() < count($attributes)) {
                foreach ($current_attributes as $key => $item) {
                    ProductAttribute::find($item->id)->update([
                        'product_id' => $product->id,
                        'name' => $attributes[$key]['name'],
                        'attribute_value' => $attributes[$key]['attribute_value'],
                    ]);
                }

                $remainings = array_slice($attributes, $current_attributes->count());

                foreach ($remainings as $key => $item) {
                    ProductAttribute::create([
                        'product_id' => $product->id,
                        'name' => $item['name'],
                        'attribute_value' => $item['attribute_value'],
                    ]);
                }
            } else if ($current_attributes->count() > count($attributes)) {
                $updated_ids = [];

                foreach ($attributes as $key => $item) {
                    ProductAttribute::find($current_attributes_arr[$key]['id'])->update([
                        'product_id' => $product->id,
                        'name' => $item['name'],
                        'attribute_value' => $item['attribute_value'],
                    ]);
                    array_push($updated_ids, $current_attributes_arr[$key]['id']);
                }

                DB::table('product_attributes')->where('product_id', $product->id)->whereNotIn('id', $updated_ids)->delete();
            }
        } catch (\Exception $e) {
            addErrorToLog($e);
        }

    }

    public function delete(string $id)
    {
        $product = $this->find($id);

        if ($product != null) $product->delete();

        ProductAttribute::where('product_id', $id)->delete();
    }
}
