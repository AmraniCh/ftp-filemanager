import {bindEvent, getElement, getElements, on} from "./helpers/functions";
import {closeSiblingTreeOf, getSelectedPath} from "./helpers/treeView";
import refresh from "./actions/refresh";
import state from "./state";
import addFile from "./actions/addFile";
import addFolder from "./actions/addFolder";
import modal from "./helpers/modal";
import getFileContent from "./actions/getFileContent";
import {browse, back, forward, home} from "./actions/listing";
import edit from "./actions/edit";
import remove from "./actions/remove";
import rename from "./actions/rename";
import getDirectoryTree from "./actions/getDirectoryTree";
import move from "./actions/move";
import permissions from "./actions/permissions";
import File from "./entities/File";
import download from "./actions/download";
import DOMRender from "./helpers/DOMRender";
import uploadModalFileItem from "./templates/uploadModalFileItem";
import upload from "./actions/upload";

const App = function () {

    var registry = [];

    this.registerEvents = function () {
        registry.push(load);
        
        /**
         * Directory listing actions.
         */
        registry.push(sidebarDirectoryListing);
        registry.push(tableDirectoryListing);
        registry.push(toolbarActions);

        /**
         * Actions.
         */
        registry.push(refreshAction);
        registry.push(addFileAction);
        registry.push(addFolderAction);
        registry.push(removeFilesAction);
        registry.push(renameAction);
        registry.push(moveFileAction);
        registry.push(editFileAction);
        registry.push(changePermissionsAction);
        registry.push(downloadAction);
        registry.push(uploadAction);

        /**
         * Modal components events.
         */
        registry.push(updateEditorModal);
        registry.push(updateMoveModal);
        registry.push(updatePermissionsModal);
        registry.push(updateInfoModal);
        registry.push(updateUploadModal);
    };

    this.init = function () {
        registry.forEach(function (fn) {
            fn();
        });
    };

    var load = function () {
        bindEvent('DOMContentLoaded', document, browse(state.path));
    };

    var sidebarDirectoryListing = function () {
        on('click', '.sidebar .dir-item', function (e) {
            if (!e.target.closest('.file-item')) { // ignore file items click
                const item = e.target.closest('.dir-item');

                item.dataset.open = 'true';
                item.querySelector('.sub-files').textContent = '';

                closeSiblingTreeOf(item);
                browse(state.path = getSelectedPath());
            }
        });
    };

    var tableDirectoryListing = function () {
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
    };

    var refreshAction = function () {
        bindEvent('click', 'button[data-action="refresh"]', function () {
            refresh(state.path);
        });
    };

    var addFileAction = function () {
        bindEvent('click', '#addFileBtn', function () {
            addFile(getElement('#addFileModal #fileName').value, state.path);
        });
    };

    var addFolderAction = function () {
        bindEvent('click', '#addFolderBtn', function () {
            addFolder(getElement('#addFolderModal #folderName').value, state.path);
        });
    };

    var updateEditorModal = function () {
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
    };

    var editFileAction = function () {
        bindEvent('click', '#updateFileBtn', function () {
            edit(state.editableFile, fmEditor.get());
        });
    };

    var removeFilesAction = function () {
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
    };

    var renameAction = function () {
        bindEvent('click', '#renameFileBtn', function () {
            const
                file = getElement('#renameFileModal .name-for').textContent,
                newName = getElement('#newFileName').value;

            rename(state.path, file, newName);
        });
    };

    var updateMoveModal = function () {
        bindEvent('click', 'button[data-action="move"]', function () {
            getDirectoryTree();
        });
    };

    var moveFileAction = function () {
        bindEvent('click', '#moveFileBtn', function () {
            const
                file = getElement('#moveFileModal .source').textContent,
                newPath = getElement("#moveFileModal .destination").textContent;

            move(state.path, file, newPath);
        });
    };

    var changePermissionsAction = function () {
        bindEvent('click', '#changePermBtn', function () {
            const
                file = getElement('#permissionsModal .filename').textContent,
                chmod = getElement('#permissionsModal .numeric-chmod').textContent;

            permissions(state.path, file, chmod);
        });
    };

    var updatePermissionsModal = function () {
        bindEvent('click', 'button[data-action="permissions"]', function () {
            const
                file = state.getFileByName(getElement('#permissionsModal .filename').textContent),
                permissions = file.permissions,
                chunks = permissions.slice(1).split(''),
                perms = {
                    owner: chunks.slice(0, 3),
                    group: chunks.slice(3, 6),
                    others: chunks.slice(6)
                },
                translate = {
                    'r': 'read',
                    'w': 'write',
                    'x': 'execute'
                },
                rules = {
                    'r': 4,
                    'w': 2,
                    'x': 1,
                };

            var chmod = [0, 0, 0];
            for (var prop in perms) {
                if (perms.hasOwnProperty(prop)) {
                    perms[prop].forEach(function (perm) {
                        if (perm !== '-') {
                            getElement(`#permissionsModal .checkbox[data-action="${translate[perm]}"][data-group="${prop}"] input[type=checkbox]`).checked = true;

                            switch (prop) {
                                case 'owner':
                                    chmod[0] += rules[perm];
                                    break;
                                case 'group':
                                    chmod[1] += rules[perm];
                                    break;
                                case 'others':
                                    chmod[2] += rules[perm];
                                    break;
                            }
                        }
                    });
                }
            }

            getElement('#permissionsModal .numeric-chmod').textContent = `0${chmod.join('')}`;
        });
    };

    var updateInfoModal = function () {
        bindEvent('click', 'button[data-action="info"]', function () {
            const
                selectedFilename = getElement('.files-table .file-item.selected .file-name').textContent,
                file = new File(state.getFileByName(selectedFilename));

            for (var prop in file) {
                if (file.hasOwnProperty(prop)) {
                    const infoItem = getElement(`.info-modal .info-item.${prop}`);
                    if (typeof infoItem !== 'undefined') {
                        var info = file[prop];
                        if (prop === 'size') {
                            info = file.bytesToSize();
                        }
                        getElement('.info-text', infoItem).textContent = info;
                    }
                }
            }
        });
    };

    var toolbarActions = function () {
        bindEvent('click', '.toolbar button[data-action="back"]', back);
        bindEvent('click', '.toolbar button[data-action="forward"]', forward);
        bindEvent('click', '.toolbar button[data-action="home"]', home);
    };

    var downloadAction = function () {
        bindEvent('click', 'button[data-action="download"]', function () {
            const selectedFiles = Array.from(getElements('.files-table .file-item.selected .file-name'));

            var files = selectedFiles.map(function (item) {
               return item.textContent;
            });

            download(state.path, files);
        });
    };

    var updateUploadModal = function () {
        // Update the uploading path and remove existing state files
        bindEvent('click', 'button[data-action="upload"]', function () {
            const uploadingFolder = getElement('#uploadModal .uploading-folder');
            uploadingFolder.textContent = state.path;
            state.uploadedFiles = [];
            getElement('.files-to-upload').textContent = '';
        });

        // Append files
        bindEvent('change', '#uploadFilesBtn', function () {
            const files = Array.from(getElement('#uploadFilesBtn').files);

            files.forEach(function (file) {
                DOMRender(uploadModalFileItem(new File(file)), '.files-to-upload');
            });

            // Storing the files
            files.forEach(function (file) {
                state.uploadedFiles.push(file);
            });

            // Reset the form
            getElement('#uploadFilesForm').reset();
        });

        // Remove the files
        on('click', '.remove-upload-file', function (e) {
            const removedFile = getElement('.name', e.target.closest('.file-item')).textContent;
            state.uploadedFiles.forEach(function (file, i) {
               if (file.name === removedFile)  {
                   delete state.uploadedFiles[i];
               }
            });
        });
    };

    var uploadAction = function () {
        bindEvent('click', '#uploadBtn', function () {
            // reset all progress info
            getElements('#uploadModal .file-item').forEach(function(item) {
                getElement('.progress-bar', item).style.width = '0';
                getElement('.percentage', item).textContent = '0%';
                getElement('.upload-state', item).textContent = 'Uploading ...';
                getElement('.file-error .text', item).textContent = '';
            });

            var formData = new FormData();
            state.uploadedFiles.forEach(function (file) {
                const fileItem = getElement(`#uploadModal .file-item[data-name="${encodeURI(file.name)}"]`);

                formData.append('file', file);
                formData.append('path', state.path);

                upload(state.path, formData, function (progress) {
                    getElement('.percentage', fileItem).textContent = progress + '%';
                    getElement('.progress-bar', fileItem).style.width = progress + '%';
                    if (progress === 100) {
                        getElement('.upload-state', fileItem).textContent = 'Uploading to the server ...';
                    }
                }, function (err) {
                    getElement('.file-error .text', fileItem).textContent = err;
                });
            });
        });
    };
};

export default App;