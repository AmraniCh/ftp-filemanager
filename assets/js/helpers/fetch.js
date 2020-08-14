import fetchConfig from "../config/fetchConfig";

const doFetch = function (uri, options, successHandler, errorHandler = null, completeHandler = null) {
    fetch(uri, options)
        .then(response => {
            const contentType = response.headers.get('Content-type');
            if (contentType && contentType.indexOf('application/json') !== -1) {
                return response.json().then((json) => {
                    if (response.ok) {
                        callHandler(successHandler, json);
                    } else {
                        callHandler(completeHandler, json);
                        return Promise.reject(json);
                    }
                    callHandler(completeHandler, json);
                    return json;
                });
            }
        })
        .catch((json) => {
            fetchConfig.errorHandler(json);
            callHandler(errorHandler, json.error);
        });

    var callHandler = function (handler) {
        if (typeof handler === 'function') {
            handler.apply(this, Array.prototype.slice.call(arguments, 1));
        }
    };
};

const fetchGet = function (uri, success, error, complete) {
    doFetch(uri, fetchConfig.get, success, error, complete);
};

const fetchUpdate = function (method, uri, data, success, error, complete) {
    const allowedMethods = ['POST', 'PUT', 'PATCH'];

    if (!allowedMethods.includes(method)) {
        throw `fetchUpdate accept only ${allowedMethods.join(', ')}, ${method} giving.`;
    }

    doFetch(uri, Object.assign(fetchConfig[method.toLowerCase()], {
        body: JSON.stringify(data),
    }), success, error, complete);
};

const fetchDelete = function (uri, data, success, error, complete) {
    doFetch(uri, Object.assign(fetchConfig.delete, {
        body: JSON.stringify(data),
    }), success, error, complete);
};

export {
    fetchGet,
    fetchUpdate,
    fetchDelete,
};