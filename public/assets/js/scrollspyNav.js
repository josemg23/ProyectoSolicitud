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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/scrollspyNav.js":
/*!*********************************************!*\
  !*** ./resources/assets/js/scrollspyNav.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("// Cache selectors\nvar lastId,\n    sidenav = $(\".sidenav\"),\n    // All list items\nmenuItems = sidenav.find(\"a\");\nmenuItems.on('click', function (event) {\n  // Make sure this.hash has a value before overriding default behavior\n  if (this.hash !== \"\") {\n    // Prevent default anchor click behavior\n    event.preventDefault(); // Store hash\n\n    var hash = this.hash; // Using jQuery's animate() method to add smooth page scroll\n    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area\n\n    $('html, body').animate({\n      scrollTop: $(hash).offset().top + -82\n    }, 800);\n  } // End if\n\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3Njcm9sbHNweU5hdi5qcz83YTQyIl0sIm5hbWVzIjpbImxhc3RJZCIsInNpZGVuYXYiLCIkIiwibWVudUl0ZW1zIiwiZmluZCIsIm9uIiwiZXZlbnQiLCJoYXNoIiwicHJldmVudERlZmF1bHQiLCJhbmltYXRlIiwic2Nyb2xsVG9wIiwib2Zmc2V0IiwidG9wIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBLElBQUlBLE1BQUo7QUFBQSxJQUNJQyxPQUFPLEdBQUdDLENBQUMsQ0FBQyxVQUFELENBRGY7QUFBQSxJQUVJO0FBQ0FDLFNBQVMsR0FBR0YsT0FBTyxDQUFDRyxJQUFSLENBQWEsR0FBYixDQUhoQjtBQUtBRCxTQUFTLENBQUNFLEVBQVYsQ0FBYSxPQUFiLEVBQXNCLFVBQVNDLEtBQVQsRUFBZ0I7QUFDcEM7QUFDQSxNQUFJLEtBQUtDLElBQUwsS0FBYyxFQUFsQixFQUFzQjtBQUNwQjtBQUNBRCxTQUFLLENBQUNFLGNBQU4sR0FGb0IsQ0FJcEI7O0FBQ0EsUUFBSUQsSUFBSSxHQUFHLEtBQUtBLElBQWhCLENBTG9CLENBT3BCO0FBQ0E7O0FBQ0FMLEtBQUMsQ0FBQyxZQUFELENBQUQsQ0FBZ0JPLE9BQWhCLENBQXdCO0FBQ3RCQyxlQUFTLEVBQUVSLENBQUMsQ0FBQ0ssSUFBRCxDQUFELENBQVFJLE1BQVIsR0FBaUJDLEdBQWpCLEdBQXVCLENBQUM7QUFEYixLQUF4QixFQUVHLEdBRkg7QUFHRCxHQWRtQyxDQWNqQzs7QUFDSixDQWZEIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JvbGxzcHlOYXYuanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBDYWNoZSBzZWxlY3RvcnNcclxudmFyIGxhc3RJZCxcclxuICAgIHNpZGVuYXYgPSAkKFwiLnNpZGVuYXZcIiksXHJcbiAgICAvLyBBbGwgbGlzdCBpdGVtc1xyXG4gICAgbWVudUl0ZW1zID0gc2lkZW5hdi5maW5kKFwiYVwiKTtcclxuXHJcbm1lbnVJdGVtcy5vbignY2xpY2snLCBmdW5jdGlvbihldmVudCkge1xyXG4gIC8vIE1ha2Ugc3VyZSB0aGlzLmhhc2ggaGFzIGEgdmFsdWUgYmVmb3JlIG92ZXJyaWRpbmcgZGVmYXVsdCBiZWhhdmlvclxyXG4gIGlmICh0aGlzLmhhc2ggIT09IFwiXCIpIHtcclxuICAgIC8vIFByZXZlbnQgZGVmYXVsdCBhbmNob3IgY2xpY2sgYmVoYXZpb3JcclxuICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XHJcblxyXG4gICAgLy8gU3RvcmUgaGFzaFxyXG4gICAgdmFyIGhhc2ggPSB0aGlzLmhhc2g7XHJcblxyXG4gICAgLy8gVXNpbmcgalF1ZXJ5J3MgYW5pbWF0ZSgpIG1ldGhvZCB0byBhZGQgc21vb3RoIHBhZ2Ugc2Nyb2xsXHJcbiAgICAvLyBUaGUgb3B0aW9uYWwgbnVtYmVyICg4MDApIHNwZWNpZmllcyB0aGUgbnVtYmVyIG9mIG1pbGxpc2Vjb25kcyBpdCB0YWtlcyB0byBzY3JvbGwgdG8gdGhlIHNwZWNpZmllZCBhcmVhXHJcbiAgICAkKCdodG1sLCBib2R5JykuYW5pbWF0ZSh7XHJcbiAgICAgIHNjcm9sbFRvcDogJChoYXNoKS5vZmZzZXQoKS50b3AgKyAtODJcclxuICAgIH0sIDgwMCk7XHJcbiAgfSAgLy8gRW5kIGlmXHJcbn0pOyJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/assets/js/scrollspyNav.js\n");

/***/ }),

/***/ 2:
/*!***************************************************!*\
  !*** multi ./resources/assets/js/scrollspyNav.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\Solicitudes\resources\assets\js\scrollspyNav.js */"./resources/assets/js/scrollspyNav.js");


/***/ })

/******/ });