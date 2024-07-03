jQuery(document).ready(function($) {
    // Function to show minicart
    function showMinicart() {
        // $('#minicart').fadeIn();
        $('#minicart').addClass('open');
        $('#close-minicart').addClass('open');

    }

    // Function to hide minicart
    function hideMinicart() {
        //$('#minicart').fadeOut();
        $('#minicart').removeClass('open');
        $('#close-minicart').removeClass('open');
    }


    // Click event to close the minicart
    $('#close-minicart').on('click', function() {
        hideMinicart(); 
    });

    updateMinicartOnLoad();
    
    // Update minicart content
    function updateMinicart(cartData) {
        var itemsHtml = '';
        //console.log(cartData);
        cartData.items.forEach(function(item) {
            itemsHtml += '<div class="product">';
            itemsHtml += '<div class="product-cart-details">';
            itemsHtml += '<h4 class="product-title"><a href="' + item.permalink + '">' + item.name + '</a></h4>';
            itemsHtml += '<span class="cart-product-info">'; 
            itemsHtml += '<span class="cart-product-qty">' + item.quantity + '</span> x ' + item.price_html;
            itemsHtml += '</span>';
            itemsHtml += '</div>';
            itemsHtml += '<figure class="product-image-container">';
            itemsHtml += '<a href="' + item.permalink + '" class="product-image">';
            itemsHtml +=  item.image;
            itemsHtml += '</a>';
            itemsHtml += '</figure>';
            itemsHtml += '<a href="javascript:;" class="btn-remove remove-from-cart" cart_item_key="' + item.cart_item_key + '" title="Remove Product"><i class="icon-close"></i></a>';
            itemsHtml += '</div>';

        });
        
        $('.cart-count').html(cartData.items.length); 
        $('.cart-txt').html(cartData.subtotal); 

        $('#minicart-items').html(itemsHtml); 
        $('#minicart-total-count').html(cartData.total_count);
        $('#minicart-subtotal').html(cartData.subtotal);
    }


    // Function to update minicart on page load
    function updateMinicartOnLoad() {
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'get_cart_data'
            },
            success: function(response) {
                if (response.success) {
                    updateMinicart(response.data); 
                    //showMinicart();
                }
            }
        });
    }



    // Add product to cart via AJAX
    $('body').on('click', '.ajax_add_to_cart', function(e) {
        e.preventDefault(); 

        var productId = $(this).data('product_id');
        var button = $(this);

        // Disable button and show loading
        button.prop('disabled', true);
        button.addClass('loading');

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'add_to_cart',
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    //updateMinicart(response.data);
                    updateMinicartOnLoad();
                    showMinicart();
                    
                } else {
                    alert('Error adding product to cart.');
                }

                // Re-enable button and hide loading
                button.prop('disabled', false);
                button.removeClass('loading');
            },
            error: function() {
                alert('An error occurred.');
                button.prop('disabled', false);
                button.removeClass('loading');
            }
        });
    });

    // Remove product from cart via AJAX
    $('body').on('click', '.remove-from-cart', function(e) {
        e.preventDefault();
        var cartItemId = $(this).attr('cart_item_key'); 
        var button = $(this); 
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'remove_from_cart',
                cart_item_key: cartItemId
            },
            success: function(response) {
                if (response.success) {
                    //updateMinicart(response.data);
                    updateMinicartOnLoad();
                    showMinicart();
                } else {
                    alert('Error removing product from cart.');
                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    });
    
    



});
