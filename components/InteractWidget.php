<?php

/*
 * This file is part of the 2amigos/yii2-chartjs-widget project.
 * (c) 2amigOS! <http://2amigos.us/>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace app\components;

use app\assets\InteractAsset;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 *
 * Chart renders a canvas ChartJs plugin widget.
 */
class InteractWidget extends Widget
{
    public $options = [];
    public $clientOptions = [];
    public $data = [];
    public $id_scheme_point_control;

    /**
     * Initializes the widget.
     * This method will register the bootstrap asset bundle. If you override this method,
     * make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        //$this->id_scheme_point_control = 1;

//        $this->data = [
//            'img'       => 'http://koffkindom.ru/wp-content/uploads/2016/02/plan-doma-8x8-2et-10.jpg',
//            'points'    => [
//                [
//                    'id'        => 'point_1',
//                    'x'         => 0,
//                    'y'         => 0,
//                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
//                ],
//                [
//                    'id'        => 'point_2',
//                    'x'         => 10,
//                    'y'         => 10,
//                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
//                ],
//                [
//                    'id'        => 'point_3',
//                    'x'         => 20,
//                    'y'         => 20,
//                    'img_src'   => 'https://png.icons8.com/metro/1600/checkmark.png'
//                ]
//            ]
//        ];
//
//        foreach ($this->data['points'] as $point) {
//            $img = Html::img($point['img_src'], ['alt' => 'img_'.$point['id']]);
//            echo Html::tag('div', $img, [
//                'class'     => 'draggable drag-drop',
//                'id'        => $point['id']
//            ]);
//        }
//        $img = Html::img($this->data['img'], ['alt' => 'image']);
//        echo Html::tag('div', $img, [
//            'class'     => 'dropzone',
//            'id'        => 'outer-dropzone'
//        ]);
        $this->registerClientScript();
    }

    /**
     * Registers the required js files and script to initialize ChartJS plugin
     */
    protected function registerClientScript()
    {
        //$id = $this->options['id'];
        $view = $this->getView();
        InteractAsset::register($view);



        //var element = document.getElementById('outer-dropzone');
        //var position = element.getBoundingClientRect();";
        //$js = "
        

//        foreach ($this->data['points'] as $point) {
//            //$js .= "
//            var {$point['id']} = document.getElementById('{$point['id']}');
//            {$point['id']}.style.left = position.left + {$point['x']} + 'px';
//            {$point['id']}.style.top = position.top + {$point['y']} + 'px';";
//        }
        /*$config = Json::encode(
            [
                'type' => $this->type,
                'data' => $this->data ?: new JsExpression('{}'),
                'options' => $this->clientOptions ?: new JsExpression('{}')
            ]
        );*/

//        $js = "
//
//
        //var savePoint = function() {
//
//    var array = new Array({\"name\":\"value\"});
//    var my_body = JSON.stringify(array);
//    var response = fetch(\"http://test.pestcontrol.ru/manager/savePoint/\",
//    {
//        method: \"POST\",
//        headers: {
//            \"Content-Type\": \"application'json\"
//        },
//        body: my_body
//    });
//    console.log(response);
        //};
        //window.savePoint = savePoint;
//
        //async function getPoints() {
//    const response = await fetch( \"http://test.pestcontrol.ru/account/get-points-on-schema-point-control\" );
//    const json = await response.json();
//    var points = json.points;
//
//    var root_element = document.getElementById('main_div');
//       console.log(root_element);
//    points.forEach(function(item, i, points) {";
//        $js .= '$(\"#main_div\').append(\'<a href="http://google.com">Гугли!</a>\');';
//    $js .= "});
        //}
        //getPoints();
        ////getPoints();
        ////window.getPoints = getPoints;
//
        //// target elements with the \"draggable\" class
        //interact('.draggable')
        //  .draggable({
//    // enable inertial throwing
//    inertia: true,
//    // keep the element within the area of it's parent
//    restrict: {
//      restriction: \"parent\",
//      endOnly: true,
//      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
//    },
//    // enable autoScroll
//    autoScroll: true,
//
//    // call this function on every dragmove event
//    onmove: dragMoveListener,
//    // call this function on every dragend event
//    onend: function (event) {
//
//    var element = document.getElementById('outer-dropzone');
//    var position = element.getBoundingClientRect();
//
//    var x = event.clientX - position.left;
//    var y = event.clientY- position.top;
//    console.log('x: ' + x + ' | y: ' + y);
//
//      var textEl = event.target.querySelector('p');
//
//      textEl && (textEl.textContent =
//        'moved a distance of '
//        + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
//                     Math.pow(event.pageY - event.y0, 2) | 0))
//            .toFixed(2) + 'px');
//    }
        //  });
//
        //  function dragMoveListener (event) {
//    var target = event.target,
//        // keep the dragged position in the data-x/data-y attributes
//        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
//        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
//
//    // translate the element
//    target.style.webkitTransform =
//    target.style.transform =
//      'translate(' + x + 'px, ' + y + 'px)';
//
//    // update the posiion attributes
//    target.setAttribute('data-x', x);
//    target.setAttribute('data-y', y);
        //  }
//
        //  // this is used later in the resizing and gesture demos
        //  window.dragMoveListener = dragMoveListener;
//
//
//
        ///* The dragging code for '.draggable' from the demo above
        // * applies to this demo as well so it doesn't have to be repeated. */
//
        //// enable draggables to be dropped into this
        //interact('.dropzone').dropzone({
        //  // only accept elements matching this CSS selector
        //  accept: '#yes-drop',
        //  // Require a 75% element overlap for a drop to be possible
        //  overlap: 0.75,
//
        //  // listen for drop related events:
//
        //  ondropactivate: function (event) {
//    // add active dropzone feedback
//    event.target.classList.add('drop-active');
        //  },
        //  ondragenter: function (event) {
//    var draggableElement = event.relatedTarget,
//        dropzoneElement = event.target;
//
//    // feedback the possibility of a drop
//    dropzoneElement.classList.add('drop-target');
//    draggableElement.classList.add('can-drop');
//    //draggableElement.textContent = 'Dragged in';
        //  },
        //  ondragleave: function (event) {
//    // remove the drop feedback style
//    event.target.classList.remove('drop-target');
//    event.relatedTarget.classList.remove('can-drop');
//    //event.relatedTarget.textContent = 'Не установлен';
        //  },
        //  ondrop: function (event) {
//    //event.relatedTarget.textContent = 'x: ';
//    //console.log(event);
//
        //  },
        //  ondropdeactivate: function (event) {
//    // remove active dropzone feedback
//    event.target.classList.remove('drop-active');
//    event.target.classList.remove('drop-target');
        //  }
        //});
//
//
        //";
        $js = "setIdSchemaPointControl({$this->id_scheme_point_control}); getPoints();";
        $view->registerJs($js);
    }
}
