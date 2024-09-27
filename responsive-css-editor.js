jQuery(document).ready(function($) {
    $('#save-css-button').on('click', function() {
        var data = {
            action: 'save_responsive_css',
            desktop_css: $('#desktop-css-code').val(),
            tablet_css: $('#tablet-css-code').val(),
            mobile_css: $('#mobile-css-code').val(),
            _ajax_nonce: $('#responsive_css_nonce').val()
        };

        $.post(ajaxurl, data, function(response) {
            $('#save-message').html('<div class="notice notice-success is-dismissible"><p>CSS saved successfully!</p></div>');
            $('.notice').delay(3000).fadeOut();
        });
    });

    // Initialize jQuery UI tabs
    $('#responsive-css-editor-tabs').tabs();
});
