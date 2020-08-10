import {fetchGet} from "../helpers/fetch";
import DOMRender from "../helpers/DOMRender";
import sidebarFileItem from "../templates/sidebarFileItem";
import File from "../entities/File";
import moveModalFileDirItem from "../templates/moveModalFileDirItem";
import {getElement} from "../helpers/functions";

function getDirectoryTree() {
    fetchGet('api?action=getDirectoryTree', function (res) {
        if (res.result) {

            getElement('.move-file-modal .files-list').textContent = '';

            res.result.forEach(function (dir) {
                if (dir.path.indexOf('/') !== -1) {
                    const path = dir.path.slice(0, dir.path.lastIndexOf('/'));
                    DOMRender(moveModalFileDirItem(dir), '.move-file-modal .files-list .dir-item[data-path="'+path+'"] .sub-files');
                } else {
                    DOMRender(moveModalFileDirItem(dir), '.move-file-modal .files-list');
                }
            });
        }
    });
}



export default getDirectoryTree;