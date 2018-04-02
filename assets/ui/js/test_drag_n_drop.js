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

window.addEventListener('scroll', function(e) {
    coefficient_x = $('#inner-dropzone').width() / 100;
    coefficient_y = $('#inner-dropzone').height() / 100;

    var element = document.getElementById('inner-dropzone');
    //var position = element.getBoundingClientRect();

    position_root_element = findPos(element);

    if (points.length > 0) {
        points.forEach(function (point, i, points) {
            var temp = document.getElementById(prefix_point_id + point.id_internal);
            temp.style.left = position_root_element[0] + (point.x * coefficient_x) + 'px'
            temp.style.top = position_root_element[1] + (point.y* coefficient_y)  + 'px';
        });
    }

});


async function getPoints() {
    //var my_body = {id_scheme_point_control:id_scheme_point_control};
    var params = jQuery.param({
        id_scheme_point_control: id_scheme_point_control
    });
    const response = await fetch( base_url + '/manager/get-points-on-schema-point-control/?' + params//,
        //{
        //    method: "GET",
        //    headers: {
       //         "Content-Type": "application'json"
        //    },
        //    body: my_body
        //}
    );
    const json = await response.json();

    max_id_internal_in_customer = json.max_id_internal_in_customer;
    img_src_new_point = json.img_src_new_point;
    id_file_customer = json.id_file_customer;

    points = json.points;

    $('#main_div').append('<div id="outer-dropzone"></div>');
    $('#outer-dropzone').append('<div id="inner-dropzone" class="dropzone"><img id="root_img" src="' + json.img +'"/></div>');
    var element = document.getElementById('inner-dropzone');
    //var position = element.getBoundingClientRect();

    position_root_element = findPos(element);


    coefficient_x = $('#inner-dropzone').width() / 100;
    coefficient_y = $('#inner-dropzone').height() / 100;

    console.log(coefficient_x); console.log(coefficient_y);
    if (points.length > 0) {
        points.forEach(function (point, i, points) {
            $('#main_div').append('<div data-toggle="tooltip" data-placement="top" title="' + point.id_internal + '" class="draggable drag-drop" id="' + prefix_point_id + point.id_internal + '"><img src="' + point.img_src + '"/><p class="text_in_marker">' + point.id_internal + '</p></div>');

            //var temp = document.getElementById(prefix_point_id + point.id_internal);
            //temp.style.left = position_root_element[0] + (point.x * coefficient_x) + 'px'
            //temp.style.top = position_root_element[1] + (point.y* coefficient_y)  + 'px';
        });
    }
    window.scrollTo(0, 0);
    //$('[data-toggle="tooltip"]').tooltip();
};

function findPos(obj) {
    var curleft = 0;
    var curtop = 0;
    if(obj.offsetLeft) curleft += parseInt(obj.offsetLeft);
    if(obj.offsetTop) curtop += parseInt(obj.offsetTop);
    if(obj.scrollTop && obj.scrollTop > 0) curtop -= parseInt(obj.scrollTop);
    if(obj.offsetParent) {
        var pos = findPos(obj.offsetParent);
        //console.log(pos);
        curleft += pos[0];
        curtop += pos[1];
    } else if(obj.ownerDocument) {
        var thewindow = obj.ownerDocument.defaultView;
        if(!thewindow && obj.ownerDocument.parentWindow)
            thewindow = obj.ownerDocument.parentWindow;
        if(thewindow) {
            if(thewindow.frameElement) {
                var pos = findPos(thewindow.frameElement);
                curleft += pos[0];
                curtop += pos[1];
            }
        }
    }

    return [curleft,curtop];
}

var setIdSchemaPointControl = function(id) {
    id_scheme_point_control = id;
}

window.setIdSchemaPointControl = setIdSchemaPointControl;

var savePoint = async function() {

    window.scrollTo(0, 0);
    //const response = await fetch( 'http://test.pestcontrol.ru/account/get-points-on-schema-point-control' );
    //const json = await response.json();
    //var points = json.points;

    //var element = document.getElementById('outer-dropzone');
    //var element = document.querySelector('outer-dropzone');
    //var position = findPos(element);
    //console.log();

    //console.log(max_x);
    //console.log(max_y);
    var newPoints = points.map(function(point) {
        var temp = document.getElementById(prefix_point_id + point.id_internal);
        var position_div = temp.getBoundingClientRect();
        //var position_div = findPos(element);
        //console.log(point.id_internal);
        //if (position_div.left < position_root_element[0]
        //|| position_div.left > max_x
        //|| position_div.top < position_root_element[1]
        //|| position_div.top > max_y) {
            //console.log('out');
            //console.log(position_div.left > max_x);
        //} else {
            //console.log('in');

        //}
        //console.log(position_div.left);
        //console.log(position_div.top);
        //console.log(position_div);
        //console.log(position_root_element);
        //console.log(element.height + position_root_element[1]);
        //console.log(element.width + position_root_element[0]);

        var style = window.getComputedStyle(document.getElementById(prefix_point_id + point.id_internal));
        var marginTop = style.getPropertyValue('margin-top');
        var offset_y = marginTop.replace('px', '');
        var marginLeft = style.getPropertyValue('margin-left');
        var offset_x = marginLeft.replace('px', '');

        point.x = (position_div.left - position_root_element[0] + Math.abs(offset_x)) / coefficient_x;
        point.y = (position_div.top - position_root_element[1] + Math.abs(offset_y)) / coefficient_y;
        return point;
    });

    var my_body = JSON.stringify({id_file_customer:id_file_customer, points:newPoints});
    fetch(base_url + "/manager/save-point/",
    {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: my_body
    });
};

var addPoint = function() {
    //var element = document.getElementById('outer-dropzone');
    //var position = findPos(element);
    $('#main_div').append('<div data-toggle="tooltip" data-placement="top" title="Вверху" class="draggable drag-drop" id="' + prefix_point_id + max_id_internal_in_customer + '"><img src="' + img_src_new_point + '"/><p class="text_in_marker">' + max_id_internal_in_customer + '</p></div>');

    var temp = document.getElementById(prefix_point_id + max_id_internal_in_customer);
    temp.style.left = (position_root_element[0] - 31) + 'px'
    temp.style.top = position_root_element[1] + 'px';

    points.push({x:temp.style.left, y:temp.style.top, id_internal: max_id_internal_in_customer, is_new:true});

    max_id_internal_in_customer = max_id_internal_in_customer + 1;
}
window.addPoint = addPoint;

//getPoints();
window.savePoint = savePoint;

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

        //var element = document.getElementById('outer-dropzone');
        //var position = element.getBoundingClientRect();
            // /var position = findPos(element);

        //var x = event.clientX - position[1];
        //var y = event.clientY - position[0];
        //console.log('x: ' + x + ' | y: ' + y);

        //var textEl = event.target.querySelector('p');

        //textEl && (textEl.textContent =
        //    'moved a distance of '
        //    + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
        //    Math.pow(event.pageY - event.y0, 2) | 0))
        //        .toFixed(2) + 'px');
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