function CallPrint(strid) {
    var prtContent = document.getElementById(strid);
    console.log(prtContent);
    var maxWidth = prtContent.clientWidth;
    var WinPrint = window.open('','','left=50,top=500,width=800,height=600,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write('<div id="print" style="max-width: ' + maxWidth + '" class="my_print_div">');
    WinPrint.document.head.innerHTML = document.head.innerHTML;
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</div>');
    WinPrint.document.close();
    WinPrint.focus();
    //prtContent.innerHTML=strOldOne;
}
