import UIkit from 'uikit';

export default (function() {
    document.addEventListener("wpcf7invalid ", function(event) {
        UIkit.notification(event.detail.apiResponse.message, {status:'danger'});
    });
    document.addEventListener("wpcf7spam", function(event) {
        UIkit.notification(event.detail.apiResponse.message, {status:'danger'});
    });
    document.addEventListener("wpcf7mailsent", function(event) {
        UIkit.notification(event.detail.apiResponse.message, {status:'success'});
    });
    document.addEventListener("wpcf7mailfailed", function(event) {
        UIkit.notification(event.detail.apiResponse.message, {status:'danger'});
    });
    document.addEventListener("wpcf7submit", function(event) {
        UIkit.notification(event.detail.apiResponse.message, {status:'danger'});
    });
})();
