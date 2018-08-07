jQuery(document).ready(function($) {	

  /**
     * Script for Customizer icons
     */ 
    $(document).on('click', '.capacious-customize-icons li', function() {
        $(this).parents('.capacious-customize-icons').find('li').removeClass();
        $(this).addClass('selected');
        var iconVal = $(this).parents('.capacious-icons-list-wrapper').find('li.selected').children('i').attr('class');
        var inpiconVal = iconVal.split(' ');
        $(this).parents( '.capacious-customize-icons' ).find('.capacious-icon-value').val(inpiconVal[1]);
        $(this).parents( '.capacious-customize-icons' ).find('.selected-icon-preview').html('<i class="' + iconVal + '"></i>');
        $('.capacious-icon-value').trigger('change');
    });

});
   /**
     * Script for Customizer icons Search
     */ 
    jQuery(document).on('keyup', '.capacious-customize-icons .search', function($) { 
        

        var text = jQuery(this),
       
        value = text.val(),
       

        customize_icons = text.siblings( '.capacious-icons-list-wrapper' );
         
         customize_icons.find('i').each(function () {
                if (jQuery(this).attr('class').search(value) > -1) {
                    jQuery(this).parent('li').show();
                } else {
                    jQuery(this).parent('li').hide();

                }
            });

    
        });
