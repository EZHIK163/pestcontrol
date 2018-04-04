jQuery(".spoilers .title").click(function() {
    //console.log('click');
    jQuery(this).next("div.desc").slideToggle("slow");
    jQuery(this).toggleClass("active");
});