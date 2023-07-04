const restFetchForm = (url, formID, inputsID, successFunction) => {
    const formData = new FormData($(`#${formID}`)[0]);
    const namesInputID = {}
    const data = {};
    let index = 0;

    formData.forEach((value, key) => {
        data[inputsID[index]] = value;
        namesInputID[inputsID[index]] = key;

        $(`#${key}`).removeClass('is-invalid');
        $(`#${key}_e`).text("")

        index++;
    });

    $.ajax({
        url: url,
        type: "GET",
        data: data,
        success: (response) => {
            successFunction(response);
        },
        error: (error) => {
            // alert all errors
            for (const key in error.responseJSON.errors) {
                $(`#${namesInputID[key]}`).addClass('is-invalid');
                $(`#${namesInputID[key]}_e`).text(error.responseJSON.errors[key][0])
            }
        },
    });
};
