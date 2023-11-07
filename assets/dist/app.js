/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/cookies.js":
/*!**********************************!*\
  !*** ./assets/src/js/cookies.js ***!
  \**********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
const cookies = () => {
  const sendConsentRequest = function () {
    let all = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
    const args = all ? '1' : '0';
    fetch('/wp-admin/admin-ajax.php?action=set_consent&all=' + args).then(response => {
      if (all) {
        location.reload(true);
      }
    });
  };
  window.addEventListener('DOMContentLoaded', () => {
    const consentBox = document.getElementById("allCookiesCheck");
    const okClick = document.getElementById('consentPrivacy');
    if (!okClick) return;
    okClick.addEventListener('click', () => {
      sendConsentRequest(consentBox.checked);
      document.getElementById('consentDialog').classList.remove('modal--open');
    });
    const allClick = document.getElementById('consentAll');
    if (!allClick) return;
    allClick.addEventListener('click', () => {
      consentBox.checked = true;
      sendConsentRequest(consentBox.checked);
      document.getElementById('consentDialog').classList.remove('modal--open');
    });
    const openDialog = document.getElementById('openCookiesDialog');
    if (!openDialog) return;
    openDialog.addEventListener('click', () => {
      document.getElementById('consentDialog').classList.add('modal--open');
    });
  });
};
/* harmony default export */ __webpack_exports__["default"] = (cookies);

/***/ }),

/***/ "./assets/src/js/formTrap.js":
/*!***********************************!*\
  !*** ./assets/src/js/formTrap.js ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
const formTrap = function () {
  let formClass = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'form--trap';
  let alreadyFocussing = false;
  const setTarget = e => {
    const form = e.target.form;
    const focusableElements = form.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    const elementToFocus = e.shiftKey ? focusableElements[focusableElements.length - 1] : focusableElements[0];
    if (e.key !== 'Tab') return;
    if (document.activeElement === focusableElements[focusableElements.length - 1] || document.activeElement === focusableElements[0] && e.shiftKey) {
      console.log('focussing', elementToFocus);
      elementToFocus.focus();
      e.preventDefault();
    }
  };
  document.addEventListener('focusin', e => {
    const form = e.target.form;
    if (!form?.classList?.contains(formClass)) return;
    if (form && !alreadyFocussing) {
      alreadyFocussing = true;
      document.addEventListener('keydown', setTarget);
      return;
    }
    if (!form) {
      alreadyFocussing = false;
      document.removeEventListener('keydown', setTarget);
    }
  });
};
/* harmony default export */ __webpack_exports__["default"] = (formTrap);

/***/ }),

/***/ "./assets/src/js/menu.js":
/*!*******************************!*\
  !*** ./assets/src/js/menu.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "menuDrawer": function() { return /* binding */ menuDrawer; },
/* harmony export */   "menuDropdown": function() { return /* binding */ menuDropdown; }
/* harmony export */ });
/**
 * Open a dropdown menu, but only on amaximum screen width
 *
 * @param {string} itemClass class that contains the menu item
 * @param {Object} args
 */
function menuDropdown(itemClass, args) {
  const options = {
    maxScreenWidth: 1024,
    dropClass: 'menu-open',
    ...args
  };
  const closeAllDropdowns = () => {
    document.querySelectorAll(itemClass).forEach(el => {
      el.classList.remove(options.dropClass);
    });
  };
  const menu = document.querySelectorAll(itemClass);
  console.log(menu);
  if (menu.length > 0) {
    menu.forEach(element => {
      element.addEventListener('click', event => {
        if (window.innerWidth > options.maxScreenWidth) return;
        if (!event.target.classList.contains('mobile__arrow')) return;
        event.stopPropagation();
        event.preventDefault();
        if (event.currentTarget.classList.contains(options.dropClass)) {
          event.currentTarget.classList.remove(options.dropClass);
          return;
        }
        closeAllDropdowns();
        event.currentTarget.classList.add(options.dropClass);
      });
    });
  }
}

/**
 *   Open menu on mobile when hamburger icon is clicked
 *
 * @param {string} hamburgerId
 * @param {Object} args
 */
function menuDrawer(hamburgerId, args) {
  let hamburgers = document.getElementsByClassName('hamburger');
  console.log(hamburgerId);
  if (!hamburgers.length) return;
  let hamburger = hamburgers[0];
  const target = hamburger.getAttribute('data-target');
  const options = {
    openClass: 'menu--open',
    activeClass: 'hamburger--active',
    ...args
  };
  if (hamburger) {
    hamburger.addEventListener('click', () => {
      hamburger.firstElementChild.classList.toggle(options.activeClass);
      const menu = document.getElementById(target);
      //menuDropdown({ closeAll: true });
      menu.classList.toggle(options.openClass);
    });
  }
}


/***/ }),

/***/ "./assets/src/js/validity.js":
/*!***********************************!*\
  !*** ./assets/src/js/validity.js ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/**
 * This function extends the browsers own validity system. It removes the default error
 *
 * @param {Object} args
 */
const validateInput = args => {
  const conf = {
    events: ['focusout', 'change'],
    errorClass: 'error',
    notEmptyClass: 'filled',
    ...args
  };
  const checkIfEmpty = event => {
    if (event.target.value == null || event.target.value == "") {
      event.target.parentElement.classList.remove(conf.notEmptyClass);
      return;
    }
    event.target.parentElement.classList.add(conf.notEmptyClass);
  };
  const addErrorListener = event => {
    var _event$target$getAttr;
    checkIfEmpty(event);
    if (!event.target.required) return;
    const errorMessage = event.target.parentElement.querySelector('.error-message');
    if (errorMessage !== null) errorMessage.remove();
    if (event.target.validity.valid) {
      event.target.parentElement.classList.remove(conf.errorClass);
      return;
    }
    event.target.parentElement.classList.add('error');
    const message = (_event$target$getAttr = event.target.getAttribute('data-text-error')) !== null && _event$target$getAttr !== void 0 ? _event$target$getAttr : event.target.validationMessage;
    const span = document.createElement('span');
    span.innerHTML = message;
    span.classList.add('error-message');
    event.target.parentNode.append(span);
  };
  for (event of conf.events) {
    document.addEventListener(event, addErrorListener);
  }
};
/* harmony default export */ __webpack_exports__["default"] = (validateInput);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!******************************!*\
  !*** ./assets/src/js/app.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _validity_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./validity.js */ "./assets/src/js/validity.js");
/* harmony import */ var _menu_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./menu.js */ "./assets/src/js/menu.js");
/* harmony import */ var _cookies_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./cookies.js */ "./assets/src/js/cookies.js");
/* harmony import */ var _formTrap_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./formTrap.js */ "./assets/src/js/formTrap.js");




document.addEventListener("DOMContentLoaded", function (event) {
  (0,_validity_js__WEBPACK_IMPORTED_MODULE_0__["default"])();
  (0,_formTrap_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
  (0,_menu_js__WEBPACK_IMPORTED_MODULE_1__.menuDropdown)('.menu__item--has-dropdown', {
    dropClass: 'menu__item--open'
  });
  (0,_menu_js__WEBPACK_IMPORTED_MODULE_1__.menuDrawer)('hamburger');
  (0,_cookies_js__WEBPACK_IMPORTED_MODULE_2__["default"])();
});
}();
/******/ })()
;
//# sourceMappingURL=app.js.map