<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Support\Facades\URL;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::where('status', 1)->orderBy('ordering')->get();

        $blocks->transform(function ($block) {
            $imageArray = json_decode($block->image, true);
            if (is_array($imageArray)) {
                $block->image = array_map(function ($img) {
                    return URL::to('/uploads/blocks/' . $img);
                }, $imageArray);
            } else {
                $block->image = [];
            }

            $block->features = json_decode($block->features, true) ?? [];

            return $block;
        });

        return response()->json($blocks);
    }
    public function showByIdentifier($identifier)
    {
        $block = Block::where('identifier', $identifier)->where('status', 1)->first();

        if (!$block) {
            return response()->json(['message' => 'Block not found'], 404);
        }

        $imageArray = json_decode($block->image, true);
        if (is_array($imageArray)) {
            $block->image = array_map(function ($img) {
                return URL::to('/uploads/blocks/' . $img);
            }, $imageArray);
        } else {
            $block->image = [];
        }

        $block->features = json_decode($block->features, true) ?? [];

        return response()->json($block);
    }
}
