jQuery(document).ready(function($) {
    var $dropdowns = $('.js-reveal');

    $dropdowns.each(function() {
        var $dropdown = $(this);
        var $heading = $dropdown.find('.js-reveal-heading');
        $button = $('<button />');
        $button.click(function() {
            $dropdown.toggleClass('is-open');
        });

        $heading.wrapInner($button);
    });
});
