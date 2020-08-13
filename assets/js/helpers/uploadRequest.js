var uploadRequest = function (data) {
    const allowedMethods = ['POST', 'PUT'];

    if (allowedMethods.indexOf(data.method) === -1) {
        throw `${data.method} not allowed for upload transfer.`;
    }

    var xhr = new XMLHttpRequest();
    xhr.open(data.method, data.url, true);

    xhr.setRequestHeader('Accept', 'application/json');

    // Success&complete
    xhr.addEventListener('load', function () {
        if (typeof data.complete === 'function') {
            data.complete(JSONResponse());
        }
        if (typeof data.success === 'function') {
            if (this.readyState === 4) {
                data.success(JSONResponse());
            }
        }
    });

    // Error
    xhr.addEventListener('error', function () {
        if (typeof data.success === 'function') {
            data.failure();
        }
    });

    // Progress
    xhr.upload.addEventListener('progress', function (e) {
        if (typeof data.progress === 'function') {
            data.progress(e);
        }
    });

    xhr.send(data.data);

    var JSONResponse = function () {
        return JSON.parse(xhr.response);
    };
};

export default uploadRequest;