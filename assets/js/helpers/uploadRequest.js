var uploadRequest = function (data) {
    return new Promise(function (resolve, reject) {
        const allowedMethods = ['POST', 'PUT'];

        if (allowedMethods.indexOf(data.method) === -1) {
            throw `${data.method} not allowed for an upload transfer.`;
        }

        var xhr = new XMLHttpRequest();
        xhr.open(data.method, data.url, true);

        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        // Success&complete
        xhr.addEventListener('load', function () {
            if (typeof data.complete === 'function') {
                data.complete(JSONResponse());
            }
            if (typeof data.success === 'function') {
                if (this.readyState === 4) {
                    if (JSONResponse().location) {
                        window.location = JSONResponse().location;
                    }
                    data.success(JSONResponse());
                    resolve(JSONResponse());
                }
            }
        });

        // Error
        xhr.addEventListener('error', function () {
            if (typeof data.success === 'function') {
                data.failure();
                reject(this.response);
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
    });
};

export default uploadRequest;