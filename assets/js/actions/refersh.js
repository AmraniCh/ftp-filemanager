import {browse, getElement} from "../helpers/functions";
import {getAppendToSelector} from "../helpers/treeView";

function refresh(path) {
    getElement(getAppendToSelector(path)).textContent = '';
    browse(path);
}

export default refresh;