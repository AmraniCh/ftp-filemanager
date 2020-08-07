/**
 * Gets sidebar selected path tree.
 * @return {string}
 */
function getSelectedPath() {
    const ele = document.querySelector('.sidebar .dir-item[data-open="true"]');

    if (!ele) {
        return '/';
    }

    var child = ele.querySelector('.sidebar .dir-item[data-open="true"]'),
        path = ele.dataset.name;

    while (child) {
        path += '/' + child.dataset.name;
        child = child.querySelector('.dir-item[data-open="true"]');
    }

    return path;
}

/**
 * Closes all sibling directories of passed element.
 */
function closeSublingTreeOf(element) {
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

export {
    getSelectedPath,
    closeSublingTreeOf,
};