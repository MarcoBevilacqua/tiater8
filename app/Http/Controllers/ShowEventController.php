<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\ShowEvent;
use App\Services\ShowEventService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ShowEventController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('ShowEvents', [
            'events' => ShowEvent::orderBy('show_date')
                ->where('show_id', '=', $request->show)
                ->get()
                ->map(function (ShowEvent $showEvent) {
                    return [
                        'id' => $showEvent->id,
                        'date' => Carbon::createFromTimeString($showEvent->show_date, config('app.timezone'))->format('d F Y'),
                        'time' => Carbon::createFromTimeString($showEvent->show_date)->format('H:i'),
                        'edit' => route('show-events.edit', ['show_event' => $showEvent->id]),
                    ];
                }),
            'show' => Show::where('id', '=', $request->show)->firstOrFail()->title,
            'createLink' => route('show-events.create', ['show_id' => $request->show])
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function edit($id): Response|RedirectResponse
    {
        try {
            $showEvent = ShowEvent::findOrFail($id);
        } catch (\Exception $exception) {
            Log::error("Cannot find event with id {$id}: {$exception->getMessage()}");
            return Redirect::route('show-events.index')->with("error", "Impossibile recuperare i dati");
        }

        return Inertia::render(
            'ShowEvents/Form',
            [
                'show_event' => [
                    'id' => $showEvent->id,
                    'show_id' => $showEvent->show_id,
                    'show_date' => Carbon::createFromTimeString($showEvent->show_date)->format('Y-m-d'),
                    'show_date_time' => Carbon::createFromTimeString($showEvent->show_date)->format('H:i'),
                    'show_title' => $showEvent->show->title
                ],
                'available_times' => ShowEvent::AVAILABLE_TIMES,
                '_method' => 'put'
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('ShowEvents/Create', [
            'shows' => Show::select(['id', 'title'])->get(),
            'show_date' => $request->date,
            'available_times' => ShowEvent::AVAILABLE_TIMES,
            '_method' => 'post'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'show_date' => 'required',
            'show_date_time' => 'required'
        ]);

        try {
            $showEvent = ShowEvent::findOrFail($request->id);
        } catch (\Exception $exception) {
            Log::error("Cannot find show event with id: {$request->id}: {$exception->getMessage()}");
            return Redirect::back()->with("error", "Impossibile aggiornare i dati");
        }

        $completeDate = ShowEventService::createCompleteDate($request->show_date, $request->show_date_time);

        try {
            $showEvent->update(
                ['show_date' => $completeDate]
            );
        } catch (\Exception $exception) {
            Log::error("Cannot save show event: " .  $exception->getMessage());
            return Redirect::back()->with("error", "Impossibile aggiornare i dati");
        }

        return Redirect::route('show-events.index', ['show' => $showEvent->show_id])->with("success", "Dati aggiornati correttamente");
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $showEvent = ShowEvent::findOrFail($id);
        } catch (\Exception $exception) {
            Log::error("Cannot find show event with id {$id}: {$exception->getMessage()}");
            return Redirect::back()->with("error", "Errore nella cancellazione");
        }

        try {
            ShowEvent::destroy($id);
        } catch (\Exception $exception) {
            Log::error("Cannot find show event with id {$id}: {$exception->getMessage()}");
            return Redirect::back()->with("error", "Errore nella cancellazione");
        }

        return Redirect::route('show-events.index', ['show' => $showEvent->show_id])
            ->with("success", "Operazione completata correttamente");
    }

    /**
     * add action function
     * @param Request $request
     * @return RedirectResponse
     */
    protected function store(Request $request): RedirectResponse
    {
        //validation
        $request->validate([
            'show_id' => 'required|numeric',
            'show_date' => 'required',
            'show_date_time' => 'required'
        ]);

        $completeDate = ShowEventService::createCompleteDate($request->show_date, $request->show_date_time);

        try {
            ShowEvent::create([
                'show_id' => $request->show_id,
                'show_date' => $completeDate
            ]);
        } catch (\Exception $ex) {
            Log::error("Cannot save event: {$ex->getMessage()}");
            return Redirect::back()->with("error", "Errore nella elaborazione dei dati");
        }

        return Redirect::route('show-events.index', ['show' => $request->show_id])->with("success", "Data creata correttamente");
    }
}
