jQuery(document).ready(function($) {
   $('#responsive-css-editor-tabs').tabs();

   // Save button functionality
   $('#save-css-button').click(function() {
       var desktopCSS = $('#desktop-css-code').val();
       var tabletCSS = $('#tablet-css-code').val();
       var mobileCSS = $('#mobile-css-code').val();

       $.ajax({
           url: ajaxurl,
           type: 'POST',
           data: {
               action: 'save_responsive_css',
               desktop_css: desktopCSS,
               tablet_css: tabletCSS,
               mobile_css: mobileCSS,
           },
           success: function(response) {
               alert('CSS Saved!');
           }
       });
   });
});