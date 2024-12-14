window.renderCreateProductForm = function () {
    let htmlCreateForm = `
        <label for="title" class="translatable" data-key="Name"></label>
        <input type="text" id="title" name="title" required>
        <label for="price" class="translatable" data-key="Price"></label>
        <input type="number" name="price" id="price" step="0.01" min="0" required>
        <label for="description" class="translatable" data-key="Description"></label>
        <input type="text" id="description" name="description" required>
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
