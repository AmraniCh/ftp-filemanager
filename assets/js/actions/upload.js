import uploadRequest from "../helpers/uploadRequest";

var upload = function () {
    /**
     * Store an array of promises results.
     *
     * @type {Array}
     */
    this.stack = [];

    /**
     * Register a promise in the stack.
     *
     * @param {string} path
     * @param {string} data
     * @param {string} onprogress
     * @param {string} onerror
     */
    this.push = function (path, data, onprogress, onerror) {
        this.stack.push(uploadRequest({
            method: 'POST',
            url: 'api?action=upload',
            data: data,
            success: function (res) {
                if (res.error) {
                    onerror(res.error);
                }
            },
            progress: function (info) {
                const percentage = (info.loaded / info.total) * 100;
                onprogress(parseInt(percentage.toFixed()));
            }
        }));
    };

    /***
     * Resolves the promises stack.
     *
     * @param {function} resolver
     */
    this.resolveStack = function (resolver) {
        Promise.all(this.stack).then(function (responses) {
            resolver(responses);
        });
    };
};

export default upload;