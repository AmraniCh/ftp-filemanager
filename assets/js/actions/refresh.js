import {getElement} from "../helpers/functions";
import {getAppendToSelector} from "../helpers/treeView";
import {browse} from "./listing";

function refresh(path) {
    getElement(getAppendToSelector(path)).textContent = '';
    browse(path);
}

export default refresh;