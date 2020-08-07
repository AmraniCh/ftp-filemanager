import {fetchGet} from "../helpers/fetch";
import DOMRender from "../helpers/DOMRender";
import sidebarFileItem from "../templates/sidebarFileItem";
import tableFileItem from "../templates/tableFileItem";
import File from '../entities/File';
import {toggleLoaders} from "../helpers/loaders";
import {getElement} from "../helpers/functions";

function browse(path) {
    toggleLoaders();
    fetchGet('api?action=browse&path='+encodeURIComponent(path), function (data) {
        if (Array.isArray(data.result)) {
            // Clear table content
            getElement('.files-table tbody').textContent = '';

            var appendTo = '.sidebar .files-list';
            if (path !== '/') {
                const name = path.split('/').pop();
                appendTo = '.dir-item[data-name="'+name+'"] .sub-files';
            }

            data.result.forEach(function (item) {
                DOMRender(sidebarFileItem(new File(item)), appendTo, false);
                DOMRender(tableFileItem(new File(item)), '.files-table tbody', false);
            });

            toggleLoaders();
        }
    });
}

export default browse;
