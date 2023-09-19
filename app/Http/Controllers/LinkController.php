<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function post(Request $request){

        $validated = $request->validate([
            'from_url' => 'required',
        ]);

        $randomString = Str::random(7);
        $links = Link::all();

        foreach($links as $v){
            if($randomString == $v->to_url){
                $randomString = Str::random(7);
            }
        }

        Link::create([
            'from_url' => $request->from_url,
            'to_url' => $randomString,
        ]);

        return response()->json(['message' => $randomString], 201);
    }

    public function show($url){
        $links = Link::where('to_url' , $url)->first();

        if (!$links) {
            return response()->json(['message' => 'Link not found'], 404);
        }

        return redirect($links->from_url);
    }
}
