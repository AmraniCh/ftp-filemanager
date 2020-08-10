import {bindEvent, getElement, getElements, on} from "./helpers/functions";
import {closeSiblingTreeOf, getSelectedPath} from "./helpers/treeView";
import refresh from "./actions/refresh";
import state from "./state";
import addFile from "./actions/addFile";
import addFolder from "./actions/addFolder";
import modal from "./helpers/modal";
import getFileContent from "./actions/getFileContent";
import browse from "./actions/browse";
import edit from "./actions/edit";
import remove from "./actions/remove";
import rename from "./actions/rename";
import getDirectoryTree from "./actions/getDirectoryTree";

const App = function () {

    this.initEvents = function () {
        // load event
        bindEvent('DOMContentLoaded', document, browse(state.path));

        // Sidebar directory listing
        on('click', '.sidebar .dir-item', function (e) {
            if (!e.target.closest('.file-item')) { // ignore file items click
                const
                    item = e.target.closest('.dir-item'),
                    fileName = decodeURI(item.dataset.name);

                item.dataset.open = 'true';

                // if the clicked element is already have been clicked then remove its content
                if (state.path.split('/').includes(fileName)) {
                    item.querySelector('.sub-files').textContent = '';
                }

                closeSiblingTreeOf(item);

                browse(state.path = getSelectedPath());
            }
        });

        // Table directory listing
        on('dblclick', '.files-table .file-item[data-type="dir"]', function (e) {
            const
                item = e.target.closest('.file-item[data-type="dir"]'),
                fileName = getElement('.file-name', item).textContent.trim();

            const path = getSelectedPath() + fileName + '/';

            // find the sidebar alternative file and make it open
            if (path !== '/') {
                getElement('.sidebar .dir-item[data-name="' + encodeURI(fileName) + '"]').dataset.open = 'true';
            }

            browse(state.path = path);

            // Disable footer right buttons
            getElements('.right-buttons *[data-action]').forEach(function (button) {
                button.disabled = true;
            });
        });

        // Refresh button
        bindEvent('click', 'button[data-action="refresh"]', function () {
            refresh(state.path);
        });

        // Add file action
        bindEvent('click', '#addFileBtn', function () {
            addFile(getElement('#addFileModal #fileName').value, state.path);
        });

        // Add Folder action
        bindEvent('click', '#addFolderBtn', function () {
            addFolder(getElement('#addFolderModal #folderName').value, state.path);
        });

        // Get editor file content when double clicking in a table file item
        on('dblclick', '.files-table .file-item[data-type="file"]', function (e) {
            modal('#editorModal').show();
            const clickedFileName = getElement('.file-name', e.target.closest('.file-item')).textContent;
            state.editableFile = state.path + clickedFileName;
            getFileContent(state.editableFile);
        });

        // Get editor file content when clicking in a sidebar file item
        on('click', '.sidebar .file-item', function (e) {
            const
                file = e.target.closest('.file-item'),
                fileName = file.dataset.name;

            closeSiblingTreeOf(file);
            state.path = getSelectedPath();
            modal('#editorModal').show();
            state.editableFile = state.path + fileName;
            getFileContent(state.editableFile);
        });

        // Edit file action
        bindEvent('click', '#updateFileBtn', function () {
            edit(state.editableFile, fmEditor.get());
        });

        // Remove files action
        bindEvent('click', '#removeFileBtn', function () {
            const
                selectedItems = getElements('.files-table .file-item.selected'),
                files = [];

            selectedItems.forEach(function (item) {
                const name = getElement('.file-name', item).textContent;
                files.push(state.path + name);
            });

            remove(files);
        });

        // Rename file action
        bindEvent('click', '#renameFileBtn', function () {
            const
                file = getElement('#renameFileModal .name-for').textContent,
                newName = getElement('#newFileName').value;

            rename(state.path, file, newName);
        });

        // Get directory tree
        bindEvent('click', 'button[data-action="move"]', function () {
            getDirectoryTree();
        });

        // Move file modal file items clicking
        on('click', '.move-file-modal .dir-item', function (e) {
            const ele = e.target.closest('.dir-item');
            if (ele.dataset.open === 'false') {
                ele.dataset.open = 'true';
                getElement('.sub-files', ele).style.display = 'block';
            } else {
                ele.dataset.open = 'false';
                getElement('.sub-files', ele).style.display = 'none';
            }
        });

        // Move file action
        bindEvent('click', '#moveFileBtn', function () {
            const
                file = getElement('#moveFileModal .source'),
                newPath = getElement("#moveFileModal .destination");

            rename(state.path, file, newPath);
        });
    };
};

export default App;