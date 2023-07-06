// event handlers
$("#submitEmailRecovery").on("submit", (e) => {
    e.preventDefault();
    // get the token from the url
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const code = urlParams.get("code");

    // get password and password_confirmation
    const password = $("#password1").val();
    const password_confirmation = $("#password2").val();

    const url = "/auth/password-update";
    const data = { password, password_confirmation, code };

    $.ajax({
        url: url,
        type: "GET",
        data: data,
        success: (response) => {
            alert(response.message);
            window.location.href = "/";
        },
        error: (error) => {
            for (const key in error.responseJSON.errors) {
                console.log(error.responseJSON.errors[key][0]);
                errorHandler(error.responseJSON.errors[key][0])
            }
            $("#alerta").css("display", "block");
        },
    });
});

// functions
const errorHandler = (mensaje) => {
    $.ajax({
        type: "GET",
        url: "/mensaje/error",
        data: { mensaje: mensaje },
        success: (response) => {
            $("#mensaje").html(response);
        },
    });
};
