<?php

namespace App\Http\Controllers;

use App\Booking;
use Show;
use Illuminate\Http\Request;
use App\Http\Requests;
use Intervention\Image\Facades\Image;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index()
    {
        $shows = \Show::all()->sortBy('created_at');
        return view('crud/spettacoli.index', array('shows' => $shows));
    }

    /**
     * Show the form for creating a new resource.
     * @return mixed
     */
    public function create()
    {
        return view('crud/spettacoli.create');
    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store(Request $request)
    {

        //validation
        $rules = array(
            'name'              => 'required',
            'full_price'        => 'numeric',
            'half_price'        => 'numeric'
        );

        $validator = \Validator::make($request->all(), $rules);

        if($validator->fails()){

            return redirect('show/create')
                ->withErrors($validator)
                ->withInput($request->all());

        } else {

            $data = $request->all();

            $show = Show::create(
                array(
                    'name'          => $data['name'],
                    'description'   => $data['description'],
                    'places'        => $data['places'],
                    'half_price'    => $data['half_price'],
                    'full_price'    => $data['full_price'],
                    'url'           => strtolower($this->_createUrl($data['name']))
                )
            );

            //check if input has file
            if ($request->hasFile('image')){

                $file = $request->file('image');
                $image_name = $file->getClientOriginalName();

                //store image on server
                $store_path = public_path().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;

                $image = Image::make($request->file('image')->getRealPath());
                $image->resize(680, 960)->save($store_path . $image_name);

                $show->image = $image_name;

            }

            $show->save();

            //redirect
            session('message', 'spettacolo creato correttamente');
            return redirect('show');

        }
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return mixed
     */
    public function show($url)
    {
        //get the selected gig
        /** @var \App\Show $show */
        $show = Show::where('url', '=', $url)->firstOrFail();
        $events = $show->events;

        return view('crud/spettacoli.show',
            array(
                'show'      => $show,
                'events'    => $events
            )
        );
    }


    /**
     * Show the form for editing the specified resource.
     * @param $url
     * @return mixed
     */
    public function edit($url)
    {
        //get the selected gig
        $show = Show::where('url', '=', $url)->firstOrFail();
        return view('crud/spettacoli.edit', array('show' => $show));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($url, Request $request)
    {
        //validate
        $rules = array(
            //rules
            'name'      => 'required',
            'places'    => 'required|numeric'

        );

        $validator = validator($request->all(), $rules);

        if($validator->fails()){

            return redirect('show/'. $url . '/edit')
                ->withErrors($validator);

        } else {

            //save
            $show = Show::whereUrl($url)->firstOrFail();

            if(!$show){
                \Log::error("Impossibile modificare un record inesistente");
                Throw new \Exception("Impossibile modificare un record inesistente");
            }

            $data = $request->all();

            $show->name = $data['name'];
            $show->description = $data['description'];
            $show->places = $data['places'];
            $show->full_price = $data['full_price'];
            $show->half_price = $data['half_price'];
            //URL
            $url = $this->_createUrl($data['url']);
            $show->url = strtolower($url);

            //check if input has file
            if ($request->hasFile('image')){

                $file = $request->file('image');
                $image_name = $file->getClientOriginalName();

                //store image on server
                $store_path = public_path().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR;

                $image = Image::make($request->file('image')->getRealPath());
                $image->resize(680, 960)->save($store_path . $image_name);

                $show->image = $image_name;

            }

            try {
                $show->save();
            } catch (\Exception $ex) {
                \Log::alert("Cannot Update Show: {$ex->getMessage()}");
                return redirect('show', 302, ['message' => "Impossibile aggiornare il record"]);
            }


            //redirect to spettacoli
            session('message', 'spettacolo modificato con successo');
            return redirect('show');

        }

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

        if(!$show){
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

    private function _createUrl($title){

        $url = str_replace(" ", "-", $title);
        $url = str_replace(".", "", $url);

        return $url;
    }


}
