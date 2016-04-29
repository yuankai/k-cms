var modalDiv; //对话框div
var elfinder;//elfinder实例
var finderConnector = base_url + '/finder/connector';//连接器路径
var currentContainer;// 当前容器

$(function () {
    modalDiv = $('<div class="ui modal"></div>').appendTo('body');
});

/**
 * 初始化finder
 * 
 * @param {type} container
 * @returns {undefined}
 */
function initFinder(container) {

    $('.blurring.dimmable.image', container).dimmer({on: 'hover'});
    $('.ui.inverted.button', container).click(function () {
        currentContainer = container;
        
        if(!elfinder){
            initElFinder();
        }
        
        $(modalDiv).modal('show');
    });

    $('.ui.delete', container).click(function () {
        $(this).parent('.ui.card').remove();
    });
}

/**
 * 初始化ELFinder
 * 
 * @returns {undefined}
 */
function initElFinder(){
    elfinder = $(modalDiv).elfinder({
        url: finderConnector,
        lang: 'zh_CN',
        getFileCallback: function (file) {
            var img = $(currentContainer).find('.blurring.dimmable.image img');
            var val = $(currentContainer).find('input:hidden');
            $(val).val(file.url);
            $(img).attr('src', file.url);
            $(modalDiv).modal('hide');
        }
    }).elfinder('instance');
}