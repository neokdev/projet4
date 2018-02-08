$(function () {
    $('.js-datepicker').datepicker({
        maxViewMode: 2,
        format: 'yyyy-mm-dd',
        language: 'fr',
        daysOfWeekDisabled: '2',
        datesDisabled: ['05/01/2018', '01/11/2018', '12/25/2018']
    });
});