<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 12/01/2017
 * Time: 14:40
 */

namespace App\Observers;

use App\ShowEvent;
use App\Show;

class ShowEventObserver
{

    public function saved(ShowEvent $showEvent){

        /** @var Show $show */
        $show = Show::findOrFail($showEvent->show_id);

        if($show && (($showEvent->full_price_qnt == 0) || ($showEvent->half_price_qnt == 0))){
            \Log::info("No places for event, getting from show");
            //if show exists and places are not set in the form
            $showEvent->full_price_qnt = $show->full_price_qnt;
            $showEvent->half_price_qnt = $show->half_price_qnt;
            $showEvent->total_qnt = $show->total_qnt;
        }

    }

}