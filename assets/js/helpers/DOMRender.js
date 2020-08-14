function DOMRender(template, container) {
    (document.querySelector(container) || document.body)
        .insertAdjacentHTML('beforeend', template);
}

export default DOMRender;