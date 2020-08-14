function uploadModalFileItem(fileItem) {
    return `
        <li class="file-item" data-name="${encodeURI(fileItem.name)}">
            <h3 class="name float-lt">${fileItem.name}</h3>
            <span class="size">${fileItem.bytesToSize()}</span>
            <button class="remove-upload-file btn-icon-reset" type="button">
                ×
            </button>
            <div class="start-upload">
                <em class="upload-state">Uploading ...</em>
                <span class="percentage">0%</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 0;">
                    </div>
                </div>
            </div>
            <div class="file-error">
                <span class="text"></span>
            </div>
        </li>
    `;
}

export default uploadModalFileItem;