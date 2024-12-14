<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @vite('resources/js/routes.js')
        @vite('resources/js/common.js')
        @vite('resources/js/index.js')
        @vite('resources/js/cart.js')
        @vite('resources/js/login.js')
        @vite('resources/js/products.js')
        @vite('resources/js/product.js')
        @vite('resources/js/orders.js')

        <style>
            img {
                width: 150px;
                height: auto;
            }

            table {
                width: 1000px;
                height: fit-content;
            }

            form {
                display: flex;
                flex-direction: column;
                width: fit-content;
                height: fit-content;
            }
        </style>
    </head>

    <body>
        <x-header-spa />

        <p class="success alert alert-success" style="display: none;"></p>
        <p class="error alert alert-danger" style="display: none;"></p>

        <div class="page index" style="margin: 10px;">
            <h2>{{ __('What you can buy:') }}</h2>
            <table class="list" border="1" cellpadding="10"></table>
        </div>

        <div class="page cart" style="margin: 10px;">
            <h2>{{ __('Your cart') }}</h2>
            <div style="display: flex; gap: 100px;">
                <table class="list" border="1" cellpadding="10"></table>
                <form class="checkoutForm"></form>
            </div>
        </div>
        
        <div class="page login" style="margin: 50px;">
            <h2>{{ __('Login info') }}</h2>
            <form class="loginForm"></form>
        </div>

        <div class="page products" style="margin: 10px;">
            <h2>{{ __('All the products:') }}</h2>
            <form class="orderProductsForm" style="width: fit-content; height: fit-content; display: flex"></form>
            <br>
            <table class="list" border="1" cellpadding="10"></table>
            <div class="pagination"></div>
        </div>

        <div class="page edit" style="margin: 10px;">
            <h2>{{ __('Edit product') }}</h2>
            <form class="editProductForm"></form>
        </div>

        <div class="page create" style="margin: 10px;">
            <h2>{{ __('Create product') }}</h2>
            <form class="createProductForm"></form>
        </div>

        <div class="page orders" style="margin: 10px;">
            <h2>{{ __('Orders') }}</h2>
            <table class="list" border="1" cellpadding="10"></table>
        </div>

        <div class="page order" style="margin: 10px;">
            <h2></h2>
            <table class="list" border="1" cellpadding="10"></table>
        </div>
    </body>
</html>
