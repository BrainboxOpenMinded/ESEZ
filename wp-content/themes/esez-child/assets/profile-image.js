jQuery(document).ready(function() {
    jQuery(document).find("input[id^='uploadimage']").live('click', function(){
        //var num = this.id.split('-')[1];
        formfield = jQuery('#image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

        window.send_to_editor = function(html) {
            imgurl = jQuery('img',html).attr('src');
            jQuery('#image').val(imgurl);

            tb_remove();
        }
        return false;
    });
});