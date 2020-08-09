import {fetchUpdate} from "../helpers/fetch";
import modal from "../helpers/modal";
import {hideLoading, showLoading} from "../helpers/loading";
import refresh from "./refresh";
import state from "../state";

function edit(file, content) {
    modal('#editorModal').close();
    showLoading();
    fetchUpdate('PUT', 'api?action=updateFileContent', {
        file: file,
        content: content
    }, function (res) {
        if (res.result) {
            refresh(state.path);
        }
    }, function (error) {
        modal('#editorModal').show().showError(error);
        hideLoading();
    });
}

export default edit;