import fileIcon from "./includes/fileIcon";
import dirIcon from "./includes/tableDirIcon";

/**
 * @param {File} fileItem
 * @return {string}
 */
export default function (fileItem) {
    if (typeof fileItem !== 'object') return;

    return `
        <tr class="file-item" data-type="${fileItem.type}">
            <td>
                <label class="checkbox">
                    <input type="checkbox">
                    <span class="checkbox-text"></span>
                </label>
            </td>
            <td>
                ${fileItem.type === 'file' ? fileIcon() : dirIcon()}
                <span class="file-name">
                    ${fileItem.name}
                </span>
            </td>
            <td>${fileItem.size}</td>
            <td>${fileItem.lastModified}</td>
            <td>${fileItem.permissions}</td>
        </tr>`;
};