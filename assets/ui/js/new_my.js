"use strict";function _asyncToGenerator(e){return function(){var t=e.apply(this,arguments);return new Promise(function(e,n){function o(i,r){try{var a=t[i](r),c=a.value}catch(e){return void n(e)}if(!a.done)return Promise.resolve(c).then(function(e){o("next",e)},function(e){o("throw",e)});e(c)}return o("next")})}}function loadPoints(){var e=document.getElementById("inner-dropzone"),t=document.getElementById("outer-dropzone");null==e&&console.log("elem is null in getPoints"),position_root_element=getCoords(e);var n=window.getComputedStyle(t),o=Number(n.getPropertyValue("padding-left").replace("px","")),i=Number(n.getPropertyValue("padding-top").replace("px",""));coefficient_x=$("#inner-dropzone").width()/100,coefficient_y=$("#inner-dropzone").height()/100,points.length>0&&points.forEach(function(e,t,n){$("#outer-dropzone").append('<div data-toggle="tooltip" data-placement="top" title="'+e.id_internal+'" class="draggable drag-drop" id="'+prefix_point_id+e.id_internal+'"><img src="'+e.img_src+'"/><p class="text_in_marker">'+e.id_internal+"</p></div>");var r=document.getElementById(prefix_point_id+e.id_internal);r.style.left=e.x*coefficient_x+o+"px",r.style.top=e.y*coefficient_y+i+"px"})}function getCoords(e){var t=e.getBoundingClientRect(),n=document.body,o=document.documentElement,i=window.pageYOffset||o.scrollTop||n.scrollTop,r=window.pageXOffset||o.scrollLeft||n.scrollLeft,a=o.clientTop||n.clientTop||0,c=o.clientLeft||n.clientLeft||0,p=t.top+i-a;return[t.left+r-c,p]}function dragMoveListener(e){var t=e.target,n=(parseFloat(t.getAttribute("data-x"))||0)+e.dx,o=(parseFloat(t.getAttribute("data-y"))||0)+e.dy;t.style.webkitTransform=t.style.transform="translate("+n+"px, "+o+"px)",t.setAttribute("data-x",n),t.setAttribute("data-y",o)}var getData=function(){var e=_asyncToGenerator(regeneratorRuntime.mark(function e(t){var n,o;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return n=jQuery.param({id_scheme_point_control:t}),e.next=3,axios.get(base_url+"/manager/get-points-on-schema-point-control/?"+n);case 3:return o=e.sent,e.abrupt("return",o.data);case 5:case"end":return e.stop()}},e,this)}));return function(t){return e.apply(this,arguments)}}(),getPoints=function(){var e=_asyncToGenerator(regeneratorRuntime.mark(function e(){var t;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,getData(id_scheme_point_control);case 2:t=e.sent,max_id_internal_in_customer=t.max_id_internal_in_customer,img_src_new_point=t.img_src_new_point,id_file_customer=t.id_file_customer,points=t.points,$("#main_div").append('<div id="outer-dropzone" class="dropzone"></div>'),$("#outer-dropzone").append('<div id="inner-dropzone" class="dropzone"><img id="root_img" onLoad="loadPoints();"  src="'+t.img+'"/></div>');case 9:case"end":return e.stop()}},e,this)}));return function(){return e.apply(this,arguments)}}(),elle_sliders_nfa=0,points=[],id_scheme_point_control=-1,base_url=window.location.origin,img_src_new_point=null,prefix_point_id="point_",position_root_element=null,id_file_customer=-1,max_id_internal_in_customer=-1,coefficient_x=null,coefficient_y=null,showPoints=function(){function e(e,n){return t.apply(this,arguments)}var t=_asyncToGenerator(regeneratorRuntime.mark(function e(t,n){var o,i,r,a,c,p;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return setIdSchemaPointControl(n),o=document.getElementById(t),position_root_element=getCoords(o),e.next=5,getData(id_scheme_point_control);case 5:i=e.sent,points=i.points,coefficient_x=$("#"+t).width()/100,coefficient_y=$("#"+t).height()/100,r=document.getElementById("outer-dropzone2"),a=window.getComputedStyle(r),c=Number(a.getPropertyValue("padding-left").replace("px","")),p=Number(a.getPropertyValue("padding-top").replace("px","")),points.length>0&&points.forEach(function(e,n,o){var i=document.getElementById(prefix_point_id+id_scheme_point_control+e.id_internal);if(null==i){$("#"+t).append('<div data-toggle="tooltip" data-placement="top" title="'+e.id_internal+'" class="drag-drop" id="'+prefix_point_id+id_scheme_point_control+e.id_internal+'"><img src="'+e.img_src+'"/><p class="text_in_marker">'+e.id_internal+"</p></div>");var r=document.getElementById(prefix_point_id+id_scheme_point_control+e.id_internal);r.style.left=e.x*coefficient_x+"px",r.style.top=e.y*coefficient_y+"px"}else i.remove()});case 14:case"end":return e.stop()}},e,this)}));return e}(),setIdSchemaPointControl=function(e){id_scheme_point_control=e},savePoint=function(){var e=_asyncToGenerator(regeneratorRuntime.mark(function e(){var t,n;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t=points.map(function(e){var t=document.getElementById(prefix_point_id+e.id_internal),n=getCoords(t),o=window.getComputedStyle(document.getElementById(prefix_point_id+e.id_internal)),i=o.getPropertyValue("margin-top"),r=i.replace("px",""),a=o.getPropertyValue("margin-left"),c=a.replace("px",""),p=(n[0]-position_root_element[0]+Math.abs(c))/coefficient_x,d=(n[1]-position_root_element[1]+Math.abs(r))/coefficient_y;return console.log(p),console.log(d),((p>e.x+1||p<e.x-1||d>e.y+1||d<e.y-1)&&0==e.is_new||1==e.is_new)&&(e.x=p,e.y=d),e}),n=JSON.stringify({id_file_customer:id_file_customer,points:t}),fetch(base_url+"/manager/save-point/",{method:"POST",headers:{"Content-Type":"application/json"},body:n}),points=points.map(function(e){return e.is_new=!1,e});case 4:case"end":return e.stop()}},e,this)}));return function(){return e.apply(this,arguments)}}(),addPoint=function(){var e=prefix_point_id+max_id_internal_in_customer,t=max_id_internal_in_customer;max_id_internal_in_customer+=1;var n=document.getElementById(e);if(null==n){$("#main_div").append('<div data-toggle="tooltip" data-placement="top" title="Вверху" class="draggable drag-drop" id="'+e+'"><img src="'+img_src_new_point+'"/><p class="text_in_marker">'+t+"</p></div>");var n=document.getElementById(e),o=position_root_element[0]-31,i=position_root_element[1];n.style.left=o+"px",n.style.top=i+"px",points.push({x:o,y:i,id_internal:t,is_new:!0})}};interact(".draggable").draggable({inertia:!0,restrict:{restriction:"parent",endOnly:!0,elementRect:{top:0,left:0,bottom:1,right:1}},autoScroll:!0,onmove:dragMoveListener,onend:function(e){}}),window.dragMoveListener=dragMoveListener,interact(".dropzone").dropzone({accept:"#yes-drop",overlap:.75,ondropactivate:function(e){},ondragenter:function(e){},ondragleave:function(e){},ondrop:function(e){},ondropdeactivate:function(e){}});