const fetchConfig = {

    get: {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    },

    post: {
        method: 'POST',
        headers: {
            'Content-type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    },

    put: {
        method: 'PUT',
        headers: {
            'Content-type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    },

    delete: {
        method: 'DELETE',
        headers: {
            'Content-type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    },

    errorHandler: function (res) {
        if (res.location) {
            window.location = res.location;
        }
    },
};

export default fetchConfig;