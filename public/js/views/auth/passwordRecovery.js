// event handlers
$("#submitEmailRecovery").on("submit", (e) => {
    e.preventDefault();

    const email = $("#email").val();

    const url = "/auth/send-email-recovery";
    const data = { email };

    $.ajax({
        url: url,
        type: "GET",
        data: data,
        success: (response) => {
            alert(response.message);
        },
        error: (error) => {
            errorHandler(error.responseJSON.errors.email[0]);
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
