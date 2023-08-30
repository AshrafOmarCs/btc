

// Delete btn 
$(".deleteBtn").click(function(event){
    event.preventDefault();
    if(confirm(CONFIRMATION_MSG) === true){
        $('#delete-form').prop('action',$(this).data('id')).submit();
    }
});

if($('#btn-delete-all').css('display', 'none')){
    $('#CheckAll').prop('checked', false);
    $('.selectedBox').prop('checked', false);
}

$('#CheckAll').on('click', function() {
    if($(this).prop('checked') === true) {
        $('.selectedBox').prop('checked', true);
        if ($('.selectedBox').filter(':checked').length > 0) {
            $('#btn-delete-all').css('display', 'block');
            $('#btn-restore-all').css('display', 'block');
        }
    } else {
        $('.selectedBox').prop('checked', false);
        $('#btn-delete-all').css('display', 'none');
        $('#btn-restore-all').css('display', 'none');
    }
});

const Checkbox = $('.selectedBox');
Checkbox.change(function (){
    if ($('.selectedBox').filter(':checked').length > 0){
        $('#btn-delete-all').css('display', 'block');
        $('#btn-restore-all').css('display', 'block');
    }else {
        $('#btn-delete-all').css('display', 'none');
        $('#btn-restore-all').css('display', 'none');
        $('#CheckAll').prop('checked', false);
    }
});

$('.preview-img').change(function(){
    document.getElementById($(this).data('target')).src = window.URL.createObjectURL(this.files[0]);
});

function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * 
 charactersLength));
   }
   return result;
}