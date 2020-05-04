(function($, undefined){
    $(function(){

// Ation for modals windows
    //Open reg modal
    $('.action-reg-modal').on('click', function (e) {
        e.preventDefault();
        $('#regModalWelcome').modal({
            keyboard: false,
            // backdrop:'static'
        });
    });
    //Close reg modal
    $('.close-modal-reg').on('click', function (e) {
        e.preventDefault();
        $('#regModalWelcome').modal('hide');
    });

    });
})(jQuery);