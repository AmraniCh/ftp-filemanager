import {fetchGet} from "../helpers/fetch";
import modal from "../helpers/modal";

function getFileContent(file) {
    fmEditor.clear().showLoading();
    fetchGet('api?action=getFileContent&file=' + encodeURIComponent(file), function (res) {
        if (res.result) {
            fmEditor.set(res.result);
        }
    }, function (err) {
        modal('#editorModal').showError(err);
    }, function () {
        fmEditor.hideLoading();
    });
}

export default getFileContent;