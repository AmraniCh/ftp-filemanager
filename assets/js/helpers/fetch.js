import fetchConfig from "../config/fetchConfig";

const fetchGet = function (uri, success) {
    fetch(uri, fetchConfig.options)
        .then(response => {
            const contentType = response.headers.get('Content-type');
            if (contentType && contentType.indexOf('application/json') !== -1) {
                if (response.ok) {
                    return response.json();
                }
                return Promise.reject(response.error);
            }
        }).then(response => success(response))
        .catch((err) => {
            fetchConfig.errorHandler(err);
        });
};

export {
    fetchGet
};