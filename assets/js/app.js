import browse from "./actions/browse";
import {bindEvent} from "./helpers/functions";

const App = function () {

    // Storing state variables
    var state = {
        path: '/',
    };

    this.initEvents = function () {
        bindEvent('DOMContentLoaded', document, browse(state.path));
    };
};

export default App;