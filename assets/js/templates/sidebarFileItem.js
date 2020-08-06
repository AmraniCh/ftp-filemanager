/**
 * @param {File} fileItem
 * @returns {string}
 */
import dirIcon from "./includes/sidebarDirIcon";
import fileIcon from "./includes/fileIcon";

export default function (fileItem) {
    if (typeof fileItem !== 'object') return;

    return `
        <li class="dir-item item" data-open="false">
            ${fileItem.isDir() ? dirIcon() : fileIcon()}
            <span class="name">${fileItem.name}</span>
        </li>`;
}

