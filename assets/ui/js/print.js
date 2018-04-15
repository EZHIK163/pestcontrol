function CallPrint(strid) {
    var prtContent = document.getElementById(strid);
    var prtCSS = '' +
        '<link rel="stylesheet" href="/assets/89b3de7d/css/css_for_drag_n_drop.css" type="text/css" />' +
        '<link rel="stylesheet" href="/assets/89b3de7d/css/template.css" type="text/css" />' +
        '<link rel="stylesheet" href="/assets/89b3de7d/css/my_css.css" type="text/css" />' +
        '<link href="/assets/89b3de7d/css/css.css" rel="stylesheet">' +
        '<link href="/assets/89b3de7d/css/ext_tss.css" rel="stylesheet">' +
        '<link href="/assets/89b3de7d/css/style.css" rel="stylesheet">';
    var WinPrint = window.open('','','left=50,top=500,width=800,height=600,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write('<div id="print" class="my_print_div">');
    WinPrint.document.write(prtCSS);
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</div>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
    prtContent.innerHTML=strOldOne;
}
