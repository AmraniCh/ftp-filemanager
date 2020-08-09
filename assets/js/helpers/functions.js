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

export {
    bindEvent,
    on,
    getElement,
    getElements,
};