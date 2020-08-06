const fetchConfig = {
    options: {
        headers: {
            'Accept': 'application/json'
        }
    },

    errorHandler: function (err) {
        alert('error');
    }
};

export default fetchConfig;