/**
 * Gets sidebar selected path tree.
 * @return {string}
 */
function getSelectedPath() {
    const element = document.querySelector('.sidebar .dir-item[data-open="true"]');

    if (!element) {
        return '/';
    }

    var
        child = element.querySelector('.dir-item[data-open="true"]'),
        path = element.dataset.name;

    while (child) {
        path += '/' + child.dataset.name;
        child = child.querySelector('.dir-item[data-open="true"]');
    }

    return path + '/';
}
/**
 * Closes the sibling tree of the passed element
 */
function closeSiblingTreeOf(element) {
    var
        result = [],
        node = element.parentNode.firstChild;

    while (node) {
        if (node !== element && node.nodeType === Node.ELEMENT_NODE) {
            result.push(node);
        }

        node = node.nextElementSibling || node.nextSibling;
    }

    result.forEach(function (item) {
        if (item.classList.contains('dir-item') && item.dataset.open === 'true') {
            item.dataset.open = 'false';
            item.querySelector('.sub-files').textContent = '';

            var child = item.querySelector('.dir-item[data-open="true"]');

            while (child) {
                child.dataset.open = 'false';
                child = item.querySelector('.dir-item[data-open="true"]');
            }
        }
    });
}

/**
 * Gets the element that will receive the next request files content
 * @param {string} path
 * @return {string}
 */
function getAppendToSelector(path)
{
    if (path !== '/') {
        const name = path.slice(0, -1).split('/').pop();
        return `.sidebar .dir-item[data-name="${name}"] .sub-files`;
    }

    return '.sidebar .files-list';
}

export {
    getSelectedPath,
    closeSiblingTreeOf,
    getAppendToSelector
};