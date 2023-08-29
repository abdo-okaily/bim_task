<?php

namespace App\Observers;

use App\Enums\SettingEnum;
use App\Models\Country;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param Product $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the Product "creating" event.
     *
     * @param Product $product
     * @return void
     */
    public function creating(Product $product)
    {
        $product->sku = "SD". rand(10000000, 99999999);
        return $product;
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param Product $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the Product "updating" event.
     *
     * @param Product $product
     * @return void
     */
    public function updating(Product $product)
    {
        if (!$product->sku) {
            $product->sku = "SD". rand(10000000, 99999999);
        }
        return $product;
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param Product $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param Product $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }

    public function saved(Product $product) {
        // the next line must be linked from front end (admin panel or vendor panel)
        // this is just a workarround
        $country = Country::where(fn($q) => $q->where('code', 'sa')->where('code', 'SA'))->first();
        
        $vatPercentage = $country ? $country->vat_percentage : (Setting::where('key', SettingEnum::vat)->first()->value ?? 0);
        $priceWithVat = $product->price;
        $priceWithoutVat = $priceWithVat * 1 / (1 + $vatPercentage / 100);
        
        $priceData = [
            "product_id" => $product->id,
            "country_id" => $country->id ?? null,
            "vat_percentage" => $vatPercentage,
            "vat_rate_in_halala" => $priceWithVat - $priceWithoutVat,
            "price_without_vat_in_halala" => $priceWithoutVat,
            "price_with_vat_in_halala" => $priceWithVat,
        ];
        // TODO: its just a workaround till international prices
        $priceExists = $product->prices()->first();
        if ($priceExists) $priceExists->update($priceData);
        else $product->prices()->create($priceData);
    }
}
