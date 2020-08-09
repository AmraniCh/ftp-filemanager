import {fetchUpdate} from "../helpers/fetch";
import refresh from "./refresh";
import modal from "../helpers/modal";
import {hideLoading, showLoading} from "../helpers/loading";

function addFile(filename, path) {
    modal('#addFileModal').close();
    showLoading();
    fetchUpdate('POST', 'api?action=addFile', {
        name: filename,
        path: path
    }, function (res) {
        if (res.result) {
            refresh(path);
        }
    }, function (error) {
        modal('#addFileModal').show().showError(error);
        hideLoading();
    });
}

export default addFile;