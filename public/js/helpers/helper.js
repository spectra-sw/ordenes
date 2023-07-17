const restFetchForm = (url, formID, inputsID, successFunction) => {
    const formData = new FormData($(`#${formID}`)[0]);
    const namesInputID = {};
    const data = {};
    let index = 0;

    formData.forEach((value, key) => {
        if (data.hasOwnProperty(key) && Array.isArray(data[key])) {
            return (data[key] = [...data[key], value]);
        }

        if (data.hasOwnProperty(key)) {
            return (data[key] = [data[key], value]);
        }

        data[inputsID[index]] = value;
        namesInputID[inputsID[index]] = key;

        $(`#${key}`).removeClass("is-invalid");
        $(`#${key}_e`).text("");

        index++;
    });

    $.ajax({
        url: url,
        type: "GET",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
            successFunction(response);
        },
        error: (error) => {
            // alert all errors
            for (const key in error.responseJSON.errors) {
                if (key.includes(".")) {
                    const keySplit = key.split(".");
                    $(`#${namesInputID[keySplit[0]]}_e`).text(
                        error.responseJSON.errors[key][0]
                    );
                    console.log(
                        keySplit[0],
                        `#${namesInputID[keySplit[0]]}_e`,
                        $(`#${namesInputID[keySplit[0]]}_e`)[0]
                    );
                }

                if (!key.includes(".")) {
                    $(`#${namesInputID[key]}`).addClass("is-invalid");
                    $(`#${namesInputID[key]}_e`).text(
                        error.responseJSON.errors[key][0]
                    );
                }
            }
        },
    });
};
