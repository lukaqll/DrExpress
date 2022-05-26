<?php 
 namespace App\Services;

use App\Models\Historic;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportService extends AbstractService
{
    
    public function getUserReportByRoles(array $roles){

        $group = DB::table("users AS us")
                    ->join('user_roles AS ur', 'ur.id_user', 'us.id')
                    ->join('roles AS r', function($join) use($roles) {
                        $join->on('r.id', 'ur.id_role')
                            ->whereIn('r.slug', $roles);
                    })
                    ->where('us.status', 'A')
                    ->groupByRaw("date_format(us.created_at, '%Y-%m-%d')")
                    ->selectRaw("count(us.id) as total")
                    ->get()
                    ->pluck('total');
 
        $total = 0;
        $groupResult = [];
        foreach($group as $item){
            $total += intval($item);
            $groupResult[] = $total;
        }

        return ['total' => $total, 'chart' => $groupResult];
    }

}