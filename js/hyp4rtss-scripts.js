/*jshint esversion: 6 */
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
    var listItemsToDelete = list.querySelectorAll('li:has(p)');
    listItemsToDelete.forEach( (item) => {
        item.remove();
    });
    var listItems = list.querySelectorAll('li:has(img)');
    var imagesArray = Array.from(listItems).map(function(li) {
        var img = li.querySelector('img');
        var imgSrc = img ? img.getAttribute('data-full-src') : null;
        return imgSrc;
    });
    
    jQuery.ajax({
        url: hypss_ajax.ajax_url,
        type: 'POST',
        data: {
            _ajax_nonce: hypss_ajax.nonce,
            action: 'hypss_reorder_images',
            image_urls: imagesArray
        },
        success: function(response) {
            if(response.success) {
                // Update buttons data-index to match reordered indexes.
                listItems.forEach( (item, key) => {
                    let delBtn = item.querySelector('.button');
                    delBtn.dataset.index = key;
                });
                alert('Images reordered sucessfully.');
            } else {
                alert('Failed to reorder images.');
            }
        }
    });
}

// Remove Image.
function hypss_remove_image(button) {
    var conf = confirm("You are about to remove image from the slideshow!\n'Cancel' to stop or 'OK' to remove...");
    if (conf){
        jQuery.ajax({
            url: hypss_ajax.ajax_url,
            type: 'POST',
            data: {
                _ajax_nonce: hypss_ajax.nonce,
                action: 'hypss_remove_image',
                image_index: button.dataset.index
            },
            success: function(response) {
                if(response.success) {
                    // Update layout after image removal.
                    let count_images = response.data.count_images;
                    if(count_images === 1) {
                        let elements = document.querySelectorAll('.hypss-reorder');
                        elements.forEach(element => {
                            element.style.display = 'none';
                        });
                    }
                    else if(count_images === 0) {
                        let hypss_span = document.createElement('span');
                        hypss_span.innerText = 'No images found';
                        document.querySelector('div.wrap').append(hypss_span);
                    }
                    // Remove image container.
                    jQuery(button).parent().remove();
                    // Update buttons data-index to match images indexes.
                    let list = document.getElementById('sortable');
                    let listItems = list.querySelectorAll('li');
                    listItems.forEach( (item, key) => {
                        let delBtn = item.querySelector('.button');
                        delBtn.dataset.index = key;
                    });
                } else {
                    alert('Failed to remove image.');
                }
            }
        });
    }
}
