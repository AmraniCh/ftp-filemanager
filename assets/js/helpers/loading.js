const
    sidebarLoader = fmWrapper.querySelector('.sidebar .loader'),
    tableLoader = fmWrapper.querySelector('.table-section .loader');

function showLoading() {
    fmWrapper.style.pointerEvents = 'none';
    sidebarLoader.classList.add('show');
    tableLoader.classList.add('show');
}

function hideLoading() {
    fmWrapper.style.pointerEvents = 'auto';
    sidebarLoader.classList.remove('show');
    tableLoader.classList.remove('show');
}

export {
    showLoading,
    hideLoading
};