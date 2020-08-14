import {fetchGet} from "../helpers/fetch";
import DOMRender from "../helpers/DOMRender";
import moveModalDirItem from "../templates/moveModalDirItem";
import {getElement} from "../helpers/functions";

function getDirectoryTree() {
    fetchGet('api?action=getDirectoryTree', function (res) {
        if (res.result) {
            getElement('.move-file-modal .files-list').textContent = '';

            res.result.forEach(function (dir) {
                // If the path starts with a slash remove it
                dir.path = dir.path.replace(/^\//, '');

                if (dir.path.indexOf('/') !== -1) { // Is a 'deep' path
                    const path = dir.path.slice(0, dir.path.lastIndexOf('/'));
                    // Append the content to the right dir item using the path
                    DOMRender(moveModalDirItem(dir), `.move-file-modal .files-list .dir-item[data-path="${encodeURI(path)}"] .sub-files`);
                } else {
                    DOMRender(moveModalDirItem(dir), '.move-file-modal .files-list');
                }
            });
        }
    });
}

export default getDirectoryTree;