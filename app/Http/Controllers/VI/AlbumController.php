<?php

namespace App\Http\Controllers\VI;

use App\Http\Controllers\Controller;
use App\Http\Resources\VI\AlbumResource;
use App\Models\Album;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return AlbumResource::collection(Album::where('user_id', $request->user()->id)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAlbumRequest  $request
     * @return AlbumResource
     */
    public function store(StoreAlbumRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        return new AlbumResource(Album::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param \App\Models\Album $album
     * @return AlbumResource
     */
    public function show(Request $request, Album $album)
    {
        if($album->user_id !== $request->user()->id){
            abort(403, 'Unauthorized action');
        }
        return new AlbumResource($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlbumRequest  $request
     * @param  \App\Models\Album  $album
     * @return AlbumResource
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        if ($album->user_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        $album->update($request->all());
        return new AlbumResource($album);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Album $album)
    {
        if ($album->user_id !== $request->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        $album->delete();
        return response('', 204);
    }
}
