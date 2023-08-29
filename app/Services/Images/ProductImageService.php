<?php
namespace App\Services\Images;

use App\Models\Product;
use App\Models\ProductImage;

class ProductImageService {

    /**
     * Undocumented function
     *
     * @param Product $product
     * @return void
     */
    public function handleImages(Product $product)
    {
    
        $product->images->each(
            fn($productImage) => $this->handleProductImages($productImage)
        );
        $this->handleProductImage($product);
    }

    /**
     * Undocumented function
     *
     * @param Product $product
     * @return void
     */
    private function handleProductImage(Product $product) {
        $product->clearMediaCollection(Product::mediaCollectionName);
        // if ($product->is_image_not_convertable) return;
        $product
            ->addMediaFromDisk($product->image, 'root-public')
            ->preservingOriginal()
            ->toMediaCollection(Product::mediaCollectionName);
    }

    /**
     * Undocumented function
     *
     * @param ProductImage $productImage
     * @return void
     */
    private function handleProductImages(ProductImage $productImage) {
        $productImage->media()?->delete();
        // if ($productImage->is_image_not_convertable) return;
        $productImage
            ->addMediaFromDisk($productImage->image, 'root-public')
            ->preservingOriginal()
            ->toMediaCollection(ProductImage::mediaCollectionName);
    }
}