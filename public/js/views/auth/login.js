// event handlers
$("#submitLogin").on("submit", (e) => {
    e.preventDefault();

    email = $("#email").val();
    pwd = $("#pwd").val();

    if (email == "" || pwd == "") {
        errorHandler("* Debe ingresar todos los campos");
        $("#alerta").css("display", "block");
    } else {
        url = "/auth/login";
        data = { email: email, pwd: pwd };
        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: (data) => {
                if (data == 0) {
                    window.open("menu", "_self");
                }
                if (data == 1) {
                    //window.open('ordenes','_self');
                    window.open("menu", "_self");
                }
                if (data == 2) {
                    //window.open('ordenes','_self');
                    window.open("menu", "_self");
                }
                if (data == 10) {
                    //window.open('ordenes','_self');
                    window.open("menu", "_self");
                }
                if (data != 0 && data != 1 && data != 2 && data != 10) {
                    errorHandler("* Datos inválidos");
                    $("#alerta").css("display", "block");
                }
            },
        });
    }
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
