const restFetchForm = (url, formID, keys_name, successFunction) => {
    const formData = new FormData($(`#${formID}`)[0]);
    const refKeys = {}
    const data = {};
    let idx = 0;

    formData.forEach((value, key) => {
        data[keys_name[idx]] = value;
        refKeys[keys_name[idx]] = key;

        $(`#${key}`).removeClass('is-invalid');
        $(`#${key}_e`).text("")

        idx++;
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
                $(`#${refKeys[key]}`).addClass('is-invalid');
                $(`#${refKeys[key]}_e`).text(error.responseJSON.errors[key][0])
            }
        },
    });
};
