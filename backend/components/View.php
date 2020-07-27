<?php
/**
 * Created by PhpStorm.
 * User: pritesh
 * Date: 29/11/15
 * Time: 1:23 AM
 */

namespace backend\components;

use yii\helpers;

class View extends \rmrevin\yii\minify\View
{
    /**
     * @param array $files
     * @return string
     */
    protected function _getSummaryFilesHash($files)
    {
        $result = '';
        foreach ($files as $file => $html) {
            $path = \Yii::getAlias($this->base_path) . str_replace(\Yii::getAlias($this->web_path), '', $file);

            if ($this->thisFileNeedMinify($file, $html) && file_exists($path)) {
                $result .= sha1_file($path);
            }
        }

        return sha1($result);
    }

    /**
     * @param array $files
     */
    protected function processMinifyCss($files)
    {
        $resultFile = $this->minify_path . '/' . $this->_getSummaryFilesHash($files) . '.css';

        if (!file_exists($resultFile)) {
            $css = '';

            foreach ($files as $file => $html) {
                $file = str_replace(\Yii::getAlias($this->web_path), '', $file);

                $content = file_get_contents(\Yii::getAlias($this->base_path) . $file);

                preg_match_all('|url\(([^)]+)\)|is', $content, $m);
                if (!empty($m[0])) {
                    $path = dirname($file);
                    $result = [];
                    foreach ($m[0] as $k => $v) {
                        if (in_array(strpos($m[1][$k], 'data:'), [0, 1], true)) {
                            continue;
                        }
                        $url = str_replace(['\'', '"'], '', $m[1][$k]);
                        if ($this->isUrl($url)) {
                            $result["(".$m[1][$k].")"] = '(\'' . $url . '\')';
                        } else {
                            $result["(".$m[1][$k].")"] = '(\'' . \Yii::getAlias($this->web_path) . $path . '/' . $url . '\')';
                        }
                    }
                    $content = str_replace(array_keys($result), array_values($result), $content);
                }

                $css .= $content;
            }

            $this->expandImports($css);

            $this->removeCssComments($css);

            $css = (new \CSSmin())
                ->run($css, $this->css_linebreak_pos);

            if (false !== $this->force_charset) {
                $charsets = '@charset "' . (string)$this->force_charset . '";' . "\n";
            } else {
                $charsets = $this->collectCharsets($css);
            }

            $imports = $this->collectImports($css);
            $fonts = $this->collectFonts($css);

            file_put_contents($resultFile, $charsets . $imports . $fonts . $css);

            if (false !== $this->file_mode) {
                @chmod($resultFile, $this->file_mode);
            }
        }

        $file = sprintf('%s%s', \Yii::getAlias($this->web_path), str_replace(\Yii::getAlias($this->base_path), '', $resultFile));

        $this->cssFiles[$file] = helpers\Html::cssFile($file);
    }

    protected function processMinifyJs($position, $files){
        if(!\Yii::$app->request->isPjax){
            parent::processMinifyJs($position, $files);
        }
    }
}