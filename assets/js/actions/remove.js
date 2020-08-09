import {hideLoading, showLoading} from "../helpers/loading";
import {fetchDelete} from "../helpers/fetch";
import refresh from "./refresh";
import state from "../state";
import modal from "../helpers/modal";

function remove(files) {
    modal('#removeFileModal').close();
    showLoading();
    fetchDelete('api?action=remove', {
        files: files
    }, function (res) {
        if (res.result) {
            refresh(state.path);
        }
    }, function (error) {
        modal('#removeFileModal').show().showError(error);
        hideLoading();
    })
}

export default remove;