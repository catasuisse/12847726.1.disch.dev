$(document).on('rex:ready', function() {
    $('.dd-datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        locale: 'de'
    });

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    // $('[class*=" yform-table-"] th.rex-table-action + *').text('Status');
});
