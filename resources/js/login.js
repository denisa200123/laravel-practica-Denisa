window.renderLoginForm = function () {
    let htmlLoginForm = `
        <label for="username" class="translatable" data-key="Username:"></label>
        <input type="text" id="username" name="username" required">

        <label for="password" class="translatable" data-key="Password:"></label>
        <input type="password" id="password" name="password" required">

        <br>

        <button type="submit" class="btn btn-primary translatable" data-key="Login"></button>
    `;
    return htmlLoginForm;
}

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
