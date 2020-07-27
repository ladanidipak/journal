<?php
/**
 * User: pritesh
 * Date: 20/12/15
 * Time: 1:04 PM
 */

namespace backend\components;
use backend\components\GDText\Box;
use backend\components\GDText\Color;

class PritWriteImage
{
    public $font_name;
    public $font_spacing = 30;
    public $quality = 100;
    public $imageWidth;
    public $imageHeight;
    public $imageObject;
    public $inputPath;
    public $outputPath;
    public $textArray;


    public function __construct($data){
        $this->font_name = DOCPATH.'/uploads/certificate/times_bold.ttf';
        $this->inputPath = $data['inputPath'];
        $this->outputPath = $data['outputPath'];
        $this->textArray = $data['text'];
        $this->imageObject = imagecreatefromjpeg($this->inputPath);
        $this->imageWidth = imagesx($this->imageObject);
        $this->imageHeight = imagesy($this->imageObject);
    }
    public function create_image()
    {
        $user = $this->textArray;


        $quality = $this->quality;
        $file = $this->outputPath;

        if (true || !file_exists($file)) {
            $im = $this->imageObject;

            // loop through the array and write the text
            foreach ($user as $value) {
                $font_name = $this->font_name;
                $i = $this->font_spacing;
                if(empty($value['color'])){
                    $value['color'] = [0,0,0];
                }
                if(!empty($value['font_spacing'])){
                    $i = $value['font_spacing'];
                }
                if(empty($value['angle'])){
                    $value['angle'] = 0;
                }
                $x = $value['x'];
                $y = $value['y'];
                $color = imagecolorallocate($im, $value['color'][0], $value['color'][1], $value['color'][2]);
                $font_name = empty($value['font'])?$font_name:$value['font'];
                if($x == 'center'){
//                    $box = new Box($im);
//                    $box->setFontFace($font_name);
//                    $box->setFontSize($value['font_size']);
//                    $box->setFontColor(new Color($value['color'][0], $value['color'][1], $value['color'][2]));
//                    //$box->setTextShadow(new Color(0, 0, 0, 50), 0, -2);
//                    $box->setBox(0, $y+$i, $this->imageWidth, $value['font_size']);
//                    $box->setTextAlign('center', 'top');
//                    $box->setBackgroundColor(new Color(255, 86, 77));
//                    $box->draw($value['name']);
                    $x = $this->center_text($value['name'], $value['font_size'],$value['angle']);
                }else{

                }

                $writeText = imagettftext($im, $value['font_size'], 0, $x, $y + $i, $color, $font_name, $value['name']);
                //ob_clean();echo "<pre>".print_r($writeText,true);exit;
                // add 32px to the line height for the next text block
                $i = $i + 32;

            }
            // create the image
            imagejpeg($im, $file, $quality);

        }

        return $file;
    }

    public function center_text($string, $font_size, $angle = 0)
    {
        $font_name = $this->font_name;
        $image_width = $this->imageWidth;
        $dimensions = imagettfbbox($font_size, $angle, $font_name, $string);
        if($font_size == 75) {
           // ob_clean();echo "<pre>".print_r([$image_width,$dimensions],true);exit;
        }
        return ceil(($image_width - (abs($dimensions[4])-abs($dimensions[0]))) / 2);
    }

}