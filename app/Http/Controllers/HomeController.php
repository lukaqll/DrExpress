<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * get home data report
     */
    public function adminHome(){

        $this->hasRole(['admin', 'operator']);
        try {

            $operators = $this->reportService->getUserReportByRoles(['admin', 'operator']);
            $sellers = $this->reportService->getUserReportByRoles(['seller']);
            $clients = $this->reportService->getUserReportByRoles(['client']);

            $result = [
                'operators' => $operators,
                'sellers' => $sellers,
                'clients' => $clients,
            ];

            $response = [ 'status' => 'success', 'data' => ($result) ];

        } catch (ValidationException $e) {
            $response = [ 'status' => 'error', 'message' => $e->errors() ];

        }
        return response()->json( $response );

    }

}
