(function($, undefined){
    $(function(){
        // селект2 для стр админа
        $(document).ready(function(){
            $('.select2-admin-company').select2({
                placeholder: 'Компании не найдены',
                theme: "bootstrap4",
            });
        });

        // (end)селект2 для стр админа
        //Создание и изменение категорий и подкатегорий модалка
        // category create
        $('.admin-cr-pr').on('click', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('data-url');
            var themeId = 'null';
            if($(this).attr('data-theme-id') != ''){
                themeId = $(this).attr('data-theme-id');
            }
            $('.editAndCreateModal-body').empty();
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data: {
                        theme_id : themeId
                    },
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            $('.editAndCreateModal-body').html(data.render);
                            $('#editAndCreateModal').modal({
                                keyboard: false,
                                backdrop: 'static'
                            });
                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        });

        $('body').on('click', '.add-new-cat', function (e) {
            e.preventDefault();
            var inProgress = false;
            var form = $('#create-cat-form');
            var url = form.attr('action');

            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'POST',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'validator'){
                            $('#name').removeClass('is-invalid');
                            $('#commission').removeClass('is-invalid');
                            var objectFails = data.fails;
                            Object.keys(objectFails).map(function(objectKey, index) {
                                var value = objectFails[objectKey];
                                $.toaster({
                                    message: value[0],
                                    title: 'Sorry!',
                                    priority: 'danger',
                                    settings: {'timeout': 3000}
                                });
                                if(objectKey == 'name'){
                                    $('#name').addClass('is-invalid');
                                }else if(objectKey == 'commission'){
                                    $('#commission').addClass('is-invalid');
                                }
                            });
                        }else if(data.status == 'success'){
                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                            $('#editAndCreateModal').modal('hide');
                            window.location.reload();
                        }else if(data.status == 'error'){
                            $.toaster({
                                message: data.msg,
                                title: 'Sorry!',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });
                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        });
        //category edit
        $('.admin-edit-pr').on('click', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('href');
            $('.editAndCreateModal-body').empty();
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            $('.editAndCreateModal-body').html(data.render);
                            $('#editAndCreateModal').modal();
                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        });

        $('body').on('click', '.edit-cat-submit', function (e) {
            e.preventDefault();
            var inProgress = false;
            var form = $('#edit-cat-form');
            var url = form.attr('action');

            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'PUT',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'validator'){
                            $('#name').removeClass('is-invalid');
                            $('#commission').removeClass('is-invalid');
                            var objectFails = data.fails;
                            Object.keys(objectFails).map(function(objectKey, index) {
                                var value = objectFails[objectKey];
                                $.toaster({
                                    message: value[0],
                                    title: 'Sorry!',
                                    priority: 'danger',
                                    settings: {'timeout': 3000}
                                });
                                if(objectKey == 'name'){
                                    $('#name').addClass('is-invalid');
                                }else if(objectKey == 'commission'){
                                    $('#commission').addClass('is-invalid');
                                }
                            });
                        }else if(data.status == 'success'){
                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                            $('#editAndCreateModal').modal('hide');
                            window.location.reload();
                        }else if(data.status == 'error'){
                            $.toaster({
                                message: data.msg,
                                title: 'Sorry!',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });
                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        });

        //subcategories edit
        $('.admin-edit-subcat').on('click', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('href');
            var type = $(this).attr('data-type')
            $('.editAndCreateModal-body').empty();
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    data:{
                        type_edit : type
                    },
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            $('.editAndCreateModal-body').html(data.render);
                            $('#editAndCreateModal').modal();
                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        });

        $('body').on('click', '.edit-subcat-submit', function (e) {
            e.preventDefault();
            var inProgress = false;
            var form = $('#edit-subcat');
            var url = form.attr('action');

            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'PUT',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'validator'){
                            $('#name').removeClass('is-invalid');
                            $('#commission').removeClass('is-invalid');
                            var objectFails = data.fails;
                            Object.keys(objectFails).map(function(objectKey, index) {
                                var value = objectFails[objectKey];
                                $.toaster({
                                    message: value[0],
                                    title: 'Sorry!',
                                    priority: 'danger',
                                    settings: {'timeout': 3000}
                                });
                                if(objectKey == 'name'){
                                    $('#name').addClass('is-invalid');
                                }else if(objectKey == 'commission'){
                                    $('#commission').addClass('is-invalid');
                                }
                            });
                        }else if(data.status == 'success'){
                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                            $('#editAndCreateModal').modal('hide');
                            window.location.reload();
                        }else if(data.status == 'success-with-remove'){
                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                            $('#editAndCreateModal').modal('hide');
                            $('#subcat-block-'+data.idSubcat).remove();
                        }else if(data.status == 'error'){
                            $.toaster({
                                message: data.msg,
                                title: 'Sorry!',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });
                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        });
        //delete subcategories
        $('.admin-delete-subcat').on('click', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $(this).attr('href');
            $('.editAndCreateModal-body').empty();
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'get',
                    url: url,
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            $('.editAndCreateModal-body').html(data.render);
                            $('#editAndCreateModal').modal();
                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        });

        $('body').on('click', '.delete-subcat-submit', function (e) {
            e.preventDefault();
            var inProgress = false;
            var url = $('#delete-subcat').attr('action');
            var form = $('#delete-subcat');
            if (!inProgress) {
                $.ajax({
                    async: true,
                    method: 'delete',
                    url: url,
                    data: form.serialize(),
                    beforeSend: function () {
                        inProgress = true;
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        if(data.status == 'success'){
                            $('#subcat-block-'+data.subcat_id).remove();
                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'success',
                                settings: {'timeout': 3000}
                            });
                            $('#editAndCreateModal').modal('hide');
                            $('#editAndCreateModal').on('hidden.bs.modal', function (e) {
                                $('.editAndCreateModal-body').empty();
                            });
                        }else if(data.status == 'danger'){
                            $.toaster({
                                message: data.msg,
                                title: '',
                                priority: 'danger',
                                settings: {'timeout': 3000}
                            });

                            $('#editAndCreateModal').modal('hide');
                            $('#editAndCreateModal').on('hidden.bs.modal', function (e) {
                                $('.editAndCreateModal-body').empty();
                            });

                        }
                    },
                    error: function (data) {
                        $.toaster({
                            message: "Ошибка сервера!",
                            title: 'Sorry!',
                            priority: 'danger',
                            settings: {'timeout': 3000}
                        });
                    }
                });
            }
        });

        //(end)Создание и изменение категорий модалка






    });
})(jQuery);