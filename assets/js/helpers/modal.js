import {getElement} from "./functions";

var modal = function (modalId) {
    const
        ele = getElement(modalId),
        errorDiv = ele.querySelector('.alert.error');

    return {

        show: function () {
            errorDiv.classList.remove('show');
            ele.classList.add('show');
            getElement('.modal-overlay').classList.add('show');

            return this;
        },

        showError: function (err) {
            errorDiv.classList.add('show');
            errorDiv.textContent = err;

            // hide the error after 5 secs
            setTimeout(function () {
                errorDiv.classList.remove('show');
            }, 5000);

            return this;
        },

        close: function () {
            ele.classList.remove('show');
            getElement('.modal-overlay').classList.remove('show');

            return this;
        },
    };
};

export default modal;