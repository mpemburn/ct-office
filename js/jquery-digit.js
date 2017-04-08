$.fn.digits = function(){ 
    return this.each(function(){ 
        $(this).val( $(this).val().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
    })
}
