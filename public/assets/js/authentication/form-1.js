/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/authentication/form-1.js":
/*!******************************************************!*\
  !*** ./resources/assets/js/authentication/form-1.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var togglePassword = document.getElementById(\"toggle-password\");\n\nif (togglePassword) {\n  togglePassword.addEventListener('click', function () {\n    var x = document.getElementById(\"password\");\n\n    if (x.type === \"password\") {\n      x.type = \"text\";\n    } else {\n      x.type = \"password\";\n    }\n  });\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL2F1dGhlbnRpY2F0aW9uL2Zvcm0tMS5qcz84MzEyIl0sIm5hbWVzIjpbInRvZ2dsZVBhc3N3b3JkIiwiZG9jdW1lbnQiLCJnZXRFbGVtZW50QnlJZCIsImFkZEV2ZW50TGlzdGVuZXIiLCJ4IiwidHlwZSJdLCJtYXBwaW5ncyI6IkFBQUEsSUFBSUEsY0FBYyxHQUFHQyxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsaUJBQXhCLENBQXJCOztBQUVBLElBQUlGLGNBQUosRUFBb0I7QUFDbkJBLGdCQUFjLENBQUNHLGdCQUFmLENBQWdDLE9BQWhDLEVBQXlDLFlBQVc7QUFDbEQsUUFBSUMsQ0FBQyxHQUFHSCxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsVUFBeEIsQ0FBUjs7QUFDQSxRQUFJRSxDQUFDLENBQUNDLElBQUYsS0FBVyxVQUFmLEVBQTJCO0FBQ3pCRCxPQUFDLENBQUNDLElBQUYsR0FBUyxNQUFUO0FBQ0QsS0FGRCxNQUVPO0FBQ0xELE9BQUMsQ0FBQ0MsSUFBRixHQUFTLFVBQVQ7QUFDRDtBQUNGLEdBUEQ7QUFRQSIsImZpbGUiOiIuL3Jlc291cmNlcy9hc3NldHMvanMvYXV0aGVudGljYXRpb24vZm9ybS0xLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsidmFyIHRvZ2dsZVBhc3N3b3JkID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJ0b2dnbGUtcGFzc3dvcmRcIik7XHJcblxyXG5pZiAodG9nZ2xlUGFzc3dvcmQpIHtcclxuXHR0b2dnbGVQYXNzd29yZC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKCkge1xyXG5cdCAgdmFyIHggPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcInBhc3N3b3JkXCIpO1xyXG5cdCAgaWYgKHgudHlwZSA9PT0gXCJwYXNzd29yZFwiKSB7XHJcblx0ICAgIHgudHlwZSA9IFwidGV4dFwiO1xyXG5cdCAgfSBlbHNlIHtcclxuXHQgICAgeC50eXBlID0gXCJwYXNzd29yZFwiO1xyXG5cdCAgfVxyXG5cdH0pO1xyXG59XHJcbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/assets/js/authentication/form-1.js\n");

/***/ }),

/***/ 1:
/*!************************************************************!*\
  !*** multi ./resources/assets/js/authentication/form-1.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\Solicitudes\resources\assets\js\authentication\form-1.js */"./resources/assets/js/authentication/form-1.js");


/***/ })

/******/ });