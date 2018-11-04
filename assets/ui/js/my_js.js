var elle_sliders_nfa = 0;
        //jQuery(window).on('load',  function() {
        //    //new JCaption('img.caption');
        //});
        //window.setInterval(function(){var r;try{r=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP")}catch(e){}if(r){r.open("GET","/index.php?option=com_ajax&format=json",true);r.send(null)}},1740000);
        //jQuery(document).ready(function(){
        //    jQuery('.hasTooltip').tooltip({"html": true,"container": "body"});
        //});
        //(function($){ window.addEvent('domready',function(){this.Slider87 = new DJImageSliderModule({id: '87', slider_type: 2, slide_size: 1000, visible_slides: 1, show_buttons: 1, show_arrows: 1, preload: 800},{auto: 1, transition: Fx.Transitions.linear, duration: 600, delay: 12600})}); })(document.id);


var points = [];

var id_scheme_point_control = -1;

var base_url = window.location.origin;

var img_src_new_point = null;

var prefix_point_id = 'point_';

var position_root_element = null;

var id_file_customer = -1;

var max_id_internal_in_customer = -1;

var coefficient_x = null;

var coefficient_y = null;

 var showPoints = async function showPoints(id, id_scheme_point_control_local) {
    setIdSchemaPointControl(id_scheme_point_control_local);
     var element = document.getElementById(id);
     //var position = element.getBoundingClientRect();
        //console.log(id);
        //console.log(id_scheme_point_control);


     position_root_element = getCoords(element);

     const json = await  getData(id_scheme_point_control);


        points = json.points;

        coefficient_x = $('#' + id).width() / 100;
        coefficient_y = $('#' + id).height() / 100;

    var outer_element = document.getElementById('outer-dropzone2');
    var style = window.getComputedStyle(outer_element);

    var padding_left = Number(style.getPropertyValue('padding-left').replace('px', ''));
    var padding_top = Number(style.getPropertyValue('padding-top').replace('px', ''));

        //console.log(coefficient_x); console.log(coefficient_y);
        if (points.length > 0) {
            points.forEach(function (point, i, points) {
                var element = document.getElementById(prefix_point_id + id_scheme_point_control + point.id_internal);
                if (element == null) {
                    $('#' + id).append('<div data-toggle="tooltip" data-placement="top" title="' + point.id_internal + '" class="drag-drop" id="' + prefix_point_id + id_scheme_point_control + point.id_internal + '"><img src="' + point.img_src + '"/><p class="text_in_marker">' + point.id_internal + '</p></div>');

                    var temp = document.getElementById(prefix_point_id + id_scheme_point_control + point.id_internal);
                    //temp.style.left = position_root_element[0] + (point.x * coefficient_x) + 'px'
                    //temp.style.top = position_root_element[1] + (point.y * coefficient_y) + 'px';

                    temp.style.left = (point.x * coefficient_x)  + 'px';
                    temp.style.top =  (point.y * coefficient_y)  + 'px';
                } else {
                    element.remove();
                }
            });
        }

 }

//window.showPoints = showPoints;

async function getData(id_scheme_point_control) {
     var params = jQuery.param({
         id_scheme_point_control: id_scheme_point_control
     });

     const response = await axios.get(base_url + '/manager/get-points-on-schema-point-control/?' + params);

    return response.data;
 }




async function getPoints() {
    const json = await getData(id_scheme_point_control);
    //console.log(json);
    max_id_internal_in_customer = json.max_id_internal_in_customer;
    img_src_new_point = json.img_src_new_point;
    id_file_customer = json.id_file_customer;

    points = json.points;

    $('#main_div').append('<div id="outer-dropzone" class="dropzone"></div>');
    $('#outer-dropzone').append('<div id="inner-dropzone" class="dropzone"><img id="root_img" onLoad="loadPoints();"  src="' + json.img +'"/></div>');


    //$('[data-toggle="tooltip"]').tooltip();
};

function loadPoints() {
    var element = document.getElementById('inner-dropzone');
    var outer_element = document.getElementById('outer-dropzone');
    //var position = element.getBoundingClientRect();

    if (element == null) {
        console.log('elem is null in getPoints');
    }

    position_root_element = getCoords(element);

    var style = window.getComputedStyle(outer_element);

    var padding_left = Number(style.getPropertyValue('padding-left').replace('px', ''));
    var padding_top = Number(style.getPropertyValue('padding-top').replace('px', ''));

    coefficient_x = $('#inner-dropzone').width() / 100;
    coefficient_y = $('#inner-dropzone').height() / 100;

    //console.log(coefficient_x); console.log(coefficient_y);
    if (points.length > 0) {
        points.forEach(function (point, i, points) {
            $('#outer-dropzone').append('<div data-toggle="tooltip" data-placement="top" title="' + point.id_internal + '" class="draggable drag-drop" id="' + prefix_point_id + point.id_internal + '"><img src="' + point.img_src + '"/><p class="text_in_marker">' + point.id_internal + '</p></div>');

            var temp = document.getElementById(prefix_point_id + point.id_internal);

            temp.style.left = (point.x * coefficient_x) + padding_left + 'px';
            temp.style.top =  (point.y * coefficient_y)  + padding_top + 'px';

            //temp.style.left = point.x + offset_x + 'px';
            //temp.style.top = point.y + offset_y + 'px';
        });
    }
}

function getCoords(elem) {
    // (1)
    var box = elem.getBoundingClientRect();

    var body = document.body;
    var docEl = document.documentElement;

    // (2)
    var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
    var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

    // (3)
    var clientTop = docEl.clientTop || body.clientTop || 0;
    var clientLeft = docEl.clientLeft || body.clientLeft || 0;

    // (4)
    var top = box.top + scrollTop - clientTop;
    var left = box.left + scrollLeft - clientLeft;

    return [left, top];
}

var setIdSchemaPointControl = function(id) {
    id_scheme_point_control = id;
}

//window.setIdSchemaPointControl = setIdSchemaPointControl;

var savePoint = async function() {

    var newPoints = points.map(function(point) {
        var my_div = document.getElementById(prefix_point_id + point.id_internal);
        var position_div = getCoords(my_div);


        var style = window.getComputedStyle(document.getElementById(prefix_point_id + point.id_internal));
        var marginTop = style.getPropertyValue('margin-top');
        var offset_y = marginTop.replace('px', '');
        var marginLeft = style.getPropertyValue('margin-left');
        var offset_x = marginLeft.replace('px', '');

        var new_x = (position_div[0] - position_root_element[0] + Math.abs(offset_x)) / coefficient_x;
        var new_y = (position_div[1] - position_root_element[1] + Math.abs(offset_y)) / coefficient_y;
        console.log(new_x);
        console.log(new_y);
        if ((((new_x > (point.x + 1) || new_x < (point.x - 1))
                || (new_y > (point.y + 1) || new_y < (point.y - 1))) && point.is_new == false) || point.is_new == true) {
            point.x = new_x;
            point.y = new_y;
        }
        return point;
    });

    var my_body = JSON.stringify({id_file_customer:id_file_customer, points:newPoints});

    axios.post(base_url + "/manager/save-point/", my_body);

    points = points.map(function(point) {
        point.is_new = false;
        return point;
    });
};

var addPoint = function() {

    var name_element = prefix_point_id + max_id_internal_in_customer;
    var id = max_id_internal_in_customer;
    max_id_internal_in_customer = max_id_internal_in_customer + 1;
    //var element = document.getElementById('outer-dropzone');
    //var position = findPos(element);
    var temp = document.getElementById(name_element);
    if (temp != null) {
        return;
    }
    $('#main_div').append('<div data-toggle="tooltip" data-placement="top" title="Вверху" class="draggable drag-drop" id="' + name_element + '"><img src="' + img_src_new_point + '"/><p class="text_in_marker">' + id + '</p></div>');
    var temp = document.getElementById(name_element);


    var my_x = (position_root_element[0] - 31);
    var my_y = position_root_element[1];
    temp.style.left = my_x + 'px'
    temp.style.top = my_y + 'px';


    points.push({x:my_x, y:my_y, id_internal: id, is_new:true});


}
//window.addPoint = addPoint;

//getPoints();

//window.savePoint = savePoint;

// target elements with the "draggable" class
interact('.draggable')
    .draggable({
        // enable inertial throwing
        inertia: true,
        // keep the element within the area of it's parent
        restrict: {
            restriction: "parent",
            endOnly: true,
            elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
        },
        // enable autoScroll
        autoScroll: true,

        // call this function on every dragmove event
        onmove: dragMoveListener,
        // call this function on every dragend event
        onend: function (event) {

        }
    });

function dragMoveListener (event) {
    var target = event.target,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    // translate the element
    target.style.webkitTransform =
        target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
}

// this is used later in the resizing and gesture demos
window.dragMoveListener = dragMoveListener;



/* The dragging code for '.draggable' from the demo above
 * applies to this demo as well so it doesn't have to be repeated. */

// enable draggables to be dropped into this
interact('.dropzone').dropzone({
    // only accept elements matching this CSS selector
    accept: '#yes-drop',
    // Require a 75% element overlap for a drop to be possible
    overlap: 0.75,

    // listen for drop related events:

    ondropactivate: function (event) {
        // add active dropzone feedback
        //event.target.classList.add('drop-active');
    },
    ondragenter: function (event) {
        //var draggableElement = event.relatedTarget,
        //dropzoneElement = event.target;

        // feedback the possibility of a drop
        //dropzoneElement.classList.add('drop-target');
        //draggableElement.classList.add('can-drop');
        //draggableElement.textContent = 'Dragged in';
    },
    ondragleave: function (event) {
        // remove the drop feedback style
        //event.target.classList.remove('drop-target');
        //event.relatedTarget.classList.remove('can-drop');
        //event.relatedTarget.textContent = 'Не установлен';
    },
    ondrop: function (event) {
        //event.relatedTarget.textContent = 'x: ';
        //console.log(event);

    },
    ondropdeactivate: function (event) {
        // remove active dropzone feedback
        //event.target.classList.remove('drop-active');
        //event.target.classList.remove('drop-target');
    }
});