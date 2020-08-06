var File = function (data) {
    if (typeof data !== 'object') return;

    this.name = data.name || '';
    this.type = data.type || 'file';
    this.size = data.size || '';
    this.path = data.path || '';
    this.owner = data.owner || '';
    this.group = data.group || '';
    this.modifiedTime = data.modifiedTime || '';
    this.permissions = data.permissions || '';
};

export default File;