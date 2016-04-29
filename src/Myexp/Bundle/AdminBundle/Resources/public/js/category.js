$(function () {
    $('#jstree_category_div').jstree({
        core: {
            check_callback: true
        },
        plugins: ['contextmenu', 'dnd', 'state'],
        contextmenu: {
            items: function () {

                var items = {
                    new : {
                        label: '新建',
                        action: function (data) {

                            var inst = $.jstree.reference(data.reference);
                            var obj = inst.get_node(data.reference);
                            var pid = obj.li_attr.dbid;
                            var param = {contentModelId: contentModelId, parentId: pid};

                            $.get('/admin/category/new', param, function (html) {
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
                                    },
                                    onShow: function(){
                                        $('.ui.toggle.checkbox', this).checkbox();
                                    }
                                }).modal('show');
                            });
                        }
                    },
                    edit: {
                        label: '编辑',
                        action: function (data) {

                            var inst = $.jstree.reference(data.reference);
                            var obj = inst.get_node(data.reference);
                            var id = obj.li_attr.dbid;

                            $.get('/admin/category/' + id + '/edit', {}, function (html) {
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
                        label: '删除',
                        action: function (data) {

                            if (!confirm('你确定要删除这个分类吗？')) {
                                return;
                            }

                            var inst = $.jstree.reference(data.reference);
                            var obj = inst.get_node(data.reference);
                            var id = obj.li_attr.dbid;

                            $.post('/admin/category/delete', {id: id}, function (res) {
                                if (res.code === 'ok') {
                                    var inst = $.jstree.reference(data.reference),
                                            obj = inst.get_node(data.reference);
                                    if (inst.is_selected(obj)) {
                                        inst.delete_node(inst.get_selected());
                                    }
                                    else {
                                        inst.delete_node(obj);
                                    }
                                }
                            }, 'json');
                        }
                    }
                };

                return items;
            }
        }
    });

    //移动节点
    $('#jstree_category_div').on('move_node.jstree', function (e, data) {

        var dbid = data.node.li_attr.dbid;
        var position = data.position;
        var parent = data.instance.get_node(data.parent);
        var parentId = 0;

        if (parent.li_attr.dbid) {
            parentId = parent.li_attr.dbid;
        }
        
        var param = {
            id: dbid,
            position: position,
            parentId: parentId
        };

        $.post('/admin/category/move', param, function (res) {
            if (res.code !== 'ok') {
                alert(res.message);
            }
        }, 'json');
    });
});