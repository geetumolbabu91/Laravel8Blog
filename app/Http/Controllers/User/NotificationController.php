<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Subscribers;
use Auth;
class NotificationController extends Controller
{
    function getNotification(){
        $status =0 ;
        $ldate = date('Y-m-d');
        $user_id=Auth::guard('web')->user()->id;
        $is_photo_uploaded = Subscribers::where('user_id', $user_id)->value('image_path');
        if(!empty ( $is_photo_uploaded )){
            $response = Http::get('https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos?earth_date='.$ldate.'&api_key=mBdROe2Z8x8XNbdkbeQxFhux0fAUUqPmBh434lY6');
            $response = json_decode(($response), true);
            
            $is_photo_uploaded = Subscribers::where('user_id', $user_id)->pluck('image_path');

            if(count($response['photos']) > 0)
            {
                $status =1;
            }
           
    }
        return $status;
    }
}
