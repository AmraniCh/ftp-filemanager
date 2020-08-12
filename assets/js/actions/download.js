function download(file) {
    window.open('api?action=download&file=' + encodeURIComponent(file));
}

export default download;