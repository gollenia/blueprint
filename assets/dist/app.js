!function(){"use strict";var e=e=>{const t={events:["focusout","change"],errorClass:"error",notEmptyClass:"filled",...e},n=e=>{var n;if((e=>{null!=e.target.value&&""!=e.target.value?e.target.parentElement.classList.add(t.notEmptyClass):e.target.parentElement.classList.remove(t.notEmptyClass)})(e),!e.target.required)return;const a=e.target.parentElement.querySelector(".error-message");if(null!==a&&a.remove(),e.target.validity.valid)return void e.target.parentElement.classList.remove(t.errorClass);e.target.parentElement.classList.add("error");const o=null!==(n=e.target.getAttribute("data-text-error"))&&void 0!==n?n:e.target.validationMessage,s=document.createElement("span");s.innerHTML=o,s.classList.add("error-message"),e.target.parentNode.append(s)};for(event of t.events)document.addEventListener(event,n)};document.addEventListener("DOMContentLoaded",(function(t){e(),function(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"form--trap",t=!1;const n=e=>{const t=e.target.form.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),n=e.shiftKey?t[t.length-1]:t[0];"Tab"===e.key&&(document.activeElement===t[t.length-1]||document.activeElement===t[0]&&e.shiftKey)&&(n.focus(),e.preventDefault())};document.addEventListener("focusin",(a=>{const o=a.target.form;if(o.classList.contains(e))return o&&!t?(t=!0,void document.addEventListener("keydown",n)):void(o||(t=!1,document.removeEventListener("keydown",n)))}))}(),function(e,t){const n={maxScreenWidth:1024,dropClass:"menu-open",...t},a=document.querySelectorAll(e);a.length>0&&a.forEach((t=>{t.addEventListener("click",(t=>{window.innerWidth>n.maxScreenWidth||t.target.classList.contains("mobile__arrow")&&(t.stopPropagation(),t.preventDefault(),t.currentTarget.classList.contains(n.dropClass)?t.currentTarget.classList.remove(n.dropClass):(document.querySelectorAll(e).forEach((e=>{e.classList.remove(n.dropClass)})),t.currentTarget.classList.add(n.dropClass)))}))}))}(".menu__item--has-dropdown",{dropClass:"menu__item--open"}),function(e,t){let n=document.getElementsByClassName("hamburger");if(!n.length)return;let a=n[0];const o=a.getAttribute("data-target"),s={openClass:"menu--open",activeClass:"hamburger--active"};a&&a.addEventListener("click",(()=>{a.firstElementChild.classList.toggle(s.activeClass),document.getElementById(o).classList.toggle(s.openClass)}))}(),(()=>{const e=function(){let e=arguments.length>0&&void 0!==arguments[0]&&arguments[0];fetch("/wp-admin/admin-ajax.php?action=set_consent&all="+(e?"1":"0")).then((t=>{e&&location.reload(!0)}))};window.addEventListener("DOMContentLoaded",(()=>{const t=document.getElementById("allCookiesCheck"),n=document.getElementById("consentPrivacy");if(!n)return;n.addEventListener("click",(()=>{e(t.checked),document.getElementById("consentDialog").classList.remove("modal--open")}));const a=document.getElementById("consentAll");if(!a)return;a.addEventListener("click",(()=>{t.checked=!0,e(t.checked),document.getElementById("consentDialog").classList.remove("modal--open")}));const o=document.getElementById("openCookiesDialog");o&&o.addEventListener("click",(()=>{document.getElementById("consentDialog").classList.add("modal--open")}))}))})()}))}();