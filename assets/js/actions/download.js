function download(path, files) {
    if (Array.isArray(files)) {
        files.forEach(function (file) {
            window.open('api?action=download&file=' + encodeURIComponent(path + file), '_blank');
        });
    }
}

export default download;