$(function () {

    $('#jstree_category_div').on("create_node.jstree", function (e, data) {
        var newNode = data.node;
        var pid = newNode.parent.replace('node_');
        var text = newNode.text;
        
        $.post('',{},function(){
            
        });
        
        console.log(data);
    }).on("rename_node.jstree", function(e, data){
        console.log(data.node);
    }).on("delete_node.jstree", function(e, data){
        console.log(data.node);
    }).on("move_node.jstree", function(e, data){
        console.log(data.node);
    }).on("paste_node.jstree", function(e, data){
        console.log(data.node);
    });

    $('#jstree_category_div').jstree({
        core: {
            check_callback: true
        },
        plugins: ['contextmenu', 'dnd', 'sort', 'state']
    });
});