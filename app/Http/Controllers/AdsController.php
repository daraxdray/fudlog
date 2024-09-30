<?php
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 14/01/2021 - AdsController.php
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Advertisements;

class AdsController extends Controller
{
    public function index()
    {
        $data = Advertisements::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('frontend.user.user_ads', compact('data'));
    }

    public function adminIndex()
    {
        $data = Advertisements::all();
        return view('backend.marketing.advertisement', compact('data'));
    }

    public function addNew(Request $request)
    {
        if ($request->banner_ads_image == null || $request->banner_ads_url == null) {
            flash(translate('No new adverts data to be created / submitted'))->error();
            return redirect()->route('seller.user.ads');
        }
        //insert new to admin panel...
        $advertisement = new Advertisements;
        $advertisement->user_id = Auth::user()->id;
        $advertisement->banner_url = $request->banner_ads_url;
        $advertisement->banner = $request->banner_ads_image;
        $advertisement->save();
        flash(translate('New Adverts request created successfully'))->success();
        return redirect()->route('seller.user.ads');
    }

    public function delete(Request $request, $id)
    {
        $ads = Advertisements::findOrFail($id);
        if ($ads) {
            $ads->delete();
        }
        flash(translate('Advertisement deleted !'))->success();
        return redirect()->route('seller.user.ads');
    }

    public function check(Request $request, $id)
    {
        $ads = Advertisements::findOrFail($id);
        if ($ads->id!==0) {
            $ads->status = ($ads->status === 1 ? 0 : 1);
            $ads->save();
            flash(translate('Successful !'))->success();
        }
        return redirect()->route('admin.advertisement');
    }
}