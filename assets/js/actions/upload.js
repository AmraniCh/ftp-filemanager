import uploadRequest from "../helpers/uploadRequest";
import modal from "../helpers/modal";
import refresh from "./refresh";
import state from "../state";

function upload(path, data, onprogress) {
    uploadRequest({
        method: 'POST',
        url: 'api?action=upload',
        data: data,
        success: function (res) {
            if (res.result) {
                modal('#uploadModal').close();
                refresh(state.path);
            }
        },
        progress: function (info) {
            const percentage = (info.loaded / info.total) * 100;
            onprogress(percentage.toFixed());
        },
    });
}

export default upload;