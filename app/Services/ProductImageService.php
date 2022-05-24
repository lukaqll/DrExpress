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

    public function removeImage(Product $product, int $id){

        $image = $this->find($id);

        if($image->id_product != $product->id)
            $this->throwException("Falha ao remover imagem do produto");

        $totalImages = $this->list(['id_product' => $product->id]);
        if( count($totalImages) < 2 )
            $this->throwException("Este produto não pode ficar sem imagens. Adicione outra para que possa remover esta");

        $removed = Storage::disk('public')->delete($image->src);
        if($removed){
            $this->deleteById($id);
        } else {
            $this->throwException("Falha ao remover imagem");
        }

        // next image as principal
        if( !!$image->is_principal ){
            $nextImage = $this->get(['id_product' => $product->id]);
            $nextImage->update(['is_principal' => 1]);
        }

        return true;

    }

    
    public function setPrincipalImage(Product $product, int $id){

        $image = $this->find($id);

        if($image->id_product != $product->id)
            $this->throwException("Falha ao alterar imagem do produto");

        ProductImage::where('id_product', $product->id)->update(['is_principal' => 0]);
        $image->update(['is_principal' => 1]);

        return true;

    }

}