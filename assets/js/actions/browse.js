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

export default browse;