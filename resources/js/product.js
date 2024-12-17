window.renderCreateProductForm = function () {
    let htmlCreateForm = `
        <label for="create_title" class="translatable" data-key="Name"></label>
        <input type="text" id="create_title" name="title" required>
        <label for="create_price" class="translatable" data-key="Price"></label>
        <input type="number" name="price" id="create_price" step="0.01" min="0" required>
        <label for="create_description" class="translatable" data-key="Description"></label>
        <input type="text" id="create_description" name="description">
        <label for="create_image" class="translatable" data-key="Image"></label>
        <input type="file" name="image" id="create_image" required>

        <button type="submit" class="btn btn-success translatable" data-key="Create"></button>
    `;
    return htmlCreateForm;
}

window.renderEditProductForm = function (product) {
    let htmlEditForm = `
        <input type="text" id="edit_title" name="title" value="${product.title}">
        <input type="number" name="price" id="edit_price" step="0.01" min="0" value="${product.price}">
        <input type="text" id="edit_description" name="description" value="${product.description}">
        <input type="file" name="image" id="edit_image">

        <button type="submit" class="btn btn-warning translatable" data-key="Edit"></button>
    `;
    return htmlEditForm;
}

window.submitProductForm = function (isEdit = false) {
    let prefix = isEdit ? 'edit_' : 'create_';

    let productForm = new FormData();
    productForm.append('title', $(`#${prefix}title`).val());
    productForm.append('description', $(`#${prefix}description`).val());
    productForm.append('price', $(`#${prefix}price`).val());

    if ($(`#${prefix}image`)[0].files[0]) {
        productForm.append('image', $(`#${prefix}image`)[0].files[0]);
    }

    let url = '/products';
    if (isEdit) {
        let productToEdit = window.location.hash.split('#show/')[1];
        productForm.append('_method', 'PATCH');
        url += `/${productToEdit}`;
    }

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: productForm,
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
};

//edit form
$('.editProductForm').on('submit', function (e) {
    e.preventDefault();
    submitProductForm(true);
});

//create form
$('.createProductForm').on('submit', function (e) {
    e.preventDefault();
    submitProductForm(false);
});
