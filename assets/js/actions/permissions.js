import {hideLoading, showLoading} from "../helpers/loading";
import {fetchUpdate} from "../helpers/fetch";
import modal from "../helpers/modal";
import refresh from "./refresh";
import state from "../state";

function permissions(path, file, chmod) {
    modal('#permissionsModal').close();
    showLoading();
    fetchUpdate('PUT', 'api?action=permissions', {
        path: path,
        file: file,
        permissions: chmod
    }, function (res) {
        if (res.result) {
            refresh(state.path);
        }
    }, function (err) {
        modal('#permissionsModal').show().showError(err);
        hideLoading();
    })
}

export default permissions;