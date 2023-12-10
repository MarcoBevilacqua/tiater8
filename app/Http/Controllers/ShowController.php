<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Services\ShowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index()
    {
        return Inertia::render('Shows', [
            'shows' => Show::select(['id', 'title', 'description'])
                ->withCount('events')
                ->orderByDesc('id')
                ->get()
                ->map(function (Show $show) {
                    return [
                        'id' => $show->id,
                        'title' => $show->title,
                        'description' => Str::limit($show->description, 120),
                        'dates' => $show->events_count,
                        'edit' => route('shows.edit', ['show' => $show->id]),
                        'add_date' => route('show-events.index', ['show' => $show->id])
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
            'title' => 'required',
            'full_price' => 'required'
        ]);

        //check if input has file
        if ($request->hasFile('image')) {
            ShowService::saveImage($request->file('image'));
        }

        try {
            Show::create(
                [
                    'title' => $request->title,
                    'description' => $request->description ?? "",
                    'url' => $request->url ?? "",
                    'full_price' => $request->full_price,
                    'half_price' => $request->half_price ?? 0,
                    'places' => 50,
                    'image' => $request->hasFile('image') ?
                        asset('/img/' . $request->file('image')->getClientOriginalName()) :
                        ""
                ]
            );
        } catch (\Exception $exception) {
            Log::error("Cannot create show: {$exception->getMessage()}");
            return Redirect::back()->with("error", "Errore durante l'elaborazione");
        }

        return Redirect::route('shows.index')->with("success", "Operazione completata con succcesso");
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
            '_method' => 'put',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //validate
        $request->validate(
            ['title' => 'required',
                'description' => 'required']
        );

        try {
            $show = Show::findOrFail($request->id);
        } catch (\Exception $ex) {
            Log::error("Cannot find show with id {$request->id}");
            return Redirect::back()->with("error", "Impossibile aggiornare i dati");
        }

        //check if input has file
        if ($request->hasFile('image')) {
            //call service method
            ShowService::saveImage($request->file('image'));
        }

        try {
            $show->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'url' => $request->url ?? "",
                    'full_price' => $request->full_price,
                    'half_price' => $request->half_price,
                    'image' => $request->hasFile('image') ?
                        asset('/img/' . $request->file('image')->getClientOriginalName()) :
                        $show->image
                ]
            );
        } catch (\Exception $ex) {
            Log::error("Cannot Update Show: {$ex->getMessage()}");
            return Redirect::route('shows.index')->with("error", "Impossibile aggiornare il record");
        }

        return Redirect::route('shows.index')->with("success", "Dati aggiornati correttamente");
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        //delete
        try {
            Show::findOrFail($id)->delete();
        } catch (\Exception $exception) {
            Log::error("Cannot delete show with id {$id}: {$exception->getMessage()}");
            return Redirect::route('shows.index')->with("error", "Impossibile cancellare lo spettacolo");
        }

        return Redirect::route('shows.index')->with('success', "Dati eliminati correttamente");
    }
}
