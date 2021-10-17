// Storing state variables
var state = {
  path: ".",
  editableFile: null,
  files: [],
  uploadedFiles: [],

  getFileByName: function (name) {
    for (var prop in this.files) {
      if (this.files[prop].name === name) {
        return this.files[prop];
      }
    }

    return false;
  },
};

export default state;
