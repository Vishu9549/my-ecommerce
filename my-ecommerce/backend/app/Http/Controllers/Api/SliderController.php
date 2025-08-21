<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        $sliders->transform(function ($slider) {
            $slider->image = $slider->image
                ? URL::to('/uploads/sliders/' . $slider->image)
                : null;
            return $slider;
        });

        return response()->json($sliders);
    }
    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        return response()->json($slider);
    }
}
