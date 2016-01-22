$(function () {
    
    $('.message').fadeOut(2000);
    
    $('.ui.menu .ui.dropdown').dropdown({
        on: 'hover'
    });
    
    $('.sidebar.item').on('click', function () {
        if ($('.three.wide.column').is(":hidden")) {
            $('.three.wide.column').show();
            $('.sixteen.wide.column').attr('class', 'thirteen wide column');
        } else {
            $('.three.wide.column').hide();
            $('.thirteen.wide.column').attr('class', 'sixteen wide column');
        }
    });
    
    $('.datetime-picker').datetimepicker({
        //format: 'd.m.Y H:i',
        //inline: true,
        lang: 'ch'
    });
    
    $('.ui.category.box .ui.dropdown').dropdown();
});
