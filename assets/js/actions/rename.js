import {fetchUpdate} from "../helpers/fetch";
import modal from "../helpers/modal";
import {hideLoading, showLoading} from "../helpers/loading";
import refresh from "./refresh";
import state from "../state";

function rename(path, file, newName) {
    modal('#renameFileModal').close();
    showLoading();
    fetchUpdate('PUT', 'api?action=rename', {
        path: path,
        file: file,
        newName: newName,
    }, function (res) {
        if (res.result) {
            refresh(state.path);
        }
    }, function (err) {
        modal('#renameFileModal').show().showError(err);
        hideLoading();
    });
}

export default rename;