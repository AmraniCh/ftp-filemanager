import {hideLoading, showLoading} from "./loading";
import {getAppendToSelector} from "./treeView";
import {fetchGet} from "./fetch";
import DOMRender from "./DOMRender";
import sidebarFileItem from "../templates/sidebarFileItem";
import File from "../entities/File";
import tableFileItem from "../templates/tableFileItem";
import state from "../state";
import modal from "./modal";

function bindEvent(event, elements, fn) {
    // checks if 'elements' is a selector
    if (typeof elements === 'string') {
        elements = document.querySelectorAll(elements);
    }

    if (Node.prototype.isPrototypeOf(elements)) {
        elements.addEventListener(event, fn);
    }

    if (HTMLCollection.prototype.isPrototypeOf(elements)) {
        Array.from(elements).forEach(function (ele) {
            ele.addEventListener(event, fn);
        });
    }

    if (NodeList.prototype.isPrototypeOf(elements)) {
        elements.forEach(function (ele) {
            ele.addEventListener(event, fn);
        });
    }
}

function on(event, selector, fn) {
    if (typeof selector !== 'string') return;
    document.addEventListener(event, function (e) {
        const find = e.target.closest(selector);
        if (find && find.matches(selector)) {
            fn(e);
        }
    });
}

function getElement(selector, findIn) {
    return getElements(selector, findIn)[0];
}

function getElements(selector, findIn) {
    if (typeof selector !== 'string') return;
    return (findIn || document).querySelectorAll(selector) || false;
}

function browse(path) {
    showLoading();
    const appendTo = getAppendToSelector(path);
    fetchGet('api?action=browse&path=' + encodeURIComponent(path), function (data) {
        if (Array.isArray(data.result)) {
            // Clear table content
            getElement('.files-table tbody').textContent = '';

            data.result.forEach(function (item) {
                DOMRender(sidebarFileItem(new File(item)), appendTo, false);
                DOMRender(tableFileItem(new File(item)), '.files-table tbody', false);
            });
        }
    }, function (err) {
        // in case of request fail close the last sidebar clicked dir item
        getElement(appendTo.split(' ').slice(0, -1).join(' ')).dataset.open = 'false';
        // back path
        state.path = state.path.substring(0, state.path.lastIndexOf('/'));
        // show the error message
        alert('Error : ' + err);
    }, function () {
        hideLoading();
    });
}

function setEditorFileContent(file) {
    fmEditor.clear().showLoading();
    fetchGet('api?action=getFileContent&file=' + encodeURIComponent(file), function (res) {
        if (res.result) {
            fmEditor.set(res.result);
        }
    }, function (err) {
        modal('#editorModal').showError(err);
    }, function () {
        fmEditor.hideLoading();
    });
}

export {
    bindEvent,
    on,
    getElement,
    getElements,
    browse,
    setEditorFileContent,
};