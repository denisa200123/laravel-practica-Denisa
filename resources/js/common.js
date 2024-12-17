window.displayProductDetails = function() {
    let html = [
        '<th class="translatable" data-key="Name"></th>',
        '<th class="translatable" data-key="Description"></th>',
        '<th class="translatable" data-key="Price"></th>',
        '<th class="translatable" data-key="Image"></th>',
    ]
    return html;
}

window.displayProduct = function(product) {
    let html = [
        '<td>' + product.title + '</td>',
        '<td>' + product.description + '</td>',
        '<td>' + product.price + '</td>',
        `<td><img src="images/${product.image_path}"></td>`,
    ]
    return html;
}

window.success = function(message) {
    $('.success').html(message);
    $('.success').css('display', 'block');
    $('.success').fadeOut(2000);
}

window.showError = function(message) {
    $('.error').html(message);
    $('.error').css('display', 'block');
    $('.error').fadeOut(2000);
}

window.updateHeader = function(){
    $.ajax({
        url: '/spa/header',
        success: function (html) {
            $('header').html(html);
        }
    });
}

let translations = {};

window.loadTranslations = function(callback) {
    $.ajax({
        url: '/spa/translations',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('LoadTranslations success');
            translations = response;
            if (callback) callback();
        },
    });
}

window.loadTranslationsAsync = async function () {
    try {
        const response = await $.ajax({
            url: '/spa/translations',
            type: 'GET',
            dataType: 'json'
        });
        console.log('LoadTranslationsAsync success');
        translations = response;
    } catch (error) {
        console.error('Failed to load translations');
    }
};

window.applyTranslations = function() {
    $('.translatable').each(function() {
        let key = $(this).data('key');
        $(this).text(__(key)).removeClass('translatable');
    });
}

window.__ = function(key) {
    return translations[key] || key;
}
