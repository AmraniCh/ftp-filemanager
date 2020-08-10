import dirIcon from '../templates/includes/sidebarDirIcon';

function moveModalFileDirItem(dir) {
    return `
        <li class="dir-item item" data-path="${encodeURI(dir.path)}" data-open="false">
            ${dirIcon()}
            <span class="name">${dir.name}</span>
            <ul class="sub-files"></ul>
        </li>
    `;
}

export default moveModalFileDirItem;