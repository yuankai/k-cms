$(function () {
    $('#jstree_menu_div').jstree({
        core: {
            check_callback: true
        },
        plugins: ['contextmenu', 'dnd', 'state'],
        contextmenu: {
            items: function () {

                var items = {
                    new : {
                        label: 'New',
                        action: function (data) {
                            
                            var inst = $.jstree.reference(data.reference);
                            var obj = inst.get_node(data.reference);
                            var pid = obj.li_attr.dbid;
                            var param = {menuId: menuId, parentId: pid};
                                                
                            $.get('/admin/menuitem/new', param, function (html) {
                                $('.ui.modal').html(html);
                                $('.ui.modal').modal({
                                    onApprove: function () {
                                        $('form', '.ui.modal').ajaxSubmit({
                                            dataType: 'json',
                                            success: function (res) {
                                                
                                                var node = {
                                                    text: res.title,
                                                    li_attr: {dbid: res.id}
                                                };

                                                inst.create_node(obj, node, "last", function (newNode) {
                                                    inst.select_node(newNode);
                                                });

                                                $('.ui.modal').modal('hide');
                                            }
                                        });

                                        return false;
                                    }
                                }).modal('show');
                            });
                        }
                    },
                    edit: {
                        label: 'Edit',
                        action: function (data) {
                            
                            var inst = $.jstree.reference(data.reference);
                            var obj = inst.get_node(data.reference);
                            var id = obj.li_attr.dbid;
                            
                            $.get('/admin/menuitem/'+id+'/edit', {}, function (html) {
                                $('.ui.modal').html(html);
                                $('.ui.modal').modal({
                                    onApprove: function () {
                                        
                                        $('form', '.ui.modal').ajaxSubmit({
                                            dataType: 'json',
                                            success: function (res) {
                                                    
                                                obj.text = res.title;

                                                $('.ui.modal').modal('hide');
                                            }
                                        });

                                        return false;
                                    }
                                }).modal('show');
                            });
                        }
                    },
                    delete: {
                        label: 'Delete',
                        action: function (data) {
                            
                            var inst = $.jstree.reference(data.reference);
                            var obj = inst.get_node(data.reference);
                            var id = obj.li_attr.dbid;
                            
                            $.get('/admin/menuitem/delete', {menuItemId: id}, function (res) {
                                
                            });
                        }
                    }
                };

                return items;
            }
        }
    });
});