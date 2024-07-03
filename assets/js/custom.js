jQuery(document).ready(function($) {
    // Mảng màu sắc với tên và mã màu
    var colorCodes = {
        'red': '#FF0000',
        'blue': '#0000FF',
        'green': '#008000'
        // Thêm các màu khác nếu cần
    };

    // Chuyển đổi select attribute của WooCommerce thành các thẻ <a>
    $('form.variations_form').each(function() {
        var $form = $(this);
        var $selectColor = $form.find('select[name^="attribute_color"]');
        var $selectGender = $form.find('select[name^="attribute_gender"]');
        var $colorContainer = $('<div class="color-links"></div>');
        var $genderContainer = $('<div class="gender-links"></div>');
        var $summaryContainer = $('<div class="summary-container"></div>');

        // Ẩn select inputs
        $selectColor.hide();
        $selectGender.hide();

        // Tạo các thẻ <a> với mã màu tương ứng cho Color
        $selectColor.find('option').each(function() {
            var $option = $(this);
            if ($option.val() !== '') {
                var colorName = $option.val();
                var colorCode = colorCodes[colorName.toLowerCase()] || '#000000'; // Mặc định là đen nếu không tìm thấy màu

                var $link = $('<a>', {
                    href: '#',
                    text: $option.text(),
                    'data-value': colorName,
                    class: 'color-link',
                    css: {
                        backgroundColor: colorCode,
                        color: '#ffffff',
                        padding: '10px',
                        margin: '5px',
                        display: 'inline-block',
                        borderRadius: '5px',
                        textDecoration: 'none',
                        border: '1px solid #ccc'
                    }
                });

                $colorContainer.append($link);
            }
        });

        // Tạo các thẻ <a> cho Gender
        $selectGender.find('option').each(function() {
            var $option = $(this);
            if ($option.val() !== '') {
                var genderName = $option.val();

                var $link = $('<a>', {
                    href: '#',
                    text: $option.text(),
                    'data-value': genderName,
                    class: 'gender-link',
                    css: {
                        display: 'inline-block',
                        width: '100px',
                        height: '100px',
                        padding: '10px',
                        margin: '5px',
                        border: '1px solid #ccc',
                        borderRadius: '5px',
                        textAlign: 'center',
                        lineHeight: '80px', // Căn giữa văn bản
                        textDecoration: 'none',
                        color: '#000',
                        transition: 'background-color 0.3s'
                    }
                });

                $genderContainer.append($link);
            }
        });

        $selectColor.after($colorContainer);
        $selectGender.after($genderContainer);
        $form.append($summaryContainer);

        // Đồng bộ thẻ <a> với select
        function updateSummary() {
            var colorValue = $selectColor.val();
            var genderValue = $selectGender.val();
            var variation = $form.find('.single_variation_wrap').find('.variation_id').val();

            // Lấy thông tin SKU và giá từ biến thể
            var sku = $form.find('.variation_id[value="' + variation + '"]').siblings('.sku').text();
            var price = $form.find('.variation_id[value="' + variation + '"]').siblings('.price').text();

            $summaryContainer.html('Color: ' + colorValue + '<br>Gender: ' + genderValue + '<br>SKU: ' + sku + '<br>Price: ' + price);
        }

        $colorContainer.on('click', 'a.color-link', function(event) {
            event.preventDefault();
            var $selectedLink = $(this);
            $selectColor.val($selectedLink.data('value')).trigger('change');

            // Thêm class active cho link đã chọn
            $colorContainer.find('a.color-link').removeClass('active');
            $selectedLink.addClass('active');

            updateSummary();
        });

        $genderContainer.on('click', 'a.gender-link', function(event) {
            event.preventDefault();
            var $selectedLink = $(this);
            $selectGender.val($selectedLink.data('value')).trigger('change');

            // Thêm class active cho link đã chọn
            $genderContainer.find('a.gender-link').removeClass('active');
            $selectedLink.addClass('active');

            updateSummary();
        });

        // Đồng bộ khi form load
        var selectedColorVal = $selectColor.val();
        if (selectedColorVal) {
            $colorContainer.find('a[data-value="' + selectedColorVal + '"]').addClass('active');
        }

        var selectedGenderVal = $selectGender.val();
        if (selectedGenderVal) {
            $genderContainer.find('a[data-value="' + selectedGenderVal + '"]').addClass('active');
        }

        updateSummary();
    });
});
