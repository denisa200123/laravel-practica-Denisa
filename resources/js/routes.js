$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadTranslations();

    // Move handling/control functions in their respective files, after the view

    //change language form
    $(document).on('change', '#languageForm', function (e) {
        e.preventDefault();
        
        let languageData = $(this).serialize();
        $.ajax({
            url: '/set-language',
            type: 'post',
            dataType: 'json',
            data: languageData,
            success: function () {
                location.reload();
            },
        });
    });

    //checkout form
    $('.checkoutForm').on('submit', function (e) {
        e.preventDefault();

        let checkoutData = $(this).serialize();

        $.ajax({
            type: 'post',
            url: '/checkout',
            dataType: 'json',
            data: checkoutData,
            success: function (response) {
                window.location.hash = '#';
                success(response.success);
            },
        });
    });

    //login form
    $('.loginForm').on('submit', function (e) {
        e.preventDefault();

        let loginData = $(this).serialize();

        $.ajax({
            type: 'post',
            url: '/login',
            dataType: 'json',
            data: loginData,
            success: function (response) {
                updateHeader();
                window.location.hash = '#';
                success(response.success);
            },
            error: function (response) {
                $('.laravelError').remove();

                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (field, errors) {
                        let errorHtml = `<div class="laravelError alert-danger">${errors[0]}</div>`;
                        $(`#${field}`).after(errorHtml);
                    });
                }

                if (response.responseJSON.error) {
                    showError(response.responseJSON.error);
                }
            }
        });
    });

    //order and search products form
    // TODO: Rename to something like productSearchSortForm
    $('.orderProductsForm').on('submit', function (e) {
        e.preventDefault();
        let orderData = $(this).serialize();

        $.ajax({
            url: '/products',
            dataType: 'json',
            data: orderData,
            success: function (response) {
                $('.products .list').html(renderProducts(response.data));
                $('.products .pagination').html(renderPagination(response));
            },
            error: function (response) {
                showError(response.responseJSON.error);
            }
        });
    });

    // TODO: Merge edit and create

    //edit form
    $('.editProductForm').on('submit', function (e) {
        e.preventDefault();

        let editForm = new FormData();
        editForm.append('_method', 'PATCH');

        editForm.append('title', $('#title').val());
        editForm.append('description', $('#description').val());
        editForm.append('price', $('#price').val());

        if ($('#image')[0].files[0]) {
            editForm.append('image', $('#image')[0].files[0]);
        }

        let productToEdit = window.location.hash.split('#show/')[1];
        $.ajax({
            type: 'POST',
            url: `/products/${productToEdit}`,
            dataType: 'json',
            data: editForm,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                window.location.hash = '#products';
                success(response.success);
            },
            error: function (response) {
                $('.laravelError').remove();

                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (field, errors) {
                        let errorHtml = `<div class="laravelError alert-danger">${errors[0]}</div>`;
                        $(`#${field}`).after(errorHtml);
                    });
                }
            }
        });
    });

    //create form
    $('.createProductForm').on('submit', function (e) {
        e.preventDefault();

        let createForm = new FormData();

        createForm.append('title', $('#title').val());
        createForm.append('description', $('#description').val());
        createForm.append('price', $('#price').val());
        createForm.append('image', $('#image')[0].files[0]);

        $.ajax({
            type: 'POST',
            url: '/products',
            dataType: 'json',
            data: createForm,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                window.location.hash = '#products';
                success(response.success);
            },
            error: function (response) {
                $('.laravelError').remove();

                if (response.responseJSON.errors) {
                    $.each(response.responseJSON.errors, function (field, errors) {
                        let errorHtml = `<div class="laravelError alert-danger">${errors[0]}</div>`;
                        $(`#${field}`).after(errorHtml);
                    });
                }
            }
        });
    });

    window.onhashchange = function () {
        $('.page').hide();

        switch (window.location.hash) {
            //cart page
            case '#cart':
                $('.cart').show();
                $.ajax({
                    url: '/cart',
                    dataType: 'json',
                    success: function (response) {
                        document.title = __('Your cart');
                        $('.cart .list').html(renderCart(response));
                        applyTranslations();
                    }
                });
                break;

            //add product to cart
            case (window.location.hash.match(/#add\/\d+/) || {}).input:
                $('.index').show();
                let productToAdd = window.location.hash.split('#add/')[1];
                $.ajax({
                    type: 'post',
                    url: `/cart/${productToAdd}/add`,
                    dataType: 'json',
                    success: function (response) {
                        window.location.hash = '#';
                        success(response.success);
                    },
                    error: function (response) {
                        window.location.hash = '#';
                        showError(response.responseJSON.error);
                    }
                });
                break;

            //remove product from cart
            case (window.location.hash.match(/#remove\/\d+/) || {}).input:
                $('.cart').show();
                let productToRemove = window.location.hash.split('#remove/')[1];
                $.ajax({
                    type: 'post',
                    url: `/cart/${productToRemove}/remove`,
                    dataType: 'json',
                    success: function (response) {
                        window.location.hash = '#cart';
                        success(response.success);
                    },
                    error: function (response) {
                        window.location.hash = '#cart';
                        showError(response.responseJSON.error);
                    }
                });
                break;

            //login page
            case '#login':
                $.ajax({
                    url: '/login',
                    dataType: 'json',
                    success: function () {
                        document.title = __('Login');
                        $('.login').show();
                        $('.login .loginForm').html(renderLoginForm());
                        applyTranslations();
                    }
                });
                break;

            //logout
            case '#logout':
                $.ajax({
                    url: '/logout',
                    dataType: 'json',
                    success: function (response) {
                        updateHeader();
                        window.location.hash = '#';
                        success(response.success);
                    }
                });
                break;

            //products page
            case '#products':
                $.ajax({
                    url: '/products?page=1',
                    dataType: 'json',
                    success: function (response) {
                        document.title = __('Products');
                        $('.products').show();
                        $('.products .list').html(renderProducts(response.data));
                        $('.products .orderProductsForm').html(renderOrderProductsForm());
                        $('.products .pagination').html(renderPagination(response));
                        applyTranslations();
                    },
                });
                break;

            //destroy product
            case (window.location.hash.match(/#delete\/\d+/) || {}).input:
                let productToDelete = window.location.hash.split('#delete/')[1];
                $.ajax({
                    method: 'DELETE',
                    url: `/products/${productToDelete}`,
                    dataType: 'json',
                    success: function (response) {
                        $('.products').show();
                        window.location.hash = '#products';
                        success(response.success);
                    },
                    error: function (response) {
                        window.location.hash = '#products';
                        showError(response.responseJSON.error);
                    }
                });
                break;

            //create product page
            case '#show':
                $.ajax({
                    url: '/products/show',
                    dataType: 'json',
                    success: function () {
                        document.title = __('Create product');
                        $('.create').show();
                        $('.create .createProductForm').html(renderCreateProductForm());
                        applyTranslations();
                    },
                });
                break;

            //edit product page
            case (window.location.hash.match(/#show\/\d+/) || {}).input:
                let productToEdit = window.location.hash.split('#show/')[1];
                $.ajax({
                    url: `/products/show/${productToEdit}`,
                    dataType: 'json',
                    success: function (response) {
                        document.title = __('Edit product');
                        $('.edit').show();
                        $('.edit .editProductForm').html(renderEditProductForm(response));
                        applyTranslations();
                    },
                    error: function (response) {
                        window.location.hash = '#products';
                        showError(response.responseJSON.error);
                    }
                });
                break;

            //orders page
            case '#orders':
                $.ajax({
                    url: '/orders',
                    dataType: 'json',
                    success: function (response) {
                        document.title = __('Orders');
                        $('.orders').show();
                        $('.orders .list').html(renderOrders(response));
                        applyTranslations();
                    },
                    error: function (response) {
                        showError(response.responseJSON.error);
                    }
                });
                break;

            //order page
            case (window.location.hash.match(/#order\/\d+/) || {}).input:
                let order = window.location.hash.split('#order/')[1];
                $.ajax({
                    url: `/orders/${order}`,
                    dataType: 'json',
                    success: function (response) {
                        document.title = __('Order');
                        $('.order').show();
                        $('.order h2').html(`Id: ${order}`);
                        $('.order .list').html(renderOrder(response));
                        applyTranslations();
                    },
                    error: function (response) {
                        window.location.hash = '#orders';
                        showError(response.responseJSON.error);
                    }
                });
                break;

            //index page
            default:
                $('.index').show();
                $.ajax({
                    url: '/',
                    dataType: 'json',
                    success: function (response) {
                        document.title = __('Shop');
                        $('.index .list').html(renderIndex(response));
                        applyTranslations();
                    }
                });
                break;
        }
    }

    window.onhashchange();
});
