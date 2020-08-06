var File = function (data) {
    if (typeof data !== 'object') return;

    this.name = data.name || '';
    this.type = data.type || 'file';
    this.size = parseInt(data.size) || 0;
    this.path = data.path || '';
    this.owner = parseInt(data.owner) || '';
    this.group = parseInt(data.group) || '';
    this.modifiedTime = data.modifiedTime || '';
    this.permissions = data.permissions || '';

    File.prototype.bytesToSize = function () {
        if (this.size === 0) return '0 Byte';

        const sizes = {
            Bytes: 1,
            KB: Math.pow(1024, 1),
            MB: Math.pow(1024, 2),
            GB: Math.pow(1024, 3),
            TB: Math.pow(1024, 4),
        };

        var unit = null;
        for (var prop in sizes) {
            if (this.size >= sizes[prop]) {
                unit = prop;
            }
        }

        return (this.size / sizes[unit]).toFixed(0) + ' ' + unit;
    };

    File.prototype.isFile = function () {
        return this.type === 'file';
    };

    File.prototype.isDir = function () {
            return this.type === 'dir';
    };
};

export default File;