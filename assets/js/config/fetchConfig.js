const fetchConfig = {

    get: {
        headers: {
            'Accept': 'application/json'
        }
    },

    post: {
        method: 'POST',
        headers: {
            'Content-type': 'application/json'
        }
    },

    put: {
        method: 'PUT',
        headers: {
            'Content-type': 'application/json'
        }
    },

    patch: {
        method: 'PATCH',
        headers: {
            'Content-type': 'application/json'
        }
    },

    // Global error handler
    errorHandler: function (err) {

    },
};

export default fetchConfig;