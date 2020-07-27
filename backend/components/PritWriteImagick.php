<?php
/**
 * User: pritesh
 * Date: 20/12/15
 * Time: 1:04 PM
 */

namespace backend\components;


class PritWriteImagick
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
        $this->imageObject = new \Imagick($this->inputPath);
        $this->imageWidth = $this->imageObject->getImageWidth();
        $this->imageHeight = $this->imageObject->getImageHeight();
    }
    public function create_image()
    {
        $user = $this->textArray;


        $quality = $this->quality;
        $file = $this->outputPath;
        $success = false;
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

                $font_name = empty($value['font'])?$font_name:$value['font'];

                $draw = new \ImagickDraw();
                $draw->setFont($font_name);
                $draw->setFontSize($value['font_size']);
                $fillColor = new \ImagickPixel();
                $rgb = implode(',',$value['color']);
                $fillColor->setColor("rgb({$rgb})");

                $draw->setFillColor($fillColor);
                if($x == "center"){
                    $draw->setTextAlignment(\Imagick::ALIGN_CENTER);
                    $xPos = $this->imageWidth/2;
                }else{
                    $draw->setTextAlignment(\Imagick::ALIGN_CENTER);
                    $xPos = $x;
                }
                if(is_array($value['name'])){
                    foreach($value['name'] as $vName){
                        $metrics = $im->queryFontMetrics($draw,$vName['name']);
                        while($metrics['textWidth'] > $this->imageWidth){
                            $value['font_size'] -= 10;
                            $draw->setFontSize($value['font_size']);
                            $metrics = $im->queryFontMetrics($draw,$vName['name']);
                        }
                    }
                    foreach($value['name'] as $vName){
                        $y = $vName['y'];
                        $draw->annotation($xPos, $y+$i, $vName['name']);
                    }
                }else{
                    $y = $value['y'];
                    $metrics = $im->queryFontMetrics($draw,$value['name']);
                    while($metrics['textWidth'] > $this->imageWidth){
                        $value['font_size'] -= 10;
                        $draw->setFontSize($value['font_size']);
                        $metrics = $im->queryFontMetrics($draw,$value['name']);
                    }
                    $draw->annotation($xPos, $y+$i, $value['name']);
                }

                $im->drawImage($draw);
            }
            // create the image
            $success = file_put_contents($file,$im);
        }

        return ($success !== false)?$file:false;
    }



}