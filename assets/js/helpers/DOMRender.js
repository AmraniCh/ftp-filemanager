function DOMRender(template, container) {
    var tmp = document.createElement("template");
    tmp.innerHTML = template;

    (document.querySelector(container) || document.body)
        .appendChild(tmp.content.cloneNode(true));
}

export default DOMRender;