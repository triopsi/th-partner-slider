; (function ($) {
    $(document).ready(function () {
        $('#post').submit(function () {
            if ($("#set-post-thumbnail").find('img').size() > 0) {
                $('#ajax-loading').hide();
                $('#publish').removeClass('button-primary-disabled');
                return true;
            } else {
                alert("please set a featured image!");
                $('#ajax-loading').hide();
                $('#publish').removeClass('button-primary-disabled');
                return false;
            }
        });
    });

})(jQuery);