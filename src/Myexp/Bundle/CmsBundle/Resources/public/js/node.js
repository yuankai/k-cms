$(function () {
    $('#jstree_node_div').jstree({
        core: {
            check_callback: true
        },
        plugins: ['contextmenu', 'dnd', 'state'],
        contextmenu: {
            items: function () {

                var items = {
                    new : {
                        label: 'New',
                        action: function () {
                            $.get('/admin/menuitem/new', {menuId: 1}, function (data) {
                                $('.ui.modal').html(data);
                                $('.ui.modal').modal({
                                    onApprove: function () {
                                        return false;
                                    }
                                }).modal('show');
                            });
                        }
                    },
                    edit: {
                        label: 'Edit',
                        action: function () {
                            $.get('/admin/menuitem/edit', {menuItemId: 1}, function (data) {
                                $('.ui.modal').html(data);
                                $('.ui.modal').modal({
                                    onApprove: function () {
                                        return false;
                                    }
                                }).modal('show');
                            });
                        }
                    },
                    delete: {
                        label: 'Delete',
                        action: function () {
                            $.get('/admin/menuitem/delete', {menuId: 1}, function (data) {
                                $('.ui.modal').html(data);
                                $('.ui.modal').modal({
                                    onApprove: function () {
                                        return false;
                                    }
                                }).modal('show');
                            });
                        }
                    }
                };

                return items;
            }
        }
    });
});