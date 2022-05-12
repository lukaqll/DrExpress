<?php 

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FillTableFields extends Controller
{

    public function do( Request $request )
    {
        
        $tables = [ 'adresses', 'brands', 'cart_items', 'carts', 'categories', 'cities', 'districts', 'historic', 'orders', 'password_recovery', 'payment_methods', 'permissions', 'product_images', 'product_specs', 'products', 'role_permissions', 'roles', 'served_districts', 'spec_items', 'specs', 'stock_log', 'ufs', 'user_payment_methods', 'user_roles', 'users' ];

        foreach($tables as $table){

            echo "<br>protected \$table = '{$table}';";
            echo "<br>protected \$primaryKey = 'id';";
            echo "<br><br>protected \$fillable = [";

            $timestamps = false;

            $result = DB::select("SHOW COLUMNS FROM $table;");
            foreach( $result as $item ){
                echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;'$item->Field',";
                if( $item->Field == 'created_at' )
                    $timestamps = true;
            }

            echo "<br>];";

            if( !$timestamps ){
                echo "<br><br>public \$timestamps = false;";
            }

            echo "<br> --------------- <br>";

            // dd($result);
        }
    }
}