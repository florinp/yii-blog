<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\redactor\widgets;

use Yii;
use yii\helpers\Url;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\AssetBundle;
use yii\helpers\ArrayHelper;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */

/**
 * Class Redactor
 * @package yii\redactor\widgets
 * @property AssetBundle $assetBundle
 */
class Redactor extends InputWidget
{

    public $options = [];
    public $clientOptions = [];
    private $_assetBundle;

    public function init()
    {
        $this->defaultOptions();
        $this->registerAssetBundle();
        $this->registerRegional();
        $this->registerPlugins();
        $this->registerScript();
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
    }

    public function defaultOptions()
    {
        if (!isset($this->options['id'])) {
            if ($this->hasModel()) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            } else {
                $this->options['id'] = $this->getId();
            }
        }
        $this->clientOptions['imageUpload'] = Url::to(ArrayHelper::getValue($this->clientOptions, 'imageUpload', Yii::$app->getModule('redactor')->imageUploadRoute));
        $this->clientOptions['fileUpload'] = Url::to(ArrayHelper::getValue($this->clientOptions, 'fileUpload', Yii::$app->getModule('redactor')->fileUploadRoute));
        $this->clientOptions['imageUploadErrorCallback'] = ArrayHelper::getValue($this->clientOptions, 'imageUploadErrorCallback', new JsExpression("function(json){alert(json.error);}"));
        $this->clientOptions['fileUploadErrorCallback'] = ArrayHelper::getValue($this->clientOptions, 'fileUploadErrorCallback', new JsExpression("function(json){alert(json.error);}"));

        if (isset($this->clientOptions['plugins']) && array_search('imagemanager', $this->clientOptions['plugins']) !== false) {
            $this->clientOptions['imageManagerJson'] = Url::to(ArrayHelper::getValue($this->clientOptions, 'imageManagerJson', Yii::$app->getModule('redactor')->imageManagerJsonRoute));
        }
        if (isset($this->clientOptions['plugins']) && array_search('filemanager', $this->clientOptions['plugins']) !== false) {
            $this->clientOptions['fileManagerJson'] = Url::to(ArrayHelper::getValue($this->clientOptions, 'fileManagerJson', Yii::$app->getModule('redactor')->fileManagerJsonRoute));
        }
    }

    public function registerRegional()
    {
        $lang = ArrayHelper::getValue($this->clientOptions, 'lang', Yii::$app->language);
        $langAsset = 'lang/' . $lang . '.js';
        if (file_exists(Yii::getAlias($this->assetBundle->sourcePath . '/' . $langAsset))) {
            $this->assetBundle->js[] = $langAsset;
        } else {
            ArrayHelper::remove($this->clientOptions, 'lang');
        }

    }

    public function registerPlugins()
    {
        if (isset($this->clientOptions['plugins']) && count($this->clientOptions['plugins'])) {
            foreach ($this->clientOptions['plugins'] as $plugin) {
                $js = 'plugins/' . $plugin . '/' . $plugin . '.js';
                if (file_exists(Yii::getAlias($this->assetBundle->sourcePath . DIRECTORY_SEPARATOR . $js))) {
                    $this->assetBundle->js[] = $js;
                }
                $css = 'plugins/' . $plugin . '/' . $plugin . '.css';
                if (file_exists(Yii::getAlias($this->assetBundle->sourcePath . '/' . $css))) {
                    $this->assetBundle->css[] = $css;
                }
            }
        }
    }

    public function registerScript()
    {
        $clientOptions = (count($this->clientOptions)) ? Json::encode($this->clientOptions) : '';
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').redactor({$clientOptions});");
    }

    public function registerAssetBundle()
    {
        $this->_assetBundle = RedactorAsset::register($this->getView());
    }

    public function getAssetBundle()
    {
        if (!($this->_assetBundle instanceof AssetBundle)) {
            $this->registerAssetBundle();
        }
        return $this->_assetBundle;
    }

}