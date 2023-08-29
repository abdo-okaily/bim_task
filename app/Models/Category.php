<?php

namespace App\Models;

use App\Models\Product;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use HasFactory,HasTranslations,SoftDeletes,InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'level',
        'is_active',
        'order'
    ];

    /**
     * The attributes that needs to be translated.
     *
     * @var array
     */
    public $translatable = ['name','slug'];

    /**
     * Append Attributes to the orm collection.
     *
     * @var array
     */
    public $appends = [
        "parent_category_name_ar",
        "parent_category_name_en",
        "image_url",
        "image_url_thumb"
    ];

    /**
     * Casts Datatypes.
     *
     * @var array
     */
    public $casts = [
        'is_active' => "boolean"
    ];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function ($category) {
          $children =  $category->child();
          foreach( $children->get() as  $sub_children)
          { 
            $sub_children->child()->delete();
          }
          $children->delete();
        });
      }

    /**
     * Add spatie media library conversions.
     *
     * @param Media|null $media
     * @return void
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('cover')
            // ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();
            
            
        $this->addMediaConversion('thumb')
            // ->format(Manipulations::FORMAT_WEBP)
            ->width(160)
            ->height(100)
            ->nonQueued();
    }

    /**
     * Get list of products assossiated to this category.
     * @hint: must be deleted
     * @return HasMany
     */
    public function products() : HasMany
    {
        return $this->HasMany(Product::class);
    }

    public function hasProducts()
    {
        return Product::where(
            fn($q) => $q->where('category_id', $this->id)
                ->orWhere('sub_category_id', $this->id)
                ->orWhere('final_category_id', $this->id)
        )
        ->exists();
    }

    /**
     * Return the parent category.
     *
     * @return BelongsTo
     */
    public function parent() : BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get list of category childs.
     *
     * @return HasMany
     */
    public function child() : HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function categoryProduct() {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function subCategoryProduct() {
        return $this->hasMany(Product::class, 'sub_category_id');
    }

    public function finalCategoryProduct() {
        return $this->hasMany(Product::class, 'final_category_id');
    }

    /**
     * return the parent category arabic name depend on the locale.
     *
     * @return mixed
     */
    public function getParentCategoryNameArAttribute() : mixed
    {
        if(empty($this->parent_id) || empty($this->parent)) {
            return trans('admin.categories.not_found');
        }

        return $this->parent->getTranslation('name', 'ar');
    }

    /**
     * return the parent category english name depend on the locale.
     *
     * @return mixed
     */
    public function getParentCategoryNameEnAttribute() : mixed
    {
        if(empty($this->parent_id) || empty($this->parent)) {
            return 0;
        }

        return $this->parent->getTranslation('name', 'en');
    }

    /**
     * return the category image full url.
     *
     * @return string
     */
    public function getImageUrlAttribute() : string
    {
        if(!empty($this->media->first())) {
            return $this->getFirstMediaUrl('categories', 'cover');
        }
        return url("images/noimage.png");
    }

    /**
     * return the category image thumb url.
     *
     * @return string
     */
    public function getImageUrlThumbAttribute() : string
    {
        if(!empty($this->media->first())) {
            return $this->getFirstMediaUrl('categories', 'thumb');
        }
        return url("images/noimage-tumb.png");
    }

    public function getUniqueIdentifier() {
        return "$this->id-$this->slug_en";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope that make count query over sub-categories.
     *
     * @return integer
     */
    public function scopeSubCategoriesCount() : int
    {
        return $this->child()->count();
    }
}
