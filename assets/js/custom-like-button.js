jQuery(document).ready(function($) {
    $('.custom-like-button').on('click', function(e) {
        e.preventDefault();

        var button = $(this);
        var postID = button.data('post-id');
        var nonce = custom_like_button_ajax.nonce;

        // Send an AJAX request to update the like count
        $.ajax({
            url: custom_like_button_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'custom_like_button_ajax',
                nonce: nonce,
                post_id: postID
            },
            success: function(response) {
                // Update the like count on the button and title
                button.text('Liked');
                $('.custom-like-button').each(function() {
                    if ($(this).data('post-id') === postID) {
                        $(this).text('Liked');
                    }
                });
                $('.entry-title .custom-like-count').text(response.data);
            }
        });
    });
});