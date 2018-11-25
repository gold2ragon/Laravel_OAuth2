<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Cache;


class HomeController extends Controller
{

    public $data = array();
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val->$key, $key_array)) { 
                $key_array[$i] = $val->$key; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    } 
    public function get_json($url)
    {
        if (false !== ($content = @file_get_contents($url))) {
            $json = json_decode($content);
            $this->data = $this->unique_multidim_array(array_merge($this->data, $json->data->locations), 'link');
        }
    }
    public function get_list(Request $request)
    {
        return $this->loadfromlocal($request);
    }
    public function updateDB(Request $request)
    {
        // $this->data = $request->session()->get('data');
        $this->data = Cache::get('data');
        $data = $this->data;

        $path = public_path().'/images';

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        
        foreach($this->data as $item)
        {
            Place::firstOrCreate([
                'link'=>isset($item->link) ? $item->link : 'null',
                'name'=>$item->name,
                'address'=>isset($item->address) ? $item->address : 'null',
                'latitude'=>isset($item->latitude) ? $item->latitude : 'null',
                'longitude'=>isset($item->longitude) ? $item->longitude : 'null',
                'duration'=>isset($item->duration) ? $item->duration : 'null',
                'category'=>isset($item->category) ? $item->category : 'null',
                'rating'=>isset($item->rating) ? $item->rating : 'null',
                'rating_count'=>isset($item->rating_count) ? $item->rating_count : 'null',
                'price'=>isset($item->price) ? $item->price : 'null',
                'description'=>isset($item->description) ? $item->description : 'null',
                'image_url'=>isset($item->image) ? $item->image : (isset($item->image_thumb) ? $item->image_thumb : 'null'),
            ]);
            $path = isset($item->image) ? $item->image : (isset($item->image_thumb) ? $item->image_thumb : 'null');

            if($path != null && strpos($path, 'localhost') === false)
            {
                $filename = basename($path);
                Image::make($path)->save(public_path('images/' . $filename));
            }
        }
        Cache::forget('data');
        return 'Saving data to Database successfully!';
    }
    public function loadfromlocal(Request $request)
    {
     
        $places = Place::all();
        foreach($places as $place)
        {
            $filename = basename($place->image_url);
            $place->image = url('images/' . $filename);
        }
        $data['items'] = $places;

        return view('lists', $data);
    }
    public function checkAPI(Request $request)
    {     

        // $this->get_json('http://dev.sccb.ac.uk/places/uk-london-fsq.json');
        // $this->get_json('http://dev.sccb.ac.uk/places/uk-london-via.json');
        // $this->get_json('http://dev.sccb.ac.uk/places/uk-london-timeout.json');
        // $this->get_json('http://dev.sccb.ac.uk/places/usa-nycny-fsq.json');
        // $this->get_json('http://dev.sccb.ac.uk/places/usa-nycny-via.json');
        // $this->get_json('http://dev.sccb.ac.uk/places/usa-nycny-timeout.json');

        $this->get_json('https://content-api.hiltonapps.com/v1/places/top-places/uk-london-fsq?access_token=jobs383-UgWfVvxQXNhDQLw4v');
        $this->get_json('https://content-api.hiltonapps.com/v1/places/top-places/london-uk-timeout?access_token=jobs383-UgWfVvxQXNhDQLw4v');
        $this->get_json('https://content-api.hiltonapps.com/v1/places/top-places/london-uk-timeout?access_token=jobs383-UgWfVvxQXNhDQLw4v');
        $this->get_json('https://content-api.hiltonapps.com/v1/places/top-places/usa-nycny-fsq?access_token=jobs383-UgWfVvxQXNhDQLw4v');
        $this->get_json('https://content-api.hiltonapps.com/v1/places/top-places/usa-nycny-via?access_token=jobs383-UgWfVvxQXNhDQLw4v');
        $this->get_json('https://content-api.hiltonapps.com/v1/places/top-places/new-york-ny-usa-timeout?access_token=jobs383-UgWfVvxQXNhDQLw4v');


        $start = microtime(true);	
		$result = Cache::put('data', $this->data, 10);
		$duration = (microtime(true)-$start) * 1000;
        \Log::info('With cahche from API: '.$duration.' ms.');


        $data['items'] = $this->data;
        // $request->session()->put('data', $this->data);
        // Cache::put('data', $this->data, 10);


        return view('lists', $data);
    }
}
