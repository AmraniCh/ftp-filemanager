import browse from "./actions/browse";
import {bindEvent, getElement, on} from "./helpers/functions";
import {closeSublingTreeOf, getSelectedPath} from "./helpers/treeView";

const App = function () {

    // Storing state variables
    var state = {
        path: '/',
    };

    this.initEvents = function () {
        // load event
        bindEvent('DOMContentLoaded', document, browse(state.path));

        // Sidebar directory listing
        on('click', '.sidebar .dir-item', function (e) {
            if (!e.target.closest('.file-item')) { // ignore file items click
                const
                    item = e.target.closest('.dir-item'),
                    fileName = item.dataset.name;

                item.dataset.open = 'true';

                // if the clicked element is already have been clicked then remove its content
                if (state.path.split('/').includes(fileName)) {
                    item.querySelector('.sub-files').textContent = '';
                }

                closeSublingTreeOf(item);
                browse(state.path = getSelectedPath());
            }
        });

        // Table directory listing
        on('dblclick', '.files-table .file-item[data-type="dir"]', function (e) {
            const fileName =
                getElement('.file-name', e.target.closest('.file-item[data-type="dir"]'))
                .textContent
                .trim();

            const path = getSelectedPath() + '/' + fileName;

            browse(state.path = path);
        });
    };
};

export default App;