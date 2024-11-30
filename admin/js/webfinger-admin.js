jQuery(document).ready(function ($) {
    $('#add-regexp').click(function () {
        var newEntry = $('<div class="regexp-entry">' +
            '<input type="text" name="resource_regexps[]" class="regular-text">' +
            '<button type="button" class="button remove-regexp">Remove</button>' +
            '</div>');
        $('#regexp-container').append(newEntry);
    });

    $(document).on('click', '.remove-regexp', function () {
        $(this).parent().remove();
    });
});
