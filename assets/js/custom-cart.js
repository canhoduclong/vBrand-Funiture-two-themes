jQuery(document).ready(function($) {
    // Function to show minicart
    function showMinicart() {
        $('#minicart').fadeIn();
    }

    // Function to hide minicart
    function hideMinicart() {
        $('#minicart').fadeOut();
    }

    // Click event to close the minicart
    $('#close-minicart').on('click', function() {
        hideMinicart();
    });

    // Add product to cart via AJAX
    $('.add-to-cart-button').on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('product_id');

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'add_to_cart',
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    updateMinicart(response.data);
                    showMinicart();
                } else {
                    alert('Error adding product to cart.');
                }
            }
        });
    });

    // Update minicart content
    function updateMinicart(cartContents) {
        var itemsHtml = '';
        cartContents.forEach(function(item) {
            itemsHtml += '<div class="minicart-item">';
            itemsHtml += '<span class="minicart-item-name">' + item.name + '</span>';
            itemsHtml += '<span class="minicart-item-quantity">' + item.quantity + '</span>';
            itemsHtml += '</div>';
        });
        $('#minicart-items').html(itemsHtml);
    }
});
