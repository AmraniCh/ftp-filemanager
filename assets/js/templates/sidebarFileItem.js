/**
 * @param {File} fileItem
 * @returns {string}
 */
import dirIcon from "./includes/sidebarDirIcon";
import fileIcon from "./includes/fileIcon";

export default function (fileItem) {
    if (typeof fileItem !== 'object') return;

    return `
        <li class="${fileItem.type}-item item" data-name="${fileItem.name}" data-open="false">
            ${fileItem.isDir() ? dirIcon() : fileIcon()}
            <span class="name">${fileItem.name}</span>
            ${fileItem.isDir() ? '<ul class="sub-files"></ul>' : ''}
        </li>`;
}

