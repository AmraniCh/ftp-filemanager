// Very simple object to wrap the FTP Filemanager functionalities
var FileManager = function () {

    // onload handler
    FileManager.prototype.onload = function (handler) {
        window.addEventListener('load', function () {
            handler();
        });
    };

};

var fm = new FileManager();

// Define the onload handler
fm.onload(function () {
    document.querySelector('.overlay').classList.add('hide');
});
