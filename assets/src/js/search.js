import UIkit from 'uikit';

export default (function() {

    UIkit.util.on('#search', 'show', function (event) {
        document.getElementById("search-input").focus();
    });


    const searchInput = document.getElementById("search")

    document.onkeydown = function(evt) {
        evt = evt || window.event;
        var isEscape = false;
        if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc");
        } else {
            isEscape = (evt.keyCode === 27);
        }
        if (isEscape) {
            document.getElementById("search").hidden = true;
        }
    };
    
    searchInput.addEventListener("keyup", function(event) {
        
        if(event.target.value.length < 3) {
            return;
        }
        
        fetch('/?ctx_search=' + event.target.value)
            .then(response => response.json())
            .then(data => {
                document.getElementById("search-results").innerHTML = "";
                
                Object.values(data).forEach(item => {
                    //console.log(item);    
                    var searchItem = document.createElement("div");
                    searchItem.classList.add("ctx-search-result-item");
                    searchItem.innerHTML = "<a href='" + item.link + "'><h5>" + item.title + "</h5></a><p>" + item.text + "</p>";
                    document.getElementById("search-results").append(searchItem);
                    
                });
            })
            .catch((error) => {
            //console.error('Error:', error);
            });
    });

})();