$(function () {

    var photoHolder = $('.ui.cards');
    photoHolder.data('index', photoHolder.find('.ui.card').length);

    $('.ui.add').click(function () {

        var index = photoHolder.data('index');
        var tpl = $('.photo.field').attr('data-prototype');
        var newForm = $(tpl.replace(/__name__/g, index));

        photoHolder.append(newForm);
        photoHolder.data('index', index + 1);

        initFinder(newForm);
    });

    $('.ui.card').each(function () {
        initFinder(this);
    });
});