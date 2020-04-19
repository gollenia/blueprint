import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

import boy from '../img/icons/boy.svg';
import calendar from '../img/icons/calendar.svg';

UIkit.use(Icons);


UIkit.icon.add("boy", boy);
UIkit.icon.add("calendar", calendar);



import './../scss/app.scss';
window.UIkit = UIkit;


UIkit.util.on('#mobile-menu', 'beforeshow', function (event) {
    if(event.target.id == "mobile-menu") {
        document.getElementById('hamburger').classList.add("is-active");
    }
});

UIkit.util.on('#mobile-menu', 'beforehide', function (event) {
    if(event.target.id == "mobile-menu") {
        document.getElementById('hamburger').classList.remove("is-active");
    }
});
