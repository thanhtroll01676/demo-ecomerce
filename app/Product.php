<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attachment[] $attachments
 * @property-read \App\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tag[] $tags
 * @property-read \App\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $content
 * @property int $regular_price
 * @property int $sale_price
 * @property int $original_price
 * @property int $quantity
 * @property string|null $attributes
 * @property string|null $image
 * @property int $user_id
 * @property int $category_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $featured_product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereFeaturedProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereOriginalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereRegularPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUserId($value)
 */
class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'code',
        'content',
        'regular_price',
        'sale_price',
        'original_price',
        'quantity',
        'attributes',
        'image',
        'user_id',
        'category_id',
    ];

    public function category(){
        return $this->belongsTo('App\Category','category_id','id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'product_tag', 'product_id', 'tag_id');
    }

    public function orders(){
        return $this->belongsToMany('App\Order', 'product_order', 'product_id', 'order_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function attachments(){
        return $this->hasMany('App\Attachment', 'product_id', 'id');
    }

    public function comments(){
        return $this->hasMany('App\Comment', 'product_id', 'id');
    }
}
