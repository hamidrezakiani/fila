<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        return BannerResource::collection(Banner::all());
    }

    public function store(BannerRequest $request)
    {
        return new BannerResource(Banner::create($request->validated()));
    }

    public function show(Banner $banner)
    {
        return new BannerResource($banner);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $banner->update($request->validated());

        return new BannerResource($banner);
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json();
    }
}
