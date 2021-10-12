/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/app.js":
/*!******************************!*\
  !*** ./assets/src/js/app.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _validity_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./validity.js */ "./assets/src/js/validity.js");
/* harmony import */ var _booking_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./booking.js */ "./assets/src/js/booking.js");


document.addEventListener("focusout", _validity_js__WEBPACK_IMPORTED_MODULE_0__.default);
document.addEventListener("change", _validity_js__WEBPACK_IMPORTED_MODULE_0__.default);
document.addEventListener('click', function (event) {
  document.querySelectorAll('.menu__item--has-dropdown').forEach(function (element) {
    element.classList.remove("menu__item--open");
  });
});
var menu = document.querySelectorAll('.menu__item--has-dropdown');

if (menu.length > 0) {
  menu.forEach(function (element) {
    element.addEventListener('click', function (event) {
      event.stopPropagation();
      var open = false;

      if (event.currentTarget.classList.contains("menu__item--open")) {
        open = true;
      }

      document.querySelectorAll('.menu__item--has-dropdown').forEach(function (element) {
        element.classList.remove("menu__item--open");
      });

      if (open) {
        event.currentTarget.classList.remove("menu__item--open");
        return;
      }

      event.currentTarget.classList.add("menu__item--open");
    });
  });
}

var hamburger = document.getElementById('hamburger');

if (hamburger) {
  hamburger.addEventListener('click', function (event) {
    hamburger.firstElementChild.classList.toggle('is-active');
    var menu = document.getElementById('hamburger-menu');
    menu.classList.toggle("menu--open");
  });
}

/***/ }),

/***/ "./assets/src/js/booking.js":
/*!**********************************!*\
  !*** ./assets/src/js/booking.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/*
*   simple event dispatcher that will forward  the jQuery em-booking-events to standars JavaScript Events
*
*
*/
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((function () {
  var consentCheckbox = document.querySelector(".input-field-data_privacy_consent input");

  if (consentCheckbox) {
    var spanElement = document.createElement('span');
    spanElement.classList.add("checkbox-element");
    consentCheckbox.insertAdjacentHTML('afterend', "<span></span>");
  }

  jQuery(document).on('em_booking_error', function (event, message) {
    var event = new CustomEvent('bookingerror', {
      bubbles: true,
      cancelable: true,
      detail: {
        message: message
      }
    });
    window.dispatchEvent(event);
  });
  jQuery(document).on('em_booking_success', function (event, message) {
    var event = new CustomEvent('bookingsuccess', {
      bubbles: true,
      cancelable: true,
      detail: {
        message: message
      }
    });
    window.dispatchEvent(event); //UIkit.notification(EM.bb_booked, {status:'success'});
  });
})());

/***/ }),

/***/ "./assets/src/js/validity.js":
/*!***********************************!*\
  !*** ./assets/src/js/validity.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ validateInput)
/* harmony export */ });
function validateInput(event) {
  var errorMessage = event.target.parentElement.querySelector(".error-message");

  if (errorMessage != undefined) {
    errorMessage.remove();
  }

  if (!event.target.required) {
    return;
  }

  if (event.target.validity.valid) {
    event.target.parentElement.classList.remove("error");
    return;
  }

  event.target.parentElement.classList.add("error");
  var span = document.createElement("span");
  span.classList.add("error-message");
  span.innerText = event.target.validationMessage;

  if (event.target.getAttribute("data-text-error")) {
    span.innerText = event.target.getAttribute("data-text-error");
  }

  event.target.parentNode.append(span);
  return;
}

/***/ }),

/***/ "./assets/src/css/admin.css":
/*!**********************************!*\
  !*** ./assets/src/css/admin.css ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/dist/app": 0,
/******/ 			"assets/dist/admin": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkkids_team"] = self["webpackChunkkids_team"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/dist/admin"], () => (__webpack_require__("./assets/src/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/dist/admin"], () => (__webpack_require__("./assets/src/css/admin.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;