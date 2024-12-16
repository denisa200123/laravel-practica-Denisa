window.renderProducts = function(products) {
    let html = [
        '<tr>',
            displayProductDetails(),
            '<th class="translatable" data-key="Edit"></th>',
            '<th class="translatable" data-key="Delete"></th>',
        '</tr>'
    ].join('');

    $.each(products, function (key, product) {
        html += [
            '<tr>',
                displayProduct(product),
                `<td><a href="#show/${product.id}" class="translatable" data-key="Edit"></a></td>`,
                `<td><a href="#delete/${product.id}" class="translatable" data-key="Delete"></a></td>`,
            '</tr>'
        ].join('');
    });

    return html;
}

// Keep search, sort and pagination in the URL
window.renderOrderProductsForm = function(value) {
    let html = [
        '<select name="orderBy" id="orderBy">',
            '<option value="" class="translatable" data-key="None"></option>',
            `<option value="title" ${value === 'title' ? "selected" : ""} class="translatable" data-key="Name"></option>`,
            `<option value="price" ${value === 'price' ? "selected" : ""} class="translatable" data-key="Price"></option>`,
            `<option value="description" ${value === 'description' ? "selected" : ""} class="translatable" data-key="Description"></option>`,
        
            '</select>',
        '<input type="text" name="searchBy" id="searchBy" placeholder="Search">',

        '<button type="submit" class="btn btn-primary translatable" data-key="Apply"</button>'
    ].join('');

    return html;
}

window.renderPagination = function(response) {
    let paginationHtml = '';

    if (response.prev_page_url) {
        paginationHtml += `<button onclick="loadProducts('${response.prev_page_url}')" class="translatable" data-key="Previous"></button>`;
    }
    if (response.next_page_url) {
        paginationHtml += `<button onclick="loadProducts('${response.next_page_url}')" class="translatable" data-key="Next"></button>`;
    }

    return paginationHtml;
}

window.loadProducts = function(url) {
    $.ajax({
        url: url,
        dataType: 'json',
        success: function (response) {
            $('.products .list').html(renderProducts(response.data));
            $('.products .pagination').html(renderPagination(response));
            $('.products .translatable').each(function() {
                let key = $(this).data('key');
                $(this).text(__(key));
            });
        }
    });
}
