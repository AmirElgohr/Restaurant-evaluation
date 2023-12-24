<?php
namespace App\Http\Controllers\Dashboards\DashboardRestaurant\User\Profile;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetInfoController extends Controller
{
    public function getUser(Request $request)
    {
        try {
            $user = $request->user('restaurant');
            return finalResponse('success', 200, $user);
        } catch (Exception $e) {
            return finalResponse('faield', 400, null, null, $e->getMessage());
        }
    }
}

?>
