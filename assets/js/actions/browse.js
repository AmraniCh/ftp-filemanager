import {fetchGet} from "../helpers/fetch";
import DOMRender from "../helpers/DOMRender";
import sidebarFileItem from "../templates/sidebarFileItem";
import tableFileItem from "../templates/tableFileItem";
import File from '../entities/File';
import {toggleLoaders} from "../helpers/loaders";
import {getElement} from "../helpers/functions";
import {getAppendToSelector} from "../helpers/treeView";

function browse(path) {
    toggleLoaders();
    const appendTo = getAppendToSelector(path);
    fetchGet('api?action=browse&path='+encodeURIComponent(path), function (data) {
        if (Array.isArray(data.result)) {
            // Clear table content
            getElement('.files-table tbody').textContent = '';

            data.result.forEach(function (item) {
                DOMRender(sidebarFileItem(new File(item)), appendTo, false);
                DOMRender(tableFileItem(new File(item)), '.files-table tbody', false);
            });

            toggleLoaders();
        }
    }, function () {
        // in case of request fail close the last sidebar clicked dir item
        getElement(appendTo.split(' ').slice(0, -1).join(' ')).dataset.open = 'false';
    });
}

export default browse;
