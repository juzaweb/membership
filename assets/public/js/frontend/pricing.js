$(function () {
    $(document).on('click', '.js-upgrade', function(e) {
        e.preventDefault();
        let plan = $(this).data('plan');

        $('.upgrade-form').find('input[name="plan"]').val(plan);
        $('.upgrade-form').show('slow');
    });
});
