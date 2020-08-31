import UIkit from 'uikit';

export default (function() {
    
    document.addEventListener("wpcf7invalid ", function(event) {
        UIkit.notification(event.detail.apiResponse.message, {status:'danger', timeout: 7000});
    });
    document.addEventListener("wpcf7spam", function(event) {
        UIkit.notification(event.detail.apiResponse.message, {status:'danger', timeout: 7000});
    });
    document.addEventListener("wpcf7mailsent", function(event) {
        UIkit.modal(".uk-modal").hide();
        UIkit.notification(event.detail.apiResponse.message, {status:'success', timeout: 7000});
    });
    document.addEventListener("wpcf7mailfailed", function(event) {
        UIkit.modal(".uk-modal").hide();
        UIkit.notification(event.detail.apiResponse.message, {status:'danger', timeout: 7000});
    });
})();
