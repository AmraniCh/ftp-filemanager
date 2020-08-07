function toggleTableLoader() {
    fmWrapper.querySelector('.table-section .loader').classList.toggle('show');
}

function toggleSidebarLoader() {
    fmWrapper.querySelector('.sidebar .loader').classList.toggle('show');
}

function toggleLoaders() {
    toggleTableLoader();
    toggleSidebarLoader();
}

export {
    toggleSidebarLoader,
    toggleTableLoader,
    toggleLoaders,
};