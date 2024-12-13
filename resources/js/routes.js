$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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

    window.onhashchange = function () {
        $('.page').hide();

        switch(window.location.hash) {
            //cart page
            case '#cart':
                $('.cart').show();
                $.ajax({
                    url: '/cart',
                    dataType: 'json',
                    success: function (response) {
                        document.title = 'Your cart';
                        $('.cart .list').html(renderCart(response));
                    }
                });
                break;

            //add product to cart
            case (window.location.hash.match(/#add\/\d+/) || {}).input:
                $('.index').show();
                let addedProduct = window.location.hash.split('#add/')[1];
                $.ajax({
                    type: 'post',
                    url: `/cart/${addedProduct}/add`,
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
                let removedProduct = window.location.hash.split('#remove/')[1];
                $.ajax({
                    type: 'post',
                    url: `/cart/${removedProduct}/remove`,
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
                        document.title = 'Login';
                        $('.login').show();
                        $('.login .loginForm').html(renderLoginForm());
                    }
                });
                break;

            //logout
            case '#logout':
                $.ajax({
                    url: '/logout',
                    dataType: 'json',
                    success: function (response) {
                        window.location.hash = '#';
                        success(response.success);
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
                        document.title = 'Home';
                        $('.index .list').html(renderIndex(response));
                    }
                });
                break;
        }
    }

    window.onhashchange();
});
