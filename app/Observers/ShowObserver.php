<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 09/01/2017
 * Time: 17:41
 */

namespace App\Observers;
use App\Show as Show;
use Intervention\Image\Facades\Image;
use File;
use Log;

class ShowObserver
{

    private $sizesDirectories = array(
        'x-small'   => '180x240',
        'small'     => '240x360',
        'medium'    => '360x480',
        'large'     => '680x960'
    );

    public function creating(Show $show){

        //check if url is already taken
        $existing = Show::whereUrl($show->url)->count();
        if($existing > 0){
            //a show with same url exists, updating
            $show->url = $show->url.'-'.($existing);
        }
    }

    //after updating or creating a show,
    public function saved(Show $show){

        //managing images
        if(!$show->getOriginal('image') || ($show->getOriginal('image') != $show->image)){

            try{
                //got to update image
                $this->showImageManagement($show->image);
            } catch (\Exception $ex){
                Log::alert("Cannot udpate image for show {$show->name}");
                Log::error("Error: {$ex->getMessage()}");
                return false;
            } finally {
                Log::debug("image updated");
            }

        }

        return redirect('show');

    }

    private function showImageManagement($image){

        Log::info("Start: " . $image);

        if($image){

            $realPath = public_path().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$image;

            foreach ($this->sizesDirectories as $size => $directory){

                $store_path = public_path()
                    .DIRECTORY_SEPARATOR
                    .'img'
                    .DIRECTORY_SEPARATOR
                    .$directory
                    .DIRECTORY_SEPARATOR
                ;

                Log::info("Managing img dir: {$store_path}");

                if(!File::exists($store_path))
                {
                    Log::debug("Creating dir: {$store_path}");
                    mkdir($store_path, 777);
                }

                $realImage = Image::make($realPath);
                $sizeArray = explode("x", $directory);
                $realImage->resize($sizeArray[0], $sizeArray[1])->save($store_path . $image);

            }

        } else {
            Log::error("Image {$image} does not exists");
            return false;
        }

        return $image;

    }

}