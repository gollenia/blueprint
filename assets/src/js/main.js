import UIkit from 'uikit';



import './../scss/app.scss';
window.UIkit = UIkit;


UIkit.util.on('#mobile-menu', 'show', function () {
    document.getElementById('hamburger').classList.add("is-active");
});

UIkit.util.on('#mobile-menu', 'hide', function () {
    document.getElementById('hamburger').classList.remove("is-active");
});
