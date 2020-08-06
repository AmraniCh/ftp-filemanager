import browse from "./actions/browse";
import state from "./state";

const App = function () {

    this.init = function() {
      this.load();
    };

    App.prototype.load = function () {
        document.addEventListener('DOMContentLoaded', this.browse());
    };

    App.prototype.browse = function () {
        browse(state.path);
    };

};

export default App;