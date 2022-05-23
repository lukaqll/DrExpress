<?php 
 namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductImage;       
    }

    public function uploadImage(Product $product, $file, $isPrincipal=false){

        $fileName = Storage::disk('public')->put('products_images', $file);

        if( !empty($fileName) ){
            $product->images()->create([
                'src' => $fileName,
                'is_principal' => $isPrincipal?1:0
            ]);
        }

        return $fileName;
    }

}