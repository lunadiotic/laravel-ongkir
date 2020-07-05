<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $province = $this->getProvince();
        return view('home', compact('province'));
    }

    public function getProvince()
    {
        $province = Province::pluck('title', 'code');
        return $province;
    }

    public function getCities($provinceId)
    {
        $cities = City::where('province_code', $provinceId)->pluck('title', 'code');
        return json_encode($cities);
    }

    public function searchCities(Request $request)
    {
        $search = trim($request->search);

        if (empty($search)) {
            $cities = City::orderBy('title', 'asc')
                ->select('id', 'title')
                ->limit(5)->get();
        } else {
            $cities = City::orderBy('title', 'asc')
                ->where('title', 'like', '%' . $search . '%')
                ->select('id', 'title')
                ->limit(5)->get();
        }

        $response  = [];

        foreach ($cities as $city) {
            $response[] = ['id' => $city->id, 'text' => $city->title];
        }

        return json_encode($response);
    }
}
