<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;
use App\Services\ShowService;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index()
    {
        return Inertia::render('Shows', [
            'shows' => Show::orderByDesc('created_at')
            ->get()
            ->map(function (Show $show) {
                return [
                    'id' => $show->id,
                    'title' => $show->title,
                    'description' => Str::limit($show->description, 100),
                    'edit' => route('shows.edit', ['show' => $show->id])
                ];
            }),
            'createLink' => URL::route('shows.create')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return mixed
     */
    public function create()
    {
        return Inertia::render('Shows/Create', [
            '_method' => 'post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'url' => 'required|url'
        ]);

        //check if input has file
        if ($request->hasFile('image')) {
            ShowService::saveImage($request->file('image'));
        }

        Show::create(
            [
            'name'          => $request->title,
            'description'   => $request->description,
            'url'           => $request->url,
            'image' => $request->hasFile('image') ?
                asset('/img/' . $request->file('image')->getClientOriginalName()) :
                ""
            ]
        );

        //redirect
        session('message', 'spettacolo creato correttamente');
        return redirect('shows');
    }


    /**
     * Show the form for editing the specified resource.
     * @param $url
     * @return mixed
     */
    public function edit($id)
    {
        //get the selected gig
        $show = Show::findOrFail($id);
        return Inertia::render('Shows/Form', [
            'show' => $show,
            '_method'  => 'put',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //validate
        $request->validate(
            ['name' => 'required',
            'description' => 'required',
            'url' => 'required|url']
        );

    
        try {
            $show = Show::findOrFail($request->id);
        } catch (\Exception $ex) {
            Log::error("Cannot find show with id {$request->id}");
            return Redirect::route('shows.edit', ['id' => $request->id])
        ->with('errors', "Show not found");
        }

        /** TODO: move this data into event */
        /**
        $show->places = $data['places'];
        $show->full_price = $data['full_price'];
        $show->half_price = $data['half_price'];
        */

        //check if input has file
        if ($request->hasFile('image')) {
            //call service method
            ShowService::saveImage($request->file('image'));
        }

        $show->update(
            ['name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'image' => $request->hasFile('image') ?
                asset('/img/' . $request->file('image')->getClientOriginalName()) :
                $show->image
            ]
        );


        try {
            $show->save();
        } catch (\Exception $ex) {
            \Log::alert("Cannot Update Show: {$ex->getMessage()}");
            return redirect('shows.index', 302, ['message' => "Impossibile aggiornare il record"]);
        }

        //redirect to spettacoli
        session('message', 'spettacolo modificato con successo');
        return redirect('shows');
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return mixed
     */
    public function destroy($url)
    {
        //delete
        $show = Show::where("url", "=", $url);

        if (!$show) {
            return redirect($this->getRedirectUrl());
        }

        try {
            $show->delete();
        } catch (Exception $ex) {
            \Log::error("Cannot delete show");
            return redirect($this->getRedirectUrl());
        }

        //redirect
        session('message', 'spettacolo eliminato');
        return redirect('show');
    }
}
