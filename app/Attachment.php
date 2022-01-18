<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Attachment
 *
 * @property-read \App\Product $product
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $mime
 * @property string $path
 * @property int|null $product_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attachment whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attachment whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attachment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attachment whereUpdatedAt($value)
 */
class Attachment extends Model
{
    protected $fillable = [
        'type',
        'mime',
        'path',
        'product_id',
    ];

    public function product(){
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
