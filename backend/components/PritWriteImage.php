<?php
/**
 * User: pritesh
 * Date: 20/12/15
 * Time: 1:04 PM
 */

namespace backend\components;


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
                    $x = $this->center_text($value['name'], $value['font_size'],$value['angle']);
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
        return ceil(($image_width - $dimensions[4]) / 2);
    }

}