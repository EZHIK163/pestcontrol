jQuery(".spoilers .title").click(function() {
    //console.log('click');
    jQuery(this).next("div.desc").slideToggle("slow", function() {
        //var id = this.getAttribute('id').replace('div_', '');
        var name_dropzone = this.getElementById('name_dropzone').innerText;
        var id_file_customer = this.getElementById('id_file_customer').innerText;
        showPoints(name_dropzone, id_file_customer);
    });
    jQuery(this).toggleClass("active");
});

jQuery(".spoilers .general_title").click(function() {
    //console.log('click');
    jQuery(this).next("div.desc").slideToggle("slow");
    jQuery(this).toggleClass("active");
});

