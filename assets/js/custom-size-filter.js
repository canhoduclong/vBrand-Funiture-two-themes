jQuery(document).ready(function($) {
    $('.size-filter-checkbox').on('change', function() {
        var termSlug = $(this).data('term');
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        var paramName = 'filter_pa_size';
        var currentValues = urlParams.get(paramName) ? urlParams.get(paramName).split(',') : [];

        if ($(this).is(':checked')) {
            if (!currentValues.includes(termSlug)) {
                currentValues.push(termSlug);
            }
        } else {
            currentValues = currentValues.filter(function(value) {
                return value !== termSlug;
            });
        }

        if (currentValues.length > 0) {
            urlParams.set(paramName, currentValues.join(','));
        } else {
            urlParams.delete(paramName);
        }

        window.location.search = urlParams.toString();
    });

    $('.clcolor').on('click', function(event){
        event.preventDefault();
        $(this).toggleClass('selected');
        var color = $(this).data('color');
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        var paramName = 'filter_pa_color';
        var currentValues = urlParams.get(paramName) ? urlParams.get(paramName).split(',') : [];

        if ($(this).hasClass('selected')) {
            if (!currentValues.includes(color)) {
                currentValues.push(color);
            }
        } else {
            currentValues = currentValues.filter(function(value) {
                return value !== color;
            });
        }
        
        if (currentValues.length > 0) {
            urlParams.set(paramName, currentValues.join(','));
        } else {
            urlParams.delete(paramName);
        }
        
        window.location.search = urlParams.toString();
        
    })
    

});
