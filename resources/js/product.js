window.renderCreateProductForm = function () {
    let htmlCreateForm = `
        <label for="title" class="translatable" data-key="Name"></label>
        <input type="text" id="title" name="title" required>
        <label for="price" class="translatable" data-key="Price"></label>
        <input type="number" name="price" id="price" step="0.01" min="0" required>
        <label for="description" class="translatable" data-key="Description"></label>
        <input type="text" id="description" name="description">
        <label for="image" class="translatable" data-key="Image"></label>
        <input type="file" name="image" id="image" required>

        <button type="submit" class="btn btn-success translatable" data-key="Create"></button>
    `;
    return htmlCreateForm;
}

window.renderEditProductForm = function (product) {
    let htmlEditForm = `
        <input type="text" id="title" name="title" value="${product.title}">
        <input type="number" name="price" id="price" step="0.01" min="0" value="${product.price}">
        <input type="text" id="description" name="description" value="${product.description}">
        <input type="file" name="image" id="image">

        <button type="submit" class="btn btn-warning translatable" data-key="Edit"></button>
    `;
    return htmlEditForm;
}
// TODO: rollback to reproduce the error
window.submitProductForm = function (isEdit = false) {
    let productForm = new FormData();
    productForm.append('title', $('#title').val());
    productForm.append('description', $('#description').val());
    productForm.append('price', $('#price').val());

    if ($('#image')[0].files[0]) {
        productForm.append('image', $('#image')[0].files[0]);
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
            $('.createProductForm').empty();
            $('.editProductForm').empty();
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

// TODO: Merge edit and create
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
