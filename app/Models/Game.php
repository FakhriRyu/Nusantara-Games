<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['cover','title','release_date','price','category_id','developer_id'];

    protected $primarykey = ['id'];

    public $incrementing = true;

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function developer(): BelongsTo{
        return $this->belongsTo(Developer::class);
    }

    public function getncategoryname(){
        $category = Category::join('categories', 'category_id', '=', 'categories.category_id')
        ->where('categories.id',$this->id)
        ->first();

        return $category ? $category->category_name : null ;
    }

    public function getdevelopername(){
        $developer = Developer::join('developers', 'developer_id', '=', 'developers.developer_id')
        ->where('developers.id',$this->id)
        ->first();

        return $developer ? $developer->developer_name : null ;
    }
}
