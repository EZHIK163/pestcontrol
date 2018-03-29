var points = [];

var id_scheme_point_control = -1;


async function getPoints() {
    //var my_body = {id_scheme_point_control:id_scheme_point_control};
    var params = jQuery.param({
        id_scheme_point_control: id_scheme_point_control
    });
    const response = await fetch( 'http://test.pestcontrol.ru/account/get-points-on-schema-point-control/?' + params//,
        //{
        //    method: "GET",
        //    headers: {
       //         "Content-Type": "application'json"
        //    },
        //    body: my_body
        //}
    );
    const json = await response.json();
    points = json.points;

    $('#main_div').append('<div class="dropzone" id="outer-dropzone"><img src="' + json.img +'"/></div>');
    var element = document.getElementById('outer-dropzone');
    var position = element.getBoundingClientRect();

    points.forEach(function(point, i, points) {
        $('#main_div').append('<div data-toggle="tooltip" data-placement="top" title="Вверху" class="draggable drag-drop" id="' + point.id + '"><img src="' + point.img_src +'"/></div>');

        var temp = document.getElementById(point.id);
        temp.style.left = position.left + point.x + 'px'
        temp.style.top = position.top + point.y + 'px';
    });

    $('[data-toggle="tooltip"]').tooltip();
};

var setIdSchemaPointControl = function(id) {
    id_scheme_point_control = id;
}

window.setIdSchemaPointControl = setIdSchemaPointControl;

var savePoint = async function() {

    //const response = await fetch( 'http://test.pestcontrol.ru/account/get-points-on-schema-point-control' );
    //const json = await response.json();
    //var points = json.points;

    var element = document.getElementById('outer-dropzone');
    var position = element.getBoundingClientRect();

    var newPoints = points.map(function(point) {
        var temp = document.getElementById(point.id);
        var position_div = temp.getBoundingClientRect();
        point.x = position_div.left -position.left;
        point.y = position_div.top -position.top;
        return point;
    });

    var my_body = JSON.stringify({points:newPoints});
    fetch("http://test.pestcontrol.ru/account/save-point/",
    {
        method: "POST",
        headers: {
        "Content-Type": "application'json"
        },
        body: my_body
    });
};


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

        var element = document.getElementById('outer-dropzone');
        var position = element.getBoundingClientRect();

        var x = event.clientX - position.left;
        var y = event.clientY- position.top;
        console.log('x: ' + x + ' | y: ' + y);

        var textEl = event.target.querySelector('p');

        textEl && (textEl.textContent =
            'moved a distance of '
            + (Math.sqrt(Math.pow(event.pageX - event.x0, 2) +
            Math.pow(event.pageY - event.y0, 2) | 0))
                .toFixed(2) + 'px');
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
            event.target.classList.add('drop-active');
        },
        ondragenter: function (event) {
            var draggableElement = event.relatedTarget,
                dropzoneElement = event.target;

            // feedback the possibility of a drop
            dropzoneElement.classList.add('drop-target');
            draggableElement.classList.add('can-drop');
            //draggableElement.textContent = 'Dragged in';
        },
        ondragleave: function (event) {
            // remove the drop feedback style
            event.target.classList.remove('drop-target');
            event.relatedTarget.classList.remove('can-drop');
            //event.relatedTarget.textContent = 'Не установлен';
        },
        ondrop: function (event) {
            //event.relatedTarget.textContent = 'x: ';
            //console.log(event);

        },
        ondropdeactivate: function (event) {
            // remove active dropzone feedback
            event.target.classList.remove('drop-active');
            event.target.classList.remove('drop-target');
        }
    });