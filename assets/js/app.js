import {bindEvent, browse, getElement, getElements, on, setEditorFileContent} from "./helpers/functions";
import {closeSiblingTreeOf, getSelectedPath} from "./helpers/treeView";
import refresh from "./actions/refersh";
import state from "./state";
import addFile from "./actions/addFile";
import addFolder from "./actions/addFolder";
import modal from "./helpers/modal";

const App = function () {

    this.initEvents = function () {
        // load event
        bindEvent('DOMContentLoaded', document, browse(state.path));

        // Sidebar directory listing
        on('click', '.sidebar .dir-item', function (e) {
            if (!e.target.closest('.file-item')) { // ignore file items click
                const
                    item = e.target.closest('.dir-item'),
                    fileName = item.dataset.name;

                item.dataset.open = 'true';

                // if the clicked element is already have been clicked then remove its content
                if (state.path.split('/').includes(fileName)) {
                    item.querySelector('.sub-files').textContent = '';
                }

                closeSiblingTreeOf(item);
                browse(state.path = getSelectedPath());
                console.log(state.path);
            }
        });

        // Table directory listing
        on('dblclick', '.files-table .file-item[data-type="dir"]', function (e) {
            const fileName =
                getElement('.file-name', e.target.closest('.file-item[data-type="dir"]'))
                    .textContent
                    .trim();

            const path = getSelectedPath() + '/' + fileName;

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
            setEditorFileContent(getElement('.file-name', e.target.closest('.file-item')).textContent.trim());
        });

        // Get editor file content when clicking in a sidebar file item
        on('click', '.sidebar .file-item', function (e) {
            modal('#editorModal').show();
            setEditorFileContent(e.target.closest('.file-item').dataset.name);
        });
    };
};

export default App;