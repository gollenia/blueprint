linkButtons = document.getElementsByClassName('ctx-link-modal')

for (let element of linkButtons) {
    element.addEventListener('click', event => {
        var parent = event.target.parentNode;
        var textarea = document.createElement('textarea');
        textarea.id = "ctx-link-textarea"
        textarea.style = "display:none;"
        document.body.appendChild(textarea);

        jQuery(document).on('wplink-open', () => {
            document.getElementById("wp-link-wrap").classList.add("has-text-field");
        })

        jQuery(document).on('wplink-close', () => {
            document.getElementById("wp-link-wrap").classList.add("has-text-field");
            var linkTextarea = document.getElementById("ctx-link-textarea")
            var div = document.createElement('div');
            div.innerHTML = linkTextarea.value.trim();

            // Change this to div.childNodes to support multiple top-level nodes
            var linkElem = div.firstChild;


            parent.querySelector("#input-title").value = linkElem.innerHTML;
            parent.querySelector("#input-url").value = linkElem.getAttribute("href");
            parent.querySelector("#link-preview").innerHTML = linkElem.getAttribute("href");
            

        })

        wpLink.open( 'ctx-link-textarea' );
    })
}




