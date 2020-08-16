import {hideLoading, showLoading} from "../helpers/loading";
import {getAppendToSelector} from "../helpers/treeView";
import {fetchGet} from "../helpers/fetch";
import DOMRender from "../helpers/DOMRender";
import sidebarFileItem from "../templates/sidebarFileItem";
import File from "../entities/File";
import tableFileItem from "../templates/tableFileItem";
import state from "../state";
import {getElement} from "../helpers/functions";

function browse(path) {
    const appendTo = getAppendToSelector(path);
    showLoading();
    fetchGet('api?action=browse&path=' + encodeURIComponent(path), function (data) {
        if (Array.isArray(data.result)) {
            // Clear table content
            getElement('.files-table tbody').textContent = '';

            data.result.forEach(function (item) {
                DOMRender(sidebarFileItem(new File(item)), appendTo);
                DOMRender(tableFileItem(new File(item)), '.files-table tbody');
            });

            // Refresh files state
            state.files = data.result;
        }
    }, function (err) {
        // in case of request fail close the last sidebar clicked dir item
        getElement(appendTo.split(' ').slice(0, -1).join(' ')).dataset.open = 'false';
        // back path
        state.path = state.path.substring(0, state.path.lastIndexOf('/'));
        // show the error message
        if (typeof err !== 'undefined') {
            alert('Error : ' + err);
        }
    }, function () {
        hideLoading();
    });
}

/**
 * Backs to the previous directory.
 */
function back() {
    /**
     * / => /
     * /public_html/ => /
     * /public_html/css => public_html
     */
    var backPath = state.path
        .replace(/(^\/|\/$)/g, '') // clear the slashes from start&end
        .split('/')
        .slice(0, -1)
        .join('/');

    if (backPath === '') {
        backPath = '/';
    }

    getElement(`.sidebar .dir-item[data-name="${encodeURI(backPath)}"`).click();
}

function forward() {
    const selectedDir = getElement('.files-table .file-item.selected[data-type="dir"]');
    if (typeof selectedDir === 'object') {
        // Simulate the double click
        selectedDir.dispatchEvent(new MouseEvent('dblclick', {
            bubbles: true, // Important! Enable event bubbling
            cancelable: true,
        }));
    }
}

function home() {
    const root = getElement('.sidebar .files-list .dir-item[data-name="/"]');
    if (typeof root === 'object') {
        root.dispatchEvent(new MouseEvent('click', {
            bubbles: true,
            cancelable: true,
        }));
    }
}

export {
    browse,
    back,
    forward,
    home,
};