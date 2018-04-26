function CallPrint(strid) {
    var prtContent = document.getElementById(strid);
    var WinPrint = window.open('','','left=50,top=500,width=800,height=600,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write('<div id="print" class="my_print_div">');
    WinPrint.document.head.innerHTML = document.head.innerHTML;
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</div>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
    prtContent.innerHTML=strOldOne;
}
