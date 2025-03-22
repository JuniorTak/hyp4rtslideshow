// Image uploader.
jQuery(document).ready(function($){
    var customUploader;

    $('#hypss_select_btn').click(function(e) {
        e.preventDefault();
        if (customUploader) {
            customUploader.open();
            return;
        }

        customUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        customUploader.on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();
            $('#hypss_image').val(attachment.url);
        });

        customUploader.open();
    });
});

// Reorder Images.
function hypss_reorder_images() {
    // Convert ul > li > img tags into an array of img src URLs.
    var list = document.getElementById('sortable');
    var listItems = list.querySelectorAll('li');
    var imagesArray = Array.from(listItems).map(function(li) {
        var img = li.querySelector('img');
        var imgSrc = img ? img.src : null;
        return imgSrc;
    });
    
    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'hypss_reorder_images',
            image_urls: imagesArray
        },
        success: function(response) {
            if(response.success) {
                alert('Images reordered sucessfully.');
            } else {
                alert('Failed to reorder images.');
            }
        }
    });
}

// Remove Image.
function hypss_remove_image(button, imageIndex) {
    var conf = confirm("You are about to remove image from the slideshow!\n'Cancel' to stop or 'OK' to remove...");
    if (conf){
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'hypss_remove_image',
                image_index: imageIndex
            },
            success: function(response) {
                if(response.success) {
                    jQuery(button).parent().remove();
                } else {
                    alert('Failed to remove image.');
                }
            }
        });
    }
}