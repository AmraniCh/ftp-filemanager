import modal from "../helpers/modal";
import {hideLoading, showLoading} from "../helpers/loading";
import {fetchUpdate} from "../helpers/fetch";
import refresh from "./refresh";

function addFolder(folderName, path) {
    modal('#addFolderModal').close();
    showLoading();
    fetchUpdate('POST', 'api?action=addFolder', {
        name: folderName,
        path: path
    }, function (res) {
        if (res.result) {
            refresh(path);
        }
    }, function (error) {
        modal('#addFolderModal').show().showError(error);
        hideLoading();
    });
}

export default addFolder;