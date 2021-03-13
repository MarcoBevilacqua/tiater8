<?php

namespace App\Http\Controllers;

use App\Show;
use Illuminate\Http\Request as Request;
use Viewer;
use Log;


class ViewerController extends Controller
{
    /**
     * @return mixed
     */
    protected function index(){

        $all = Viewer::select(['id', 'first_name', 'last_name', 'email', 'full_name', 'phone', 'sign_date'])
            ->selectRaw('CASE WHEN QUOTA = "N" THEN "da saldare" ELSE "iscritto/a" 
            END as quota')
            ->selectRaw('CASE WHEN QUOTA = "N" THEN "fail" ELSE "success" END as class')
            ->get();

        return view('crud/spettatori.index', array('viewers' => $all));

    }

    /**
     * @return mixed
     */
    protected function create(){
        return view('crud/spettatori.create');
    }

    /**
     * @param $id
     * @return bool
     */
    protected function edit($id){

        /** @var Show $show */
        $viewer = Viewer::findOrFail($id);
        if(!$viewer){
            return false;
        }

        return view('crud/spettatori.edit', array('viewer' => $viewer));

    }

    /**
     *
     */
    public function update(Request $request, \App\Viewer $viewer){

        if(!$viewer){
            return redirect('viewer');
        }

        $data = $request->all();

        $viewer->first_name = $data['first_name'];
        $viewer->last_name = $data['last_name'];
        $viewer->full_name = $data['first_name'] . " " . $data['last_name'];
        $viewer->email = $data['email'];
        $viewer->phone = $data['phone'];
        $viewer->quota = array_key_exists('quota', $data) ? "S" : "N";

        try{
            $viewer->save();
        } catch(Exception $ex){
            Log::error("Cannot Update viewer: {$ex->getMessage()}");
            return redirect('viewer');
        }

        return redirect('/viewer');

    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function store(Request $request){

        //validate
        $rules = array(
            //rules
            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => 'required|email',
            'phone'             => 'required|numeric'
        );

        $viewer = null;
        $data = $request->all();
        $remote = false;

        if(empty($data)){
            return false;
        }

        if(array_key_exists('remote', $data)){
            $remote = $data['remote'] != "";
        }

        $validator = validator ($request->all(), $rules);

        if($validator->fails()){
            return redirect('viewer/create')
                ->withErrors($validator);
        }

        try {
            //instantiate Viewer
            $viewer = new Viewer();

            $viewer->first_name = $data['first_name'];
            $viewer->last_name = $data['last_name'];
            $viewer->email = $data['email'];
            $viewer->full_name = $data['first_name'] . " " . $data['last_name'];
            $viewer->phone = $data['phone'];
            $viewer->quota = array_key_exists('quota', $data) ? "S" : "N";

            $viewer->sign_date = new \DateTime();

            if(!$remote){
                //not remote saving, other info can be retrieved
                $viewer->phone = $data['phone'];
                $viewer->quota = $data['quota'];
            }


            $viewer->save();

        } catch (\Exception $ex){
            Log::info("Cannot save user remotely: {$ex->getMessage()}");
            return false;
        }

        return response(array('success' => true, 'viewer' => $viewer->toJson()));
    }

    protected function destroy(Viewer $viewer){

        if(!$viewer){
            return redirect('viewer');
        }

        if($viewer->hasBookings()) {
            /**
             * TODO: Delete bookings
             */
        }

        try {
            $viewer->delete();
        } catch (\Exception $ex){
            Log::error("Cannot delete viewer {$viewer->id}: {$ex->getMessage()}");
            return redirect('viewer');
        }

        return redirect('viewer');

    }
}
