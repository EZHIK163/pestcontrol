<?php
namespace app\components;

use yii\base\Widget;

class SliderWidget extends Widget {
    public function run() {
        return '<nav class="navigation" role="navigation">
            <div class="navbar pull-left">
                <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </div>
            <div class="nav-collapse">

                <div id="djslider-loader87" class="djslider-loader" style="background: transparent none repeat scroll 0% 0%; padding-top: 0px; padding-bottom: 0px;">
                    <div id="djslider87" class="djslider" style="opacity: 1; visibility: visible; width: 940px; height: 132px;">
                        <div id="slider-container87" class="slider-container">
                            <ul id="slider87" style="position: relative; width: 940px;">
                                <li style="position: absolute; top: 0px; left: 0px; opacity: 0; visibility: hidden; width: 940px; height: 132px;">
                                    <img src="'. \Yii::$app->request->baseUrl .'slider/bg_header-Xjw49.jpg" alt="slide0">


                                </li>
                                <li style="position: absolute; top: 0px; left: 0px; opacity: 0; visibility: hidden; width: 940px; height: 132px;">
                                    <img src="'. \Yii::$app->request->baseUrl .'slider/s5.jpg" alt="slide1">


                                </li>
                                <li style="position: absolute; top: 0px; left: 0px; opacity: 0; visibility: hidden; width: 940px; height: 132px;">
                                    <img src="'. \Yii::$app->request->baseUrl .'slider/bg_header-36610.jpg" alt="slide2">


                                </li>
                                <li style="position: absolute; top: 0px; left: 0px; opacity: 1; visibility: visible; width: 940px; height: 132px;">
                                    <img src="'. \Yii::$app->request->baseUrl .'slider/s6.jpg" alt="slide3">


                                </li>
                                <li style="position: absolute; top: 0px; left: 0px; opacity: 0; visibility: hidden; width: 940px; height: 132px;">
                                    <img src="'. \Yii::$app->request->baseUrl .'slider/slide2.jpg" alt="slide4">


                                </li>
                                <li style="position: absolute; top: 0px; left: 0px; opacity: 0; visibility: hidden; width: 940px; height: 132px;">
                                    <img src="'. \Yii::$app->request->baseUrl .'slider/s7.jpg" alt="slide5">


                                </li>
                            </ul>
                        </div>
                        <div id="navigation87" class="navigation-container">
                            <img id="prev87" class="prev-button" src="'. \Yii::$app->request->baseUrl .'slider//prev.png" alt="Предыдущий" style="opacity: 0;">
                            <img id="next87" class="next-button" src="'. \Yii::$app->request->baseUrl .'slider/next.png" alt="Следующий" style="opacity: 0;">
                            <img id="play87" class="play-button" src="'. \Yii::$app->request->baseUrl .'slider/play.png" alt="Играть" style="opacity: 0; margin-left: -17px; display: none;">
                            <img id="pause87" class="pause-button" src="'. \Yii::$app->request->baseUrl .'slider/pause.png" alt="Пауза" style="opacity: 0; display: none; margin-left: -17px;">
                        </div>
                        <div id="cust-navigation87" class="navigation-container-custom">
                            <span class="load-button "></span><span class="load-button "></span><span class="load-button "></span><span class="load-button load-button-active"></span><span class="load-button"></span><span class="load-button"></span>        </div>
                    </div>
                </div>

                <div style="clear: both"></div>
            </div>
        </nav>';
    }
}