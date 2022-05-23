<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_user',
        'id_category',
        'name',
        'description',
        'brand',
        'color',
        'model',
        'price',
        'slug',
        'guarantee',
        'created_at',
        'updated_at',
    ];

    public function images(){
        return $this->hasMany(ProductImage::class, 'id_product');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'id_category');
    }

    public function specs(){
        return $this->belongsToMany(Spec::class, 'product_specs', 'id_product', 'id_spec');
    }

    public function defaultImages(){
        $images = $this->images;
        foreach($images as &$file){
            $fileExists = Storage::disk('public')->exists($file->src);
            if( $fileExists ){
                $file->src = '/storage/'.$file->src;
            } else {
                $file->src = '/defaultImages/default-product.jpg';
            }
        }
        return $images;
    }

    public function principalImage(){

        $images = $this->images;
        if( empty($images) || count($images) == 0 )
            return '/defaultImages/default-product.jpg';
        
            
        $principal = $this->images->where('is_principal', 1)->first();
        $file = null;
        if( !empty($principal) ){
            $file = $principal->original;
        } else {
            $file = $this->images->first()->original;
        }
        
        $fileExists = Storage::disk('public')->exists($file['src']);
        if($fileExists)
            return '/storage/'.$file['src'];

        return '/defaultImages/default-product.jpg';

    }

    public function getAmount(){
        
        $result = DB::select("
            select 
                sum(
                    if(type = 'E', amount, -amount)
                ) as amount
            from
                stock_log
            where 
                id_product = :id_product
        ", [
            ':id_product' => $this->id
        ]);

        $log = collect($result)->first();
        if(empty($log))
            return 0;
        
        return floatval($log->amount);
    }

    public function getCategoryFlow(){

        $flow = [];

        $category = $this->category;
        $flow[] = $category->name;
        while( !empty( $category->parent ) ){
            $flow[] = $category->parent->name;
            $category = $category->parent;
        }

        return array_reverse($flow);
    }

    public function getSpecs(){

        $specs = $this->specs;

        foreach( $specs as &$spec ){

            $productSpecItems = DB::select("
                select psi.* from
                    spec_items si
                join product_specs ps
                    on ps.id_product = :id_product
                    and ps.id_spec = :id_spec
                join product_spec_items psi
                    on psi.id_product_spec = ps.id
                group by psi.id
            ", [
                ':id_product' => $this->id,
                ':id_spec' => $spec->id
            ]);

            $spec->productSpecItems = $productSpecItems;
        }

        return $specs;
    }
}
