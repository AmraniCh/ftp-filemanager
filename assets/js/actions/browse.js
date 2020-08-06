import {fetchGet} from "../helpers/fetch";
import DOMRender from "../helpers/DOMRender";
import sidebarFileItem from "../templates/sidebarFileItem";
import tableFileItem from "../templates/tableFileItem";
import File from '../entities/File';
import {toggleSidebarLoader, toggleTableLoader} from "../helpers/loaders";

function browse(path) {
    fetchGet('api?action=browse&path='+encodeURIComponent(path), function (data) {
        if (Array.isArray(data.result)) {
            data.result.forEach(function (item) {
                DOMRender(sidebarFileItem(new File(item)), '.sidebar .files-list');
                DOMRender(tableFileItem(new File(item)), '.files-table tbody');
            });
            toggleTableLoader();
            toggleSidebarLoader();
        }
    });
}

export default browse;
