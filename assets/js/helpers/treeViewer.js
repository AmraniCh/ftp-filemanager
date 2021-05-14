/**
 * Gets sidebar selected path tree.
 * @return {string}
 */
import {getElement} from "./functions";

function getSelectedPath() {
    const element = document.querySelector('.sidebar .dir-item[data-open="true"]');

    if (!element) {
        return '/';
    }

    var
        child = element.querySelector('.dir-item[data-open="true"]'),
        path = decodeURI(element.dataset.name).slice(1);

    while (child) {
        path += '/' + decodeURI(child.dataset.name);
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
            getElement('.files-table tbody').textContent = '';
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
    path = path.replace(/^\/|\/$/g, '');
    
    if (path !== '') {
        const name = path.split('/').pop(),
            chunks = path.split('/'),
            dir = chunks[chunks.length - 2];

        if (dir) {
            return `.sidebar .dir-item[data-name="${encodeURI(dir)}"] .dir-item[data-name="${encodeURI(name)}"] .sub-files`;
        } 
 
        return `.sidebar .dir-item[data-name="${encodeURI(name)}"] .sub-files`;
    }

    getElement('.sidebar .files-list .dir-item[data-name="/"]').dataset.open = 'true';
    return '.sidebar .files-list .dir-item[data-name="/"] .sub-files';
}

export {
    getSelectedPath,
    closeSiblingTreeOf,
    getAppendToSelector
};