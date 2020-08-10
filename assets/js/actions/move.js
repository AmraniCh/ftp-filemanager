import {fetchUpdate} from "../helpers/fetch";
import {hideLoading, showLoading} from "../helpers/loading";
import modal from "../helpers/modal";
import refresh from "./refresh";
import state from "../state";

function move(path, file, newPath) {
    modal("#moveFileModal").close();
    showLoading();
    fetchUpdate('PUT', 'api?action=move', {
        path: path,
        file: file,
        newPath: newPath
    }, function (res) {
        if (res.result) {
            refresh(state.path);
        }
    }, function (err) {
        modal("#moveFileModal").show().showError(err);
        hideLoading();
    });
}

export default move;