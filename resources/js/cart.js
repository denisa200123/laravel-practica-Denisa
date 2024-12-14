window.renderCart = function(products) {
    let html = [
        '<tr>',
            displayProductDetails(),
            '<th class="translatable" data-key="Remove"></th>',
        '</tr>'
    ].join('');

    $.each(products, function (key, product) {
        html += [
            '<tr>',
                displayProduct(product),
                `<td><a href="#remove/${product.id}" class="translatable" data-key="Remove product"></a></td>`,
            '</tr>'
        ].join('');
    });

    let htmlCheckoutForm = `
        <label for="name" class="translatable" data-key="Name"></label>
        <input type="text" id="name" name="name" required>

        <label for="details" class="translatable" data-key="Contact details"></label>
        <input type="text" id="details" name="details" required">

        <label for="comments" class="translatable" data-key="Comments"></label>
        <textarea id="comments" name="comments"></textarea>

        <br>

        <button type="submit" class="btn btn-primary translatable" data-key="Checkout"</button>
    `;

    if(products.length > 0) {
        $('.cart .checkoutForm').html(htmlCheckoutForm);
    }

    return html;
}
