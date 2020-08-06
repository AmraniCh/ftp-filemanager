import fetchConfig from "../config/fetchConfig";

const fetchGet = function (uri, success) {
    fetch(uri, fetchConfig.options)
        .then(response => {
            const contentType = response.headers.get('Content-type');
            if (contentType && contentType.indexOf('application/json') !== -1) {
                return response.json().then((json) => {
                    if (response.ok) {
                        success(json);
                        return response;
                    }
                    return Promise.reject(json.error);
                });
            }
        })
        .catch((err) => {
            fetchConfig.errorHandler(err);
        });
};

export {
    fetchGet
};