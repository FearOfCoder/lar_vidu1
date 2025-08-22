<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name','description','price','quantity','features','category_id','image'
    ];

    public function category() { return $this->belongsTo(Category::class); }

    // URL ảnh an toàn (có placeholder khi thiếu)
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            // ví dụ image = "products/abc.jpg"
            return asset('storage/'.$this->image);
        }
        // ảnh dự phòng (tạo file public/images/placeholder.jpg)
        return asset('images/placeholder.jpg');
    }
}
