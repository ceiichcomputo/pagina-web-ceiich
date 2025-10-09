"use strict";
 var $ = jQuery.noConflict();
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/components/address-bar.js":
/*!******************************************!*\
  !*** ./src/js/components/address-bar.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWBrowserAddressBar)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWBrowserAddressBar = /*#__PURE__*/function () {
  function KFWBrowserAddressBar(options) {
    _classCallCheck(this, KFWBrowserAddressBar);
    this.options = $.extend(true, {
      browserMetaEle: "meta[data-kinfw-browser-color]"
    }, options);
    this._init();
  }
  return _createClass(KFWBrowserAddressBar, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var $browserMetaEle = _self.options.browserMetaEle;
      var $ele = document.querySelectorAll($browserMetaEle);
      if ($ele.length > 0) {
        _self._execute($ele);
      }
    }
  }, {
    key: "_execute",
    value: function _execute($ele) {
      $ele.forEach(function ($e) {
        var $colorCode = $e.getAttribute("content"),
          $colorVal = getComputedStyle(document.documentElement).getPropertyValue($colorCode).trim();
        $e.setAttribute('content', $colorVal);
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/anchor.js":
/*!*************************************!*\
  !*** ./src/js/components/anchor.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWAnchors)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWAnchors = /*#__PURE__*/function () {
  function KFWAnchors(options) {
    _classCallCheck(this, KFWAnchors);
    this.options = $.extend(true, {
      anchorScrollDuration: 500,
      anchorSelectors: {
        links: 'a[href*="#"]',
        scrollable: 'html,body'
      }
    }, options);
    this._init();
  }
  return _createClass(KFWAnchors, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $links = _self$options.anchorSelectors.links;
      $($bodyEle).on('click', $links, function (event) {
        _self._handleAnchorLinks(event, _self.options);
      });
    }
  }, {
    key: "_handleAnchorLinks",
    value: function _handleAnchorLinks(event, $options) {
      var clickedLink = event.currentTarget,
        isSamePathname = location.pathname === clickedLink.pathname,
        isSameHostname = location.hostname === clickedLink.hostname,
        $anchor;
      if (!isSameHostname || !isSamePathname || clickedLink.hash.length < 2) {
        return;
      }
      try {
        $anchor = $(clickedLink.hash);
      } catch (e) {
        return;
      }
      if (!$anchor.length) {
        return;
      }
      var scrollTop = $anchor.offset().top;
      var $bodyEle = $options.bodyEle,
        $utils = $options.utils,
        $anchorScrollDuration = $options.anchorScrollDuration;
      var $hasAdminBar = $utils._isBool($utils._hasState($bodyEle, 'admin-bar'));
      if ($hasAdminBar) {
        scrollTop -= $("#wpadminbar").height();
      }
      if ($("#kinfw-sticky-header").length > 0) {
        if ($("#kinfw-sticky-header").hasClass("kinfw-header-sticky-on")) {
          scrollTop -= $("#kinfw-sticky-header").height();
        }
      }
      var $scrollable = $options.anchorSelectors.scrollable;
      $($scrollable).animate({
        scrollTop: scrollTop
      }, $anchorScrollDuration, 'linear', function () {});
      event.preventDefault();
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/body-scroll-smoother.js":
/*!***************************************************!*\
  !*** ./src/js/components/body-scroll-smoother.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWBodyScrollSmoother)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWBodyScrollSmoother = /*#__PURE__*/function () {
  function KFWBodyScrollSmoother(options) {
    _classCallCheck(this, KFWBodyScrollSmoother);
    this.options = $.extend(true, {
      headerEle: "#kinfw-masthead",
      mainContentEle: "#kinfw-content-wrap",
      footerEle: "#kinfw-footer",
      wrapper: "#kinfw-smooth-wrapper",
      content: "#kinfw-smooth-content",
      effectsPrefix: "gsap-smooth-scroll-",
      smooth: 1.43,
      effects: true,
      smoothTouch: false,
      normalizeScroll: false,
      ignoreMobileResize: true
    }, options);
    this._init();
  }
  return _createClass(KFWBodyScrollSmoother, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $utils = _self$options.utils;
      if (window.location.hash) {
        $utils._scrollToHash();
      } else {
        var $elementorEditor = _self.options.elementorMode,
          $isWooPages = $utils._isBool($utils._hasState($bodyEle, 'woocommerce-page')),
          $isBlogTplPreview = $utils._isBool($utils._hasState($bodyEle, 'single-kinfw-blog-post-look')),
          $isHeaderTplPreview = $utils._isBool($utils._hasState($bodyEle, 'single-kinfw-header')),
          $isFooterTplPreview = $utils._isBool($utils._hasState($bodyEle, 'single-kinfw-footer'));
        if (!$elementorEditor && !$isWooPages && !$isHeaderTplPreview && !$isFooterTplPreview && !$isBlogTplPreview) {
          this._execute();
          this._headerEle();
          $(window).resize(function () {
            _self._headerEle();
          });
        }
      }
    }
  }, {
    key: "_execute",
    value: function _execute() {
      var _self = this;
      var _self$options2 = _self.options,
        $wrapper = _self$options2.wrapper,
        $content = _self$options2.content,
        $effectsPrefix = _self$options2.effectsPrefix,
        $smooth = _self$options2.smooth,
        $effects = _self$options2.effects,
        $smoothTouch = _self$options2.smoothTouch,
        $normalizeScroll = _self$options2.normalizeScroll,
        $ignoreMobileResize = _self$options2.ignoreMobileResize,
        $utils = _self$options2.utils;
      var mm = gsap.matchMedia();
      var gsapScrollSmoother;

      // this setup code only runs when viewport is at least 768px wide
      mm.add("(min-width: 768px)", function () {
        gsapScrollSmoother = ScrollSmoother.create({
          wrapper: $wrapper,
          content: $content,
          effectsPrefix: $effectsPrefix,
          smooth: $smooth,
          effects: $effects,
          smoothTouch: $smoothTouch,
          normalizeScroll: $normalizeScroll,
          ignoreMobileResize: $ignoreMobileResize
        });
      });

      // Listen for hash changes and log when it happens
      window.addEventListener("hashchange", function () {
        gsapScrollSmoother.kill();
        $utils._scrollToHash();
      });
    }
  }, {
    key: "_headerEle",
    value: function _headerEle() {
      var _self = this;
      var _self$options3 = _self.options,
        $bodyEle = _self$options3.bodyEle,
        $headerEle = _self$options3.headerEle,
        $windowEle = _self$options3.windowEle,
        $mainContentEle = _self$options3.mainContentEle,
        $footerEle = _self$options3.footerEle,
        $utils = _self$options3.utils;
      var $bodyHasAdminBar = $utils._hasState($bodyEle, 'admin-bar');
      if ($($headerEle).length > 0 && $windowEle.width() > 768) {
        var $headerEleHeight = $($headerEle).height(),
          $roundedHeight = Math.round($headerEleHeight);
        if ($bodyHasAdminBar) {
          $roundedHeight += Math.round($("#wpadminbar").height());
        }
        $($mainContentEle).css('margin-top', $roundedHeight + 'px');
        if ($($footerEle).length > 0) {
          $($footerEle).css('padding-bottom', $roundedHeight + 'px');
        }
      }
      if ($windowEle.width() < 768) {
        $($mainContentEle).css('margin-top', '');
        $($footerEle).css('padding-bottom', '');
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/cursor.js":
/*!*************************************!*\
  !*** ./src/js/components/cursor.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWCursor)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWCursor = /*#__PURE__*/function () {
  function KFWCursor(options) {
    _classCallCheck(this, KFWCursor);
    this.options = $.extend(true, {
      cursorSpeed: 0.7,
      cursorEase: "expo.out",
      cursorVisibleTimeout: 300
    }, options);
    this.magneticOptions = {
      x: .1,
      y: .1,
      speed: .1,
      rspeed: .1
    };
    this._init();
  }
  return _createClass(KFWCursor, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $utils = _self$options.utils;
      var $isMobile = $utils._isMobile(),
        $hasModule = $utils._isBool($utils._hasState($bodyEle, 'kinfw-has-site-custom-cursor')),
        $elementorEditor = _self.options.elementorMode;
      if ($hasModule && !$isMobile) {
        if ($elementorEditor) {
          _self._editorEnd();
        } else {
          _self._frontEnd();
        }
        _self._execute();
      }
    }
  }, {
    key: "_execute",
    value: function _execute() {
      var _self = this;
      var _self$options2 = _self.options,
        $bodyAltEle = _self$options2.bodyAltEle,
        $utils = _self$options2.utils;
      $bodyAltEle.insertAdjacentHTML('afterbegin', '<div class="kinfw-cursor" data-color="' + kinfw_onnat_L10n.defaultCursorColor + '" data-size="' + kinfw_onnat_L10n.defaultCursorSize + '">' + '<div class="kinfw-cursor-text">' + '</div>' + '</div>');
      _self.options.cursorEle = document.querySelector('.kinfw-cursor');
      _self.options.cursorTxtEle = document.querySelector('.kinfw-cursor-text');
      this._bind();
      this._move(-window.innerWidth, -window.innerHeight, 0);
    }
  }, {
    key: "_bind",
    value: function _bind() {
      var _self = this;
      var _self$options3 = _self.options,
        $bodyEle = _self$options3.bodyEle,
        $cursorEle = _self$options3.cursorEle,
        $utils = _self$options3.utils;
      $bodyEle.on('mouseenter', function () {
        _self._show();
      }).on('mouseleave', function () {
        _self._hide();
      }).on('mousedown', function () {
        $utils._setState($cursorEle, '-kinfw-cursor-active');
      }).on('mouseup', function () {
        $utils._removeState($cursorEle, '-kinfw-cursor-active');
      }).on('mousemove', function ($e) {
        _self.pos = {
          x: _self.stick ? _self.stick.x - (_self.stick.x - $e.clientX) * 0.15 : $e.clientX,
          y: _self.stick ? _self.stick.y - (_self.stick.y - $e.clientY) * 0.15 : $e.clientY
        };
        _self._update();
        //_self._handleMouseMove( $e.clientX, $e.clientY );
      });
      $bodyEle.on('mouseenter', 'iframe', function () {
        _self._hide();
      }).on('mouseleave', 'iframe', function () {
        _self._show();
      });
      $bodyEle.on('mouseenter', 'a,input,textarea,button', function () {
        $utils._setState($cursorEle, '-kinfw-cursor-pointer');
      }).on('mouseleave', 'a,input,textarea,button', function () {
        $utils._removeState($cursorEle, '-kinfw-cursor-pointer');
      });
      $bodyEle.on('mouseenter', '[data-kinfw-cursor-color]', function () {
        $($cursorEle).attr("data-color", this.dataset.kinfwCursorColor);
      }).on('mouseleave', '[data-kinfw-cursor-color]', function () {
        $($cursorEle).attr('data-color', kinfw_onnat_L10n.defaultCursorColor);
      });
      $bodyEle.on('mouseenter', '[data-kinfw-cursor-size]', function () {
        $($cursorEle).attr("data-size", this.dataset.kinfwCursorSize);
      }).on('mouseleave', '[data-kinfw-cursor-size]', function () {
        $($cursorEle).attr('data-size', kinfw_onnat_L10n.defaultCursorSize);
      });
      $bodyEle.on('mouseenter', '[data-kinfw-cursor-opaque]', function () {
        $($cursorEle).attr('data-opaque', this.dataset.kinfwCursorOpaque);
      }).on('mouseleave', '[data-kinfw-cursor-opaque]', function () {
        $($cursorEle).attr('data-opaque', "no");
        $($cursorEle).attr('data-size', kinfw_onnat_L10n.defaultCursorSize);
      });
      $bodyEle.on('mouseenter', '[data-kinfw-cursor-txt]', function () {
        _self._setText(this.dataset.kinfwCursorTxt);
      }).on('mouseleave', '[data-kinfw-cursor-txt]', function () {
        _self._removeText();
      });
      $bodyEle.on('mouseenter', '[data-kinfw-cursor-stick]', function () {
        _self._setStick(this.dataset.kinfwCursorStick);
      }).on('mouseleave', '[data-kinfw-cursor-stick]', function () {
        _self._removeStick();
      });
      $bodyEle.on('mouseenter', '[data-kinfw-cursor-magnetic]', function () {
        _self.magneticX = $(this).offset().left - window.pageXOffset;
        _self.magneticY = $(this).offset().top - window.pageYOffset;
        _self.magneticWidth = $(this).outerWidth();
        _self.magneticHeight = $(this).outerHeight();
      }).on('mouseleave', '[data-kinfw-cursor-magnetic]', function () {
        var orspeed = $(this).data('magnetic') && $(this).data('magnetic').rspeed ? $(this).data('magnetic').rspeed : _self.magneticOptions.rspeed;
        _self._magneticMove($(this), 0, 0, orspeed);
      }).on('mousemove', '[data-kinfw-cursor-magnetic]', function ($e) {
        var ox = $(this).data('magnetic') && $(this).data('magnetic').x ? $(this).data('magnetic').x : _self.magneticOptions.x;
        var oy = $(this).data('magnetic') && $(this).data('magnetic').y ? $(this).data('magnetic').y : _self.magneticOptions.y;
        var ospeed = $(this).data('magnetic') && $(this).data('magnetic').speed ? $(this).data('magnetic').speed : _self.magneticOptions.speed;
        var x = ($e.clientX - _self.magneticX - _self.magneticWidth / 2) * ox;
        var y = ($e.clientY - _self.magneticY - _self.magneticHeight / 2) * oy;
        _self._magneticMove($(this), x, y, ospeed);
      });
    }
  }, {
    key: "_move",
    value: function _move($x, $y, $duration) {
      var _self = this;
      gsap.to($(_self.options.cursorEle), {
        x: $x || _self.pos.x,
        y: $y || _self.pos.y,
        force3D: true,
        overwrite: true,
        ease: _self.options.cursorEase,
        duration: _self.visible ? $duration || _self.options.cursorSpeed : 0
      });
    }
  }, {
    key: "_show",
    value: function _show() {
      var _this = this;
      var _self = this;
      var _self$options4 = _self.options,
        $cursorEle = _self$options4.cursorEle,
        $utils = _self$options4.utils;
      if (_self.visible) return;
      clearInterval(_self.visibleInt);
      $utils._setState($cursorEle, '-kinfw-cursor-visible');
      _self.visibleInt = setTimeout(function () {
        return _this.visible = true;
      });
    }
  }, {
    key: "_hide",
    value: function _hide() {
      var _self = this;
      var _self$options5 = _self.options,
        $cursorEle = _self$options5.cursorEle,
        $utils = _self$options5.utils;
      $utils._removeState($cursorEle, '-kinfw-cursor-visible');
      _self.visibleInt = setTimeout(function () {
        return _self.visible = false;
      }, _self.options.cursorVisibleTimeout);
    }
  }, {
    key: "_update",
    value: function _update() {
      var _self = this;
      _self._move();
      _self._show();
    }
  }, {
    key: "_handleMouseMove",
    value: function _handleMouseMove($clientX, $clientY) {
      var _self = this;
      var $cursorEle = _self.options.cursorEle;
      var $targetElement = document.elementFromPoint($clientX, $clientY);
      if ($($targetElement).hasClass('elementor-section')) {
        var $settings = $targetElement.dataset.settings;
        $settings = JSON.parse($settings);
        if (_self.options.utils._isBool($settings.enable_kfw_cursor)) {
          $($cursorEle).attr("data-color", $targetElement.dataset.kinfwCursorColor);
          $($cursorEle).attr("data-size", $targetElement.dataset.kinfwCursorSize);
          $($cursorEle).attr("data-opaque", $targetElement.dataset.kinfwCursorOpaque);
        }
      }
    }
  }, {
    key: "_setText",
    value: function _setText($text) {
      var _self = this;
      var _self$options6 = _self.options,
        $cursorEle = _self$options6.cursorEle,
        $cursorTxtEle = _self$options6.cursorTxtEle,
        $utils = _self$options6.utils;
      $($cursorTxtEle).html($text);
      $utils._setState($cursorEle, '-kinfw-cursor-text');
    }
  }, {
    key: "_removeText",
    value: function _removeText() {
      var _self = this;
      var _self$options7 = _self.options,
        $cursorEle = _self$options7.cursorEle,
        $cursorTxtEle = _self$options7.cursorTxtEle,
        $utils = _self$options7.utils;
      $($cursorTxtEle).html("");
      $utils._removeState($cursorEle, '-kinfw-cursor-text');
    }
  }, {
    key: "_setStick",
    value: function _setStick($el) {
      var _self = this;
      var target = $($el);
      var bound = target.get(0).getBoundingClientRect();
      _self.stick = {
        y: bound.top + target.height() / 2,
        x: bound.left + target.width() / 2
      };
      _self._move(this.stick.x, this.stick.y, 5);
    }
  }, {
    key: "_removeStick",
    value: function _removeStick() {
      this.stick = false;
    }
  }, {
    key: "_magneticMove",
    value: function _magneticMove($ele, $x, $y, $speed) {
      gsap.to($ele, {
        x: $x,
        y: $y,
        force3D: true,
        overwrite: true,
        duration: $speed
      });
    }
  }, {
    key: "_editorEnd",
    value: function _editorEnd() {
      //console.log( window.elementorFrontend );
    }
  }, {
    key: "_frontEnd",
    value: function _frontEnd() {
      var _self = this;
      $('.elementor-element').each(function ($idx, $ele) {
        var $settings = $ele.dataset.settings;
        if (typeof $settings !== 'undefined') {
          $settings = JSON.parse($settings);
          if ($settings.hasOwnProperty('enable_kfw_cursor') && _self.options.utils._isBool($settings.enable_kfw_cursor)) {
            $($ele).attr('data-kinfw-cursor-color', '');
            $($ele).attr('data-kinfw-cursor-color', $settings.kfw_cursor_color);
            $($ele).attr('data-kinfw-cursor-size', '');
            $($ele).attr('data-kinfw-cursor-size', $settings.kfw_cursor_size);
            $($ele).attr('data-kinfw-cursor-opaque', 'no');
            $($ele).attr('data-kinfw-cursor-opaque', $settings.kfw_cursor_opaque);
          }
        }
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/fitvids.js":
/*!**************************************!*\
  !*** ./src/js/components/fitvids.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWFitVids)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWFitVids = /*#__PURE__*/function () {
  function KFWFitVids(options) {
    _classCallCheck(this, KFWFitVids);
    this.options = $.extend(true, {
      selector: 'iframe[src*="youtube"],iframe[src*="vimeo"],iframe[src*="dailymotion"],iframe[src*="maps.google.com"],iframe[src*="google.com/maps"]'
    }, options);
    this._init();
  }
  return _createClass(KFWFitVids, [{
    key: "_init",
    value: function _init() {
      if (typeof $.fn.fitVids !== 'function') {
        return;
      }
      var _self = this;
      var $selector = _self.options.selector;
      var $ele = $($selector).parent();
      $ele.fitVids({
        customSelector: $selector,
        ignore: '.wp-block-embed__wrapper' // To avoid fitvid for wp-block-embed for unit test.
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/go-to-top.js":
/*!****************************************!*\
  !*** ./src/js/components/go-to-top.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWGoToTop)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWGoToTop = /*#__PURE__*/function () {
  function KFWGoToTop(options) {
    _classCallCheck(this, KFWGoToTop);
    this.options = $.extend(true, {
      goToTopEle: "#kinfw-goto-top",
      offset: 50,
      duration: 500
    }, options);
    this._init();
  }
  return _createClass(KFWGoToTop, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $utils = _self$options.utils;
      var $hasModule = $utils._isBool($utils._hasState($bodyEle, 'kinfw-has-site-scroll-to-top'));
      if ($hasModule) {
        _self._execute();
      }
    }
  }, {
    key: "_execute",
    value: function _execute() {
      var _self = this;
      var _self$options2 = _self.options,
        $bodyEle = _self$options2.bodyEle,
        $goToTopEle = _self$options2.goToTopEle;
      var $ele = $($goToTopEle, $bodyEle);
      if ($ele.length > 0) {
        _self.options.duration = _typeof($ele.data("speed")) ? $ele.data("speed") : _self.options.duration;
        this._bindClick($ele);
        this._bindScroll($ele);
      }
    }
  }, {
    key: "_bindClick",
    value: function _bindClick($ele) {
      var _self = this;
      var $duration = _self.options.duration;
      var $bodyEle = document.querySelector('body');
      $ele.on("click", function ($e) {
        $e.preventDefault();
        if (typeof Scrollbar === 'function') {
          var $hasCustomScrollBar = Scrollbar.has($bodyEle);
          if ($hasCustomScrollBar) {
            var $bar = Scrollbar.get($bodyEle);
            $bar.scrollTo(0, 0, $duration);
          }
        } else {
          $("body,html").stop(true).animate({
            scrollTop: 0
          }, $duration);
        }
      });
    }
  }, {
    key: "_bindScroll",
    value: function _bindScroll($ele) {
      var _self = this;
      var _self$options3 = _self.options,
        $windowEle = _self$options3.windowEle,
        $offset = _self$options3.offset,
        $utils = _self$options3.utils;
      var $bodyEle = document.querySelector('body');
      $windowEle.on("scroll", function () {
        var $scrollTop;
        if (typeof Scrollbar === 'function') {
          var $hasCustomScrollBar = Scrollbar.has($bodyEle);
          if ($hasCustomScrollBar) {
            var $bar = Scrollbar.get($bodyEle);
            $scrollTop = $bar.scrollTop;
          }
        } else {
          $scrollTop = $(this).scrollTop();
        }
        if ($scrollTop > $offset) {
          $utils._setState($ele, "active");
        } else {
          $utils._removeState($ele, "active");
        }
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/headers/elements/hamburger-button.js":
/*!****************************************************************!*\
  !*** ./src/js/components/headers/elements/hamburger-button.js ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWHeaderElementHamburgerButton)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWHeaderElementHamburgerButton = /*#__PURE__*/function () {
  function KFWHeaderElementHamburgerButton(options) {
    _classCallCheck(this, KFWHeaderElementHamburgerButton);
    this.options = $.extend(true, {
      hamburgerTrigger: $(".kinfw-header-hamburger-btn-trigger"),
      hamburgerModal: $("#kinfw-header-hamburger-btn-modal"),
      hamburgerToggleClass: "kinfw-header-hamburger-open"
    }, options);
    this._init();
  }
  return _createClass(KFWHeaderElementHamburgerButton, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $utils = _self$options.utils,
        $popupModalToggleClass = _self$options.popupModalToggleClass,
        $bodyAltEle = _self$options.bodyAltEle,
        $trigger = _self$options.hamburgerTrigger,
        $modal = _self$options.hamburgerModal,
        $toggleClass = _self$options.hamburgerToggleClass;
      var $ele = $($trigger),
        $modalEle = $($bodyAltEle).find($modal),
        $closeBtn = $modalEle.find("a.kinfw-popup-modal-close");
      if ($ele.length > 0) {
        $ele.on("click", function (event) {
          event.preventDefault();
          $utils._toggleState($bodyAltEle, $toggleClass);
          $utils._toggleState($modal, $popupModalToggleClass);
        });
      }
      if ($closeBtn.length > 0) {
        $closeBtn.on("click", function () {
          $utils._toggleState($bodyAltEle, $toggleClass);
          $utils._toggleState($modal, $popupModalToggleClass);
        });
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/headers/elements/search.js":
/*!******************************************************!*\
  !*** ./src/js/components/headers/elements/search.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWHeaderElementSearch)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWHeaderElementSearch = /*#__PURE__*/function () {
  function KFWHeaderElementSearch(options) {
    _classCallCheck(this, KFWHeaderElementSearch);
    this.options = $.extend(true, {
      triggerEle: ".kinfw-header-search-trigger",
      searchModal: "#kinfw-header-search-form-modal",
      toggleClass: "kinfw-header-search-open"
    }, options);
    this._init();
  }
  return _createClass(KFWHeaderElementSearch, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var $bodyEle = document.querySelector('body');
      var _self$options = _self.options,
        $utils = _self$options.utils,
        $triggerEle = _self$options.triggerEle,
        $searchModal = _self$options.searchModal,
        $toggleClass = _self$options.toggleClass;
      var $ele = $($triggerEle),
        $searchEle = $($bodyEle).find($searchModal),
        $closeBtn = $searchEle.find("a.kinfw-header-search-form-close");
      if ($ele.length > 0) {
        $ele.on("click", function () {
          var $form = $(this).parents("body").find(".kinfw-header-search-form form"),
            $input = $form.find("input[name='s']");
          $utils._toggleState($bodyEle, $toggleClass);
          var $isOpen = $utils._hasState($bodyEle, $toggleClass);
          setTimeout(function () {
            if ($isOpen) {
              $input.focus();
            }
          }, 100);
        });
      }
      if ($closeBtn.length > 0) {
        $closeBtn.on("click", function () {
          $utils._toggleState($bodyEle, $toggleClass);
        });
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/headers/elements/user-login.js":
/*!**********************************************************!*\
  !*** ./src/js/components/headers/elements/user-login.js ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWHeaderElementUserLogin)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWHeaderElementUserLogin = /*#__PURE__*/function () {
  function KFWHeaderElementUserLogin(options) {
    _classCallCheck(this, KFWHeaderElementUserLogin);
    this.options = $.extend(true, {
      trigger: $(".kinfw-header-login-user-trigger"),
      modal: $("#kinfw-header-login-form-modal"),
      buttonLoader: '<span class="kinfw-btn-dot-loader">' + '<span class="kinfw-dot kinfw-dot-1"></span>' + '<span class="kinfw-dot kinfw-dot-2"></span>' + '<span class="kinfw-dot kinfw-dot-3"></span>' + '</span>'
    }, options);
    this._init();
  }
  return _createClass(KFWHeaderElementUserLogin, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $trigger = _self$options.trigger,
        $modal = _self$options.modal;
      if ($trigger.length > 0 && $modal.length > 0) {
        var $modalContent = $modal.find("#kinfw-header-login-form-modal-content"),
          $modalOverlay = $modal.find(".kinfw-header-login-form-modal-overlay"),
          $modalClose = $modal.find(".kinfw-header-login-form-close"),
          $modalRestPwd = $modal.find(".kinfw-header-login-lost-pwd a"),
          $modalNav = $modal.find(".kinfw-header-login-nav"),
          $modalForms = $modal.find("form");

        /**
         * Show Modal
         */
        $trigger.on("click", function (e) {
          e.preventDefault();
          _self._show($modal, $modalContent);
        });

        /**
         * Close Modal
         */
        $modalOverlay.on("click", function (e) {
          e.preventDefault();
          _self._hide($modal, $modalContent);
          _self._activateTab1($modalContent);
        });
        $modalClose.on("click", function (e) {
          e.preventDefault();
          _self._hide($modal, $modalContent);
          _self._activateTab1($modalContent);
        });
        $(window).on('keyup', function (e) {
          if (e.keyCode === 27) {
            _self._hide($modal, $modalContent);
            _self._activateTab1($modalContent);
          }
        });

        /**
         * Reset Password
         */
        $modalRestPwd.on("click", function () {
          $modalNav.find("li#kinfw-header-reset-pwd-form-nav a").trigger('click');
        });

        /**
         * Init Tab
         */
        if ($modalContent.length > 0) {
          _self._initTabs($modalContent);
        }

        /**
         * Form Submit
         */
        if ($modalForms.length > 0) {
          $modalForms.each(function () {
            var $form = $(this);
            $form.on("submit", function (e) {
              e.preventDefault();
              _self._submitForm($form);
            });
          });
        }
      }
    }
  }, {
    key: "_show",
    value: function _show($modal, $modalContent) {
      var _self = this;
      var $utils = _self.options.utils;
      _self._resetForms($modalContent);
      var $show = $utils._hasState($modal, "kinfw-header-login-modal-show");
      if (!$show) {
        $utils._setState($modal, "kinfw-header-login-modal-show");
      }
    }
  }, {
    key: "_hide",
    value: function _hide($modal, $modalContent) {
      var _self = this;
      var $utils = _self.options.utils;
      _self._resetForms($modalContent);
      var $show = $utils._hasState($modal, "kinfw-header-login-modal-show");
      if ($show) {
        $utils._removeState($modal, "kinfw-header-login-modal-show");
      }
    }
  }, {
    key: "_initTabs",
    value: function _initTabs($modalContent) {
      var _self = this;
      $modalContent.tabs({
        beforeActivate: function beforeActivate($event, $ui) {
          var $id = $($ui.newTab).attr("id");
          if ('kinfw-header-login-form-nav' == $id) {
            _self._resetForms($modalContent);
          }
          if ('kinfw-header-reset-pwd-form-nav' == $id) {
            $($modalContent).addClass("kinfw-header-reset-pwd-form-active");
          } else {
            $($modalContent).removeClass("kinfw-header-reset-pwd-form-active");
          }
        }
      });
    }
  }, {
    key: "_activateTab1",
    value: function _activateTab1($modalContent) {
      $modalContent.tabs("option", "active", 0);
    }
  }, {
    key: "_submitForm",
    value: function _submitForm($form) {
      var _self = this;
      var $formType = $form.find("input[name='form-type']").val();
      if ($formType == 'login') {
        _self._submitLogin($form);
      } else if ($formType == 'reset-pwd') {
        _self._submitResetPwd($form);
      } else if ($formType == 'register') {
        _self._submitRegistration($form);
      }
    }
  }, {
    key: "_submitLogin",
    value: function _submitLogin($loginForm) {
      var _self = this;
      var $loader = _self.options.buttonLoader,
        $formData = $loginForm.serializeArray(),
        $formRes = $loginForm.find(".kinfw-response");
      $formRes.empty();
      $formData.push({
        name: 'action',
        value: 'kinfw-action/theme/header/action/login-form/login'
      });
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: kinfw_onnat_L10n.ajax,
        data: $formData,
        beforeSend: function beforeSend() {
          $loginForm.find("button").html($loader);
        },
        success: function success($res) {
          if ($res.success) {
            $formRes.html('');
            setTimeout(function () {
              $loginForm.find("button").html($res.data.btn);
              window.location = $res.data.url;
            }, 500);
          } else {
            $formRes.html($res.data.msg);
            setTimeout(function () {
              $loginForm.find("button").html($res.data.btn);
            }, 500);
          }
        }
      });
    }
  }, {
    key: "_submitResetPwd",
    value: function _submitResetPwd($resetPwdFrom) {
      var _self = this;
      var $loader = _self.options.buttonLoader,
        $formData = $resetPwdFrom.serializeArray(),
        $formRes = $resetPwdFrom.find(".kinfw-response");
      $formRes.empty();
      $formData.push({
        name: 'action',
        value: 'kinfw-action/theme/header/action/login-form/reset-pwd'
      });
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: kinfw_onnat_L10n.ajax,
        data: $formData,
        beforeSend: function beforeSend() {
          $resetPwdFrom.find("button").html($loader);
        },
        success: function success($res) {
          if ($res.success) {
            $formRes.html($res.data.msg);
            $resetPwdFrom.find("button").html($res.data.btn);
            window.location = $res.data.url;
          } else {
            $formRes.html($res.data.msg);
            $resetPwdFrom.find("button").html($res.data.btn);
          }
        }
      });
    }
  }, {
    key: "_submitRegistration",
    value: function _submitRegistration($regForm) {
      var _self = this;
      var $loader = _self.options.buttonLoader,
        $formData = $regForm.serializeArray(),
        $formBtn = $regForm.find("button"),
        $formRes = $regForm.find(".kinfw-response");
      $formRes.empty();
      $formData.push({
        name: 'action',
        value: 'kinfw-action/theme/header/action/login-form/register-user'
      });
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: kinfw_onnat_L10n.ajax,
        data: $formData,
        beforeSend: function beforeSend() {
          $formBtn.html($loader);
        },
        success: function success($res) {
          if ($res.success) {
            $formRes.html($res.data.msg);
            $formBtn.html($formBtn.data("txt"));
            window.location = $res.data.url;
          } else {
            $formRes.html($res.data.msg);
            $formBtn.html($formBtn.data("txt"));
          }
        }
      });
    }
  }, {
    key: "_resetForms",
    value: function _resetForms($modalContent) {
      var $loginBtn = $modalContent.find("#kinfw-header-login-form button"),
        $resetPwdFrom = $modalContent.find("#kinfw-header-reset-pwd-form"),
        $resetPwdEmail = $resetPwdFrom.find("input[name='uname_email']"),
        $resetPwdBtn = $resetPwdFrom.find("button");
      $modalContent.find(".kinfw-response").html("");
      $loginBtn.html($loginBtn.data("txt"));
      $resetPwdEmail.val('');
      $resetPwdBtn.html($resetPwdBtn.data("txt"));
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/headers/mobile-header.js":
/*!****************************************************!*\
  !*** ./src/js/components/headers/mobile-header.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWMobileHeader)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWMobileHeader = /*#__PURE__*/function () {
  function KFWMobileHeader(options) {
    _classCallCheck(this, KFWMobileHeader);
    this.options = $.extend(true, {
      headerEle: "#kinfw-masthead",
      mobileHeaderEle: "#kinfw-mobile-header",
      openerEle: ".kinfw-mobile-navigation-trigger .kinfw-icon",
      subMenuOpenerEle: ".kinfw-sub-menu-trigger",
      menuEle: ".kinfw-mobile-menu-nav",
      backEle: ".kinfw-mobile-menu-back",
      closeEle: ".kinfw-mobile-menu-close",
      overlayEle: ".kinfw-mobile-menu-overlay",
      classes: {
        menuEle: "kinfw-mobile-menu-has-visibility"
      }
    }, options);
    this._init();
  }
  return _createClass(KFWMobileHeader, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $headerEle = _self$options.headerEle,
        $mobileHeaderEle = _self$options.mobileHeaderEle,
        $openerEle = _self$options.openerEle;
      if ($($mobileHeaderEle, $headerEle).length > 0) {
        _self._bindMobileMenuTrigger();
        _self._bindOverlayClick();
        _self._bindCloseClick();
        _self._bindBackClick();
        _self._bindMobileSubMenuTrigger();
      }
    }
  }, {
    key: "_bindMobileMenuTrigger",
    value: function _bindMobileMenuTrigger() {
      var _self = this;
      var _self$options2 = _self.options,
        $headerEle = _self$options2.headerEle,
        $openerEle = _self$options2.openerEle,
        $menuEle = _self$options2.menuEle,
        $menuEleToggleClass = _self$options2.classes.menuEle,
        $utils = _self$options2.utils;
      if ($($openerEle, $headerEle).length > 0) {
        $($openerEle).on("click", function ($e) {
          $e.preventDefault();
          $utils._toggleState($menuEle, $menuEleToggleClass);
        });
      }
    }
  }, {
    key: "_bindOverlayClick",
    value: function _bindOverlayClick() {
      var _self = this;
      var _self$options3 = _self.options,
        $mobileHeaderEle = _self$options3.mobileHeaderEle,
        $overlayEle = _self$options3.overlayEle,
        $menuEle = _self$options3.menuEle,
        $utils = _self$options3.utils,
        $menuEleToggleClass = _self$options3.classes.menuEle;
      if ($($overlayEle, $mobileHeaderEle).length > 0) {
        $($overlayEle).on("click", function ($e) {
          $e.preventDefault();
          $utils._toggleState($menuEle, $menuEleToggleClass);
          $utils._setState($($mobileHeaderEle).find("ul.sub-menu"), "sub-menu-hidden");
          $utils._removeState($($mobileHeaderEle).find("li.kinfw-sub-menu-active"), "kinfw-sub-menu-active");
        });
      }
    }
  }, {
    key: "_bindCloseClick",
    value: function _bindCloseClick() {
      var _self = this;
      var _self$options4 = _self.options,
        $mobileHeaderEle = _self$options4.mobileHeaderEle,
        $menuEle = _self$options4.menuEle,
        $closeEle = _self$options4.closeEle,
        $utils = _self$options4.utils,
        $menuEleToggleClass = _self$options4.classes.menuEle;
      if ($($closeEle, $mobileHeaderEle).length > 0) {
        $($closeEle).on("click", function ($e) {
          $e.preventDefault();
          $utils._toggleState($menuEle, $menuEleToggleClass);
          $utils._setState($($mobileHeaderEle).find("ul.sub-menu"), "sub-menu-hidden");
          $utils._removeState($($mobileHeaderEle).find("li.kinfw-sub-menu-active"), "kinfw-sub-menu-active");
        });
      }
    }
  }, {
    key: "_bindBackClick",
    value: function _bindBackClick() {
      var _self = this;
      var _self$options5 = _self.options,
        $mobileHeaderEle = _self$options5.mobileHeaderEle,
        $backEle = _self$options5.backEle,
        $utils = _self$options5.utils;
      if ($($backEle, $mobileHeaderEle).length > 0) {
        $($backEle).on("click", function ($e) {
          $e.preventDefault();
          $utils._setState($(this).parent("ul.sub-menu"), "sub-menu-hidden");
          $utils._removeState($(this).parent("ul.sub-menu").parent("li.menu-item-has-children"), "kinfw-sub-menu-active");
        });
      }
    }
  }, {
    key: "_bindMobileSubMenuTrigger",
    value: function _bindMobileSubMenuTrigger() {
      var _self = this;
      var _self$options6 = _self.options,
        $headerEle = _self$options6.headerEle,
        $subMenuOpenerEle = _self$options6.subMenuOpenerEle,
        $utils = _self$options6.utils;
      if ($($subMenuOpenerEle, $headerEle).length > 0) {
        $($subMenuOpenerEle).on("click", function ($e) {
          $e.preventDefault();
          $utils._removeState($(this).next("ul.sub-menu"), "sub-menu-hidden");
          $utils._setState($(this).parent("li.menu-item-has-children"), "kinfw-sub-menu-active");
        });
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/headers/sticky-header.js":
/*!****************************************************!*\
  !*** ./src/js/components/headers/sticky-header.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWStickyHeader)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWStickyHeader = /*#__PURE__*/function () {
  function KFWStickyHeader(options) {
    _classCallCheck(this, KFWStickyHeader);
    this.options = $.extend(true, {
      headerEle: "#kinfw-masthead",
      mainHeaderEle: "#kinfw-main-header",
      stickyHeaderEle: "#kinfw-sticky-header",
      stickyClass: "kinfw-header-sticky-on",
      scrollTopOffset: 300
    }, options);
    var $editor = this.options.elementorMode;
    if (!$editor) {
      this._init();
    }
  }
  return _createClass(KFWStickyHeader, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $utils = _self$options.utils,
        $headerEle = _self$options.headerEle,
        $scrollTopOffset = _self$options.scrollTopOffset;
      var $isMobile = $utils._isMobile();
      if (!$isMobile) {
        if ($($headerEle).length > 0) {
          $scrollTopOffset += $($headerEle).height();
          _self.options.scrollTopOffset = $scrollTopOffset;
        }
        _self._execute();
        _self._bindScroll();
      }
    }
  }, {
    key: "_execute",
    value: function _execute() {
      var _self = this;
      var $bodyEle = document.querySelector('body');
      var _self$options2 = _self.options,
        $windowEle = _self$options2.windowEle,
        $stickyClass = _self$options2.stickyClass,
        $headerEle = _self$options2.headerEle,
        $mainHeaderEle = _self$options2.mainHeaderEle,
        $stickyHeaderEle = _self$options2.stickyHeaderEle,
        $scrollTopOffset = _self$options2.scrollTopOffset,
        $utils = _self$options2.utils;
      var $ele = $($stickyHeaderEle, $headerEle),
        $mainHeaderElement = $($mainHeaderEle, $headerEle);
      if ($ele.length > 0) {
        var $scrollTop;
        if (typeof Scrollbar === 'function') {
          var $hasCustomScrollBar = Scrollbar.has($bodyEle);
          if ($hasCustomScrollBar) {
            var $bar = Scrollbar.get($bodyEle);
            $scrollTop = $bar.scrollTop;
            var $offSet = $bar.offset;
            $ele.css('top', $offSet.y);
            $ele.css('left', $offSet.x);
          }
        } else {
          $scrollTop = $windowEle.scrollTop();
        }
        if ($scrollTop > $scrollTopOffset) {
          $utils._setState($ele, $stickyClass);
        } else {
          $utils._removeState($ele, $stickyClass);
        }
      }
    }
  }, {
    key: "_bindScroll",
    value: function _bindScroll() {
      var _self = this;
      var $windowEle = _self.options.windowEle;
      $windowEle.on("scroll", function () {
        _self._execute();
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/headers/submenu-hover-effect.js":
/*!***********************************************************!*\
  !*** ./src/js/components/headers/submenu-hover-effect.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWSubMenuHoverEffect)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWSubMenuHoverEffect = /*#__PURE__*/function () {
  function KFWSubMenuHoverEffect(options) {
    _classCallCheck(this, KFWSubMenuHoverEffect);
    this.options = $.extend(true, {
      screenWidth: $(window).width(),
      mainHeaderEle: "#kinfw-main-header",
      stickyHeaderEle: "#kinfw-sticky-header",
      triggerClass: ".menu-item-has-children",
      megaMenuClass: "menu-item-has-kinfw-mega-menu",
      subMenuClass: ".sub-menu"
    }, options);
    this._init();
  }
  return _createClass(KFWSubMenuHoverEffect, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $mainHeaderEle = _self$options.mainHeaderEle,
        $stickyHeaderEle = _self$options.stickyHeaderEle;
      var $mainNav = $(".kinfw-main-nav > ul", $mainHeaderEle);
      var $stickyNav = $(".kinfw-main-nav > ul", $stickyHeaderEle);
      _self._bindHover($mainNav);
      _self._bindHover($stickyNav);
    }
  }, {
    key: "_bindHover",
    value: function _bindHover($nav) {
      var _self = this;
      var _self$options2 = _self.options,
        $screenWidth = _self$options2.screenWidth,
        $triggerClass = _self$options2.triggerClass,
        $megaMenuClass = _self$options2.megaMenuClass,
        $subMenuClass = _self$options2.subMenuClass,
        $utils = _self$options2.utils;
      $($triggerClass, $nav).hover(function (event) {
        var $item = $(event.currentTarget);
        var $isMegaMenu = $utils._hasState($item, $megaMenuClass);
        if ($isMegaMenu) {
          return;
        }
        var $sub = $item.children($subMenuClass),
          $offset = $item.offset(),
          $width = $item.outerWidth(),
          $subWidth = $sub.outerWidth();
        var $val = $offset.left + $width + $subWidth - $screenWidth;
        if ($val > 0) {
          if ($item.parents($triggerClass).length) {
            $sub.css({
              left: 'auto',
              right: '100%'
            });
          } else {
            $sub.css({
              left: 'auto',
              right: '0'
            });
          }
        } else {
          $sub.css({
            left: '',
            right: ''
          });
        }
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/image-gallery.js":
/*!********************************************!*\
  !*** ./src/js/components/image-gallery.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWImageGallery)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWImageGallery = /*#__PURE__*/function () {
  function KFWImageGallery(options) {
    _classCallCheck(this, KFWImageGallery);
    this.options = $.extend(true, {
      selector: ".kinfw-light-box-gallery",
      settings: {
        closeOnContentClick: true,
        closeOnBgClick: true,
        closeBtnInside: true,
        showCloseBtn: true,
        enableEscapeKey: true
      }
    }, options);
    this._init();
  }
  return _createClass(KFWImageGallery, [{
    key: "_init",
    value: function _init() {
      if (typeof $.fn.magnificPopup !== 'function') {
        return;
      }
      var _self = this;
      var _self$options = _self.options,
        $selector = _self$options.selector,
        $settings = _self$options.settings,
        $utils = _self$options.utils;
      var $closeOnContentClick = $utils._isBool($settings.closeOnContentClick);
      var $closeOnBgClick = $utils._isBool($settings.closeOnBgClick);
      var $closeBtnInside = $utils._isBool($settings.closeBtnInside);
      var $showCloseBtn = $utils._isBool($settings.showCloseBtn);
      var $enableEscapeKey = $utils._isBool($settings.enableEscapeKey);
      var $ele = $($selector);
      $ele.length > 0 && $ele.each(function () {
        var $this = $(this);
        $this.magnificPopup({
          delegate: 'a[data-lightbox="kinfw-gallery-item"]',
          type: 'image',
          closeOnContentClick: $closeOnContentClick,
          closeOnBgClick: $closeOnBgClick,
          closeBtnInside: $closeBtnInside,
          showCloseBtn: $showCloseBtn,
          enableEscapeKey: $enableEscapeKey,
          image: {
            verticalFit: true
          },
          gallery: {
            enabled: true,
            'tPrev': '',
            'tNext': ''
          },
          zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
          }
        });
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/pre-loader.js":
/*!*****************************************!*\
  !*** ./src/js/components/pre-loader.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWPreLoader)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWPreLoader = /*#__PURE__*/function () {
  function KFWPreLoader(options) {
    _classCallCheck(this, KFWPreLoader);
    this.options = $.extend(true, {
      loaderEle: "#kinfw-pre-loader"
    }, options);
    this._init();
  }
  return _createClass(KFWPreLoader, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $utils = _self$options.utils;
      var $hasModule = $utils._isBool($utils._hasState($bodyEle, 'kinfw-has-site-loader')),
        $elementorEditor = _self.options.elementorMode;
      if ($hasModule) {
        _self._execute();
      }
    }
  }, {
    key: "_execute",
    value: function _execute() {
      var _self = this;
      var _self$options2 = _self.options,
        $bodyEle = _self$options2.bodyEle,
        $loaderEle = _self$options2.loaderEle;
      var $ele = $($loaderEle, $bodyEle);
      if ($ele.length > 0 && !$ele.hasClass("kinfw-loaded")) {
        setTimeout(function () {
          $ele.addClass("kinfw-loaded");
          $($bodyEle).trigger("kinfw-loaded", [$bodyEle, $ele]);
        }, kinfw_onnat_L10n.loaderTimeOut);
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/ripple-button.js":
/*!********************************************!*\
  !*** ./src/js/components/ripple-button.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWRippleBtn)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWRippleBtn = /*#__PURE__*/function () {
  function KFWRippleBtn(options) {
    _classCallCheck(this, KFWRippleBtn);
    this.options = $.extend(true, {
      rippleBtnEle: ".kinfw-ripple-button",
      rippleBtnHoverEle: ".kinfw-ripple-button-hover"
    }, options);
    this._execute();
  }
  return _createClass(KFWRippleBtn, [{
    key: "_execute",
    value: function _execute() {
      var _self = this;
      $(_self.options.rippleBtnEle).each(function () {
        var $btn = $(this),
          $hoverEle = $btn.find(_self.options.rippleBtnHoverEle);
        $btn.mouseenter(function ($e) {
          var $offset = $(this).offset(),
            $relX = $e.pageX - $offset.left,
            $relY = $e.pageY - $offset.top;
          $hoverEle.css({
            "left": $relX,
            "top": $relY
          });
        });
        $btn.mouseleave(function ($e) {
          var $offset = $(this).offset(),
            $relX = $e.pageX - $offset.left,
            $relY = $e.pageY - $offset.top;
          $hoverEle.css({
            "left": $relX,
            "top": $relY
          });
        });
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/scroll-bar.js":
/*!*****************************************!*\
  !*** ./src/js/components/scroll-bar.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWScrollBar)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWScrollBar = /*#__PURE__*/function () {
  function KFWScrollBar(options) {
    _classCallCheck(this, KFWScrollBar);
    this.options = $.extend(true, {
      damping: 0.1,
      continuousScrolling: true,
      renderByPixels: true,
      alwaysShowTracks: false
    }, options);
    this._init();
  }
  return _createClass(KFWScrollBar, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $utils = _self$options.utils;
      var $isMobile = $utils._isMobile(),
        $hasModule = $utils._isBool($utils._hasState($bodyEle, 'kinfw-has-site-scroll-bar'));
      if (!$isMobile && $hasModule && typeof Scrollbar === 'function') {
        _self._execute();
      }
    }
  }, {
    key: "_execute",
    value: function _execute() {
      var _self = this;
      var _self$options2 = _self.options,
        $windowEle = _self$options2.windowEle,
        $utils = _self$options2.utils;
      _self.options.alwaysShowTracks = kinfw_onnat_L10n.hasOwnProperty('scrollBarAutoHide') ? $utils._isBool(kinfw_onnat_L10n.scrollBarAutoHide) : _self.options.alwaysShowTracks;
      _self.scrollBar = Scrollbar.init(document.querySelector('body'), {
        damping: _self.options.damping,
        continuousScrolling: _self.options.continuousScrolling,
        renderByPixels: _self.options.renderByPixels,
        alwaysShowTracks: _self.options.alwaysShowTracks
      });
      _self.scrollBar.setPosition(0, 0);
      _self.scrollBar.track.xAxis.element.remove();
      _self.scrollBar.addListener(function ($e) {
        $windowEle.trigger("scroll");
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/single-blog-post.js":
/*!***********************************************!*\
  !*** ./src/js/components/single-blog-post.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWSingleBlogPost)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWSingleBlogPost = /*#__PURE__*/function () {
  function KFWSingleBlogPost(options) {
    _classCallCheck(this, KFWSingleBlogPost);
    this.options = $.extend(true, {
      socialShare: ".kinfw-entry-post-social-share",
      oembedAudioPost: ".kinfw-audio-iframe",
      galleryPost: {
        container: ".kinfw-entry-gallery-slider",
        mainClass: 'kinfw-js-swipper-',
        navClass: 'kinfw-js-swipper-nav-'
      }
    }, options);
    this._init();
    this._windowResize();
  }
  return _createClass(KFWSingleBlogPost, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $utils = _self$options.utils;

      /**
       * Single Post Social Share
       */
      var $enableSocialShareModule = $utils._isBool($utils._hasState($bodyEle, 'single-post'));
      if ($enableSocialShareModule) {
        _self._socialShare();
      }

      /**
       * Post Format: Audio
       * OEmbed iFrame
       */
      _self._oembedAudioPost();

      /**
       * Post Format: Gallery
       * swipper integration
       */
      _self._oembedGalleryPost();
    }
  }, {
    key: "_socialShare",
    value: function _socialShare() {
      var _self = this;
      var _self$options2 = _self.options,
        $bodyEle = _self$options2.bodyEle,
        $socialShare = _self$options2.socialShare;
      var $ele = $($socialShare, $bodyEle);
      if ($ele.length > 0) {
        var $a = $('a', $ele);
        if ($a.length > 0) {
          $a.on("click", function ($e) {
            $e.preventDefault();
            _self._bindSocialShareClick($e.currentTarget);
          });
        }
      }
    }
  }, {
    key: "_bindSocialShareClick",
    value: function _bindSocialShareClick($ele) {
      var $windowWidth = '640',
        $windowHeight = '480',
        $windowTop = screen.height / 2 - $windowHeight / 2,
        $windowLeft = screen.width / 2 - $windowWidth / 2;
      open($($ele).attr("href"), '', 'toolbar=0,status=0,width=' + $windowWidth + ',height=' + $windowHeight + ',top=' + $windowTop + ',left=' + $windowLeft);
    }
  }, {
    key: "_oembedAudioPost",
    value: function _oembedAudioPost() {
      var _self = this;
      var _self$options3 = _self.options,
        $bodyEle = _self$options3.bodyEle,
        $oembedAudioPost = _self$options3.oembedAudioPost;
      var $ele = $($oembedAudioPost, $bodyEle);
      if ($ele.length > 0) {
        $ele.each(function ($idx, $item) {
          var $frame = $($item),
            $width = $frame.attr('width'),
            $height = $frame.attr('height'),
            $newHeight = $frame.width() / $width * $height;
          $frame.css('height', $newHeight);
        });
      }
    }
  }, {
    key: "_oembedGalleryPost",
    value: function _oembedGalleryPost() {
      if (typeof Swiper !== 'function') {
        return;
      }
      var _self = this;
      var _self$options4 = _self.options,
        $bodyEle = _self$options4.bodyEle,
        _self$options4$galler = _self$options4.galleryPost,
        container = _self$options4$galler.container,
        mainClass = _self$options4$galler.mainClass,
        navClass = _self$options4$galler.navClass,
        $utils = _self$options4.utils;
      var $ele = $(container, $bodyEle);
      if ($ele.length > 0) {
        $ele.each(function ($idx) {
          var $container = $(this),
            $nav = $(".kinfw-swiper-nav", $container),
            $prev = $("a.kinfw-swiper-nav-prev", $nav),
            $next = $("a.kinfw-swiper-nav-next", $nav);
          var $containerClass = mainClass.concat($idx),
            $prevClass = navClass.concat($idx).concat('-prev'),
            $nextClass = navClass.concat($idx).concat('-next');
          $utils._setState($container, $containerClass);
          $utils._setState($prev, $prevClass);
          $utils._setState($next, $nextClass);
          new Swiper("." + $containerClass, {
            autoHeight: true,
            navigation: {
              prevEl: "." + $prevClass,
              nextEl: "." + $nextClass
            }
          });
        });
      }
    }
  }, {
    key: "_windowResize",
    value: function _windowResize() {
      var _self = this;
      var $windowEle = _self.options.windowEle;
      $windowEle.on("resize", function () {
        _self._oembedAudioPost();
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/svg-convert.js":
/*!******************************************!*\
  !*** ./src/js/components/svg-convert.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWSVGConvert)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWSVGConvert = /*#__PURE__*/function () {
  function KFWSVGConvert(options) {
    _classCallCheck(this, KFWSVGConvert);
    this.options = $.extend(true, {
      svgEle: ".kinfw-switch-svg",
      afterSvgEleClass: "kinfw-switched-svg"
    }, options);
    this._init();
  }
  return _createClass(KFWSVGConvert, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $svgEle = _self$options.svgEle;
      var $ele = $($svgEle, $bodyEle);
      if ($ele.length > 0) {
        _self.options.svgEleClass = $svgEle.replace(".", "");
        _self._execute($ele);
      }
    }
  }, {
    key: "_execute",
    value: function _execute($ele) {
      var _self = this;
      var $svgEleClass = _self.options.svgEleClass,
        $afterSvgEleClass = _self.options.afterSvgEleClass;
      $ele.each(function () {
        var $imgTag = $(this),
          $id = $imgTag.attr("id"),
          $class = $imgTag.attr('class'),
          $src = $imgTag.attr("src");
        $.get($src, function ($data) {
          // Get the SVG tag, ignore the rest
          var $svg = $($data).find('svg');

          // Add replaced image's ID to the new SVG
          if (typeof $id !== 'undefined') {
            $svg = $svg.attr('id', $id);
          }

          // Add replaced image's ID to the new SVG
          if (typeof $class !== 'undefined') {
            var $classes = $class.replace($svgEleClass, " ").concat($afterSvgEleClass);
            $svg = $svg.attr('class', $classes);
          }

          // Remove any invalid XML tags as per http://validator.w3.org
          $svg = $svg.removeAttr('xmlns:a');

          // Check if the viewport is set, else we gonna set it if we can.
          if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
            $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'));
          }

          // Replace image with new SVG
          $imgTag.replaceWith($svg);
        });
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/added-to-cart-button.js":
/*!*******************************************************!*\
  !*** ./src/js/components/woo/added-to-cart-button.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooAddedToCartButtons)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooAddedToCartButtons = /*#__PURE__*/function () {
  function KFWWooAddedToCartButtons(options) {
    _classCallCheck(this, KFWWooAddedToCartButtons);
    this.options = $.extend(true, {}, options);
    this._init();
  }
  return _createClass(KFWWooAddedToCartButtons, [{
    key: "_init",
    value: function _init() {
      $(document).on('wc_cart_button_updated', function ($event, $button) {
        $button.next('.added_to_cart').html('<i class="kinfw-icon kinfw-icon-tick-circle"></i>');
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/empty-cart.js":
/*!*********************************************!*\
  !*** ./src/js/components/woo/empty-cart.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooEmptyCart)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooEmptyCart = /*#__PURE__*/function () {
  function KFWWooEmptyCart(options) {
    _classCallCheck(this, KFWWooEmptyCart);
    this.options = $.extend(true, {
      btn: '.kinfw-woo-empty-cart-button'
    }, options);
    this._init();
  }
  return _createClass(KFWWooEmptyCart, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var $btn = _self.options.btn;
      if ($($btn).length > 0) {
        $($btn).on('click', function () {
          if (confirm(kinfw_onnat_L10n.empty_cart)) {
            return true;
          }
          return false;
        });
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/header/elements/mini-cart.js":
/*!************************************************************!*\
  !*** ./src/js/components/woo/header/elements/mini-cart.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWHeaderElementMiniCart)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWHeaderElementMiniCart = /*#__PURE__*/function () {
  function KFWHeaderElementMiniCart(options) {
    _classCallCheck(this, KFWHeaderElementMiniCart);
    this.options = $.extend(true, {
      trigger: $(".kinfw-header-mini-cart-trigger"),
      modal: $("#kinfw-header-mini-cart-modal")
    }, options);
    this._init();
  }
  return _createClass(KFWHeaderElementMiniCart, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $trigger = _self$options.trigger,
        $modal = _self$options.modal;
      if ($trigger.length > 0 && $modal.length > 0) {
        var $modalOverlay = $modal.find(".kinfw-header-mini-cart-modal-overlay"),
          $modalClose = $modal.find(".kinfw-header-mini-cart-close");

        /**
         * Show Modal
         */
        $trigger.on("click", function (e) {
          e.preventDefault();
          _self._show($modal);
        });

        /**
         * Close Modal
         */
        $modalClose.on("click", function (e) {
          e.preventDefault();
          _self._hide($modal);
        });
        $modalOverlay.on("click", function (e) {
          e.preventDefault();
          _self._hide($modal);
        });
        $(window).on('keyup', function (e) {
          if (e.keyCode === 27) {
            _self._hide($modal);
          }
        });
      }
    }
  }, {
    key: "_show",
    value: function _show($modal) {
      var _self = this;
      var $utils = _self.options.utils;
      var $show = $utils._hasState($modal, "kinfw-header-mini-cart-modal-show");
      if (!$show) {
        $utils._setState($modal, "kinfw-header-mini-cart-modal-show");
      }
    }
  }, {
    key: "_hide",
    value: function _hide($modal) {
      var _self = this;
      var $utils = _self.options.utils;
      var $show = $utils._hasState($modal, "kinfw-header-mini-cart-modal-show");
      if ($show) {
        $utils._removeState($modal, "kinfw-header-mini-cart-modal-show");
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/login-form.js":
/*!*********************************************!*\
  !*** ./src/js/components/woo/login-form.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooLoginFormPage)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooLoginFormPage = /*#__PURE__*/function () {
  function KFWWooLoginFormPage(options) {
    _classCallCheck(this, KFWWooLoginFormPage);
    this.options = $.extend(true, {
      wrap: "#kinfw-woo-form-login-wrap"
    }, options);
    this._init();
    this._bindClick();
    this._eachFields();
    this._fieldKeyup();
  }
  return _createClass(KFWWooLoginFormPage, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var $utils = _self.options.utils;
      var $wrap = _self.options.wrap;
      if ($($wrap).length > 0) {
        $($wrap).tabs({
          activate: function activate($event, $ui) {
            if ($ui.newTab.attr("id") == "kinfw-woo-login-form-nav") {
              $utils._setCookie('kinfw-active-myaccount-tab', 'kinfw-woo-login-form-wrap');
            } else {
              $utils._setCookie('kinfw-active-myaccount-tab', 'kinfw-woo-register-form-wrap');
            }
            $(".woocommerce-message, .woocommerce-info, .woocommerce-error, .woocommerce-notice").addClass('kinfw-hide-woo-notice');
          }
        });
        var $activeTab = $utils._getCookie('kinfw-active-myaccount-tab');
        if ('kinfw-woo-login-form-wrap' === $activeTab) {
          $($wrap).tabs("option", "active", 0);
        } else if ('kinfw-woo-register-form-wrap' === $activeTab) {
          $($wrap).tabs("option", "active", 1);
        } else {
          $utils._setCookie('kinfw-active-myaccount-tab', 'kinfw-woo-login-form-wrap');
        }
      }
    }
  }, {
    key: "_bindClick",
    value: function _bindClick() {
      var _self = this;
      var $wrap = _self.options.wrap;
      if ($($wrap).length > 0) {
        $($wrap).find('.kinfw-field-placeholder').on('click', function () {
          $(this).closest(".kinfw-field-wrapper").find("input").focus();
        });
      }
    }
  }, {
    key: "_eachFields",
    value: function _eachFields() {
      var _self = this;
      var $wrap = _self.options.wrap;
      $($wrap).find('.kinfw-field-wrapper input').each(function () {
        var $value = $.trim($(this).val());
        if ($value) {
          $(this).closest(".kinfw-field-wrapper").addClass("kinfw-field-has-value");
        } else {
          $(this).closest(".kinfw-field-wrapper").removeClass("kinfw-field-has-value");
        }
      });
    }
  }, {
    key: "_fieldKeyup",
    value: function _fieldKeyup() {
      var _self = this;
      var $wrap = _self.options.wrap;
      $($wrap).find('.kinfw-field-wrapper input').on("keyup", function () {
        var $value = $.trim($(this).val());
        if ($value) {
          $(this).closest(".kinfw-field-wrapper").addClass("kinfw-field-has-value");
        } else {
          $(this).closest(".kinfw-field-wrapper").removeClass("kinfw-field-has-value");
        }
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/messages.js":
/*!*******************************************!*\
  !*** ./src/js/components/woo/messages.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooMessages)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooMessages = /*#__PURE__*/function () {
  function KFWWooMessages(options) {
    _classCallCheck(this, KFWWooMessages);
    this.options = $.extend(true, {}, options);
    this._init();
  }
  return _createClass(KFWWooMessages, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var $bodyEle = document.querySelector('body');
      $($bodyEle).on("click", ".woocommerce-message, .woocommerce-info, .woocommerce-error, .woocommerce-notice", function () {
        $(this).addClass('kinfw-hide-woo-notice');
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/my-account-page.js":
/*!**************************************************!*\
  !*** ./src/js/components/woo/my-account-page.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooMyAccountPage)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooMyAccountPage = /*#__PURE__*/function () {
  function KFWWooMyAccountPage(options) {
    _classCallCheck(this, KFWWooMyAccountPage);
    this.options = $.extend(true, {}, options);
    this._bindClick();
    this._eachFields();
    this._fieldKeyup();
  }
  return _createClass(KFWWooMyAccountPage, [{
    key: "_bindClick",
    value: function _bindClick() {
      $('.kinfw-field-wrapper .kinfw-field-placeholder').on('click', function () {
        $(this).closest(".kinfw-field-wrapper").find("input").focus();
      });
    }
  }, {
    key: "_eachFields",
    value: function _eachFields() {
      $('.kinfw-field-wrapper input').each(function () {
        var $value = $.trim($(this).val());
        if ($value) {
          $(this).closest(".kinfw-field-wrapper").addClass("kinfw-field-has-value");
        } else {
          $(this).closest(".kinfw-field-wrapper").removeClass("kinfw-field-has-value");
        }
      });
    }
  }, {
    key: "_fieldKeyup",
    value: function _fieldKeyup() {
      $('.kinfw-field-wrapper input').on("keyup", function () {
        var $value = $.trim($(this).val());
        if ($value) {
          $(this).closest(".kinfw-field-wrapper").addClass("kinfw-field-has-value");
        } else {
          $(this).closest(".kinfw-field-wrapper").removeClass("kinfw-field-has-value");
        }
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/qty-buttons.js":
/*!**********************************************!*\
  !*** ./src/js/components/woo/qty-buttons.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooQtyButtons)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooQtyButtons = /*#__PURE__*/function () {
  function KFWWooQtyButtons(options) {
    _classCallCheck(this, KFWWooQtyButtons);
    this.options = $.extend(true, {
      plus: '.kinfw-qty-wrap .kinfw-qty-plus',
      minus: '.kinfw-qty-wrap .kinfw-qty-minus'
    }, options);
    this._init();
  }
  return _createClass(KFWWooQtyButtons, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      _self._increment();
      _self._decrement();
    }
  }, {
    key: "_increment",
    value: function _increment() {
      var _self = this;
      var _self$options = _self.options,
        $bodyEle = _self$options.bodyEle,
        $plus = _self$options.plus;
      $($bodyEle).on("click", $plus, function (e) {
        e.preventDefault();
        this.parentNode.querySelector('input[type=number]').stepUp();
        _self._updateCartFormCartBtn();
      });
    }
  }, {
    key: "_decrement",
    value: function _decrement() {
      var _self = this;
      var _self$options2 = _self.options,
        $bodyEle = _self$options2.bodyEle,
        $minus = _self$options2.minus;
      $($bodyEle).on("click", $minus, function (e) {
        e.preventDefault();
        this.parentNode.querySelector('input[type=number]').stepDown();
        _self._updateCartFormCartBtn();
      });
    }
  }, {
    key: "_updateCartFormCartBtn",
    value: function _updateCartFormCartBtn() {
      if (document.querySelector('.woocommerce-cart-form [name=update_cart]')) {
        document.querySelector('.woocommerce-cart-form [name=update_cart]').disabled = false;
        document.querySelector('.woocommerce-cart-form [name=update_cart]').setAttribute("aria-disabled", "false");
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/sale-price-date.js":
/*!**************************************************!*\
  !*** ./src/js/components/woo/sale-price-date.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooSalePriceDate)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooSalePriceDate = /*#__PURE__*/function () {
  function KFWWooSalePriceDate(options) {
    _classCallCheck(this, KFWWooSalePriceDate);
    this.options = $.extend(true, {
      selector: ".kinfw-product-sale-price-date.kinfw-countdown-timer",
      settings: {
        day: ".kinfw-countdown-timer-days-item",
        hrs: ".kinfw-countdown-timer-hours-item",
        mins: ".kinfw-countdown-timer-minutes-item",
        sec: ".kinfw-countdown-timer-seconds-item"
      }
    }, options);
    this._init();
  }
  return _createClass(KFWWooSalePriceDate, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var $selector = _self.options.selector;
      var $ele = $($selector);
      $ele.length > 0 && $ele.each(function () {
        var $this = $(this),
          $date = $this.data("date");
        $date = new Date($date * 1000);
        _self._startTimer($this, $date);
      });
    }
  }, {
    key: "_startTimer",
    value: function _startTimer($ele, $date) {
      var _self = this;
      var $timer = _self._getTimeRemaining($date);
      _self._updateTimer($ele, $timer);
      setInterval(function () {
        var $timer = _self._getTimeRemaining($date);
        _self._updateTimer($ele, $timer);
      }, 1000);
    }
  }, {
    key: "_getTimeRemaining",
    value: function _getTimeRemaining($targetDate) {
      var _self = this;
      var total = Date.parse($targetDate) - Date.parse(new Date());
      var days = Math.floor(total / (1000 * 60 * 60 * 24)).toString();
      var hours = Math.floor(total / (1000 * 60 * 60) % 24).toString();
      var mins = Math.floor(total / 1000 / 60 % 60).toString();
      var secs = Math.floor(total / 1000 % 60).toString();
      return {
        days: days,
        hours: hours,
        mins: mins,
        secs: secs
      };
    }
  }, {
    key: "_updateTimer",
    value: function _updateTimer($ele, _ref) {
      var days = _ref.days,
        hours = _ref.hours,
        mins = _ref.mins,
        secs = _ref.secs;
      var _self = this;
      var $settings = _self.options.settings;
      var $dayEle = $ele.find($settings.day).find(".kinfw-countdown-digits");
      var $hrEle = $ele.find($settings.hrs).find(".kinfw-countdown-digits");
      var $minsEle = $ele.find($settings.mins).find(".kinfw-countdown-digits");
      var $secEle = $ele.find($settings.sec).find(".kinfw-countdown-digits");
      if ($dayEle.length) {
        days = 1 === days.length ? 0 + days : days;
        $dayEle.text(days);
      }
      if ($hrEle.length) {
        hours = 1 === hours.length ? 0 + hours : hours;
        $hrEle.text(hours);
      }
      if ($minsEle.length) {
        mins = 1 === mins.length ? 0 + mins : mins;
        $minsEle.text(mins);
      }
      if ($secEle.length) {
        secs = 1 === secs.length ? 0 + secs : secs;
        $secEle.text(secs);
      }
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/select2.js":
/*!******************************************!*\
  !*** ./src/js/components/woo/select2.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooSelect2)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooSelect2 = /*#__PURE__*/function () {
  function KFWWooSelect2(options) {
    _classCallCheck(this, KFWWooSelect2);
    this.options = $.extend(true, {}, options);
    this._init();
  }
  return _createClass(KFWWooSelect2, [{
    key: "_init",
    value: function _init() {
      if (typeof $.fn.select2 !== 'function') {
        return;
      }
      $('.woocommerce-ordering select').select2({
        minimumResultsForSearch: Infinity
      });
      $('.variations select').select2({
        minimumResultsForSearch: Infinity,
        selectionCssClass: "kf-woo-variation-select" // To provide compatibility for kinForce WooCommerce Swatch Plugin
      });

      /**
       * YITH Quick View Popup
       */
      $(document).on('qv_loader_stop', function () {
        $('.variations select').select2({
          minimumResultsForSearch: Infinity
        });
      });
      $('#calc_shipping_country').select2({});
      $('.shipping select#calc_shipping_state').select2({});
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/woo/tooltipsters.js":
/*!***********************************************!*\
  !*** ./src/js/components/woo/tooltipsters.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWooTooltipsters)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWooTooltipsters = /*#__PURE__*/function () {
  function KFWWooTooltipsters(options) {
    _classCallCheck(this, KFWWooTooltipsters);
    this.options = $.extend(true, {
      selectors: [{
        selector: ".kinfw-woo-product-action-buttons-wrap .yith-wcwl-add-to-wishlist > div > a:not(.tooltipstered)",
        position: "left",
        attribute: "data-title"
      },
      /*
      {
          selector : ".kinfw-woo-product-action-buttons-wrap a.kinfw-product-add-to-cart.kinfw-product-simple:not(.tooltipstered)",
          position : "left",
          attribute: "data-title"
      },
      */
      {
        selector: ".kinfw-woo-product-action-buttons-wrap a.kinfw-product-add-to-cart.kinfw-product-grouped:not(.tooltipstered)",
        position: "left",
        attribute: "data-title"
      }, {
        selector: ".kinfw-woo-product-action-buttons-wrap a.kinfw-product-add-to-cart.kinfw-product-external:not(.tooltipstered)",
        position: "left",
        attribute: "data-title"
      }, {
        selector: ".kinfw-woo-product-action-buttons-wrap a.kinfw-product-add-to-cart.kinfw-product-variable:not(.tooltipstered)",
        position: "left",
        attribute: "data-title"
      }, {
        selector: ".kinfw-woo-product-action-buttons-wrap a.kinfw-product-quick-view:not(.tooltipstered)",
        position: "left",
        attribute: "data-title"
      }, {
        selector: ".kinfw-woo-product-action-buttons-wrap a.added_to_cart.wc-forward:not(.tooltipstered)",
        position: "left",
        attribute: "title"
      }]
    }, options);
    this._init();
  }
  return _createClass(KFWWooTooltipsters, [{
    key: "_init",
    value: function _init() {
      if (typeof $.fn.tooltipster !== 'function') {
        return;
      }
      var _self = this;
      var $bodyEle = document.querySelector('body');
      var $selectors = _self.options.selectors;
      $.each($selectors, function ($index, $obj) {
        $($bodyEle).on("mouseover", $obj.selector, function () {
          $(this).tooltipster({
            position: $obj.position,
            theme: 'tooltipster-borderless',
            delay: 100,
            functionBefore: function functionBefore($instance, $helper) {
              $instance.content($instance._$origin.attr($obj.attribute));
            }
          }).tooltipster("show");
        });
      });
    }
  }]);
}();


/***/ }),

/***/ "./src/js/components/wp-widgets.js":
/*!*****************************************!*\
  !*** ./src/js/components/wp-widgets.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWWPDefaultWidgets)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWWPDefaultWidgets = /*#__PURE__*/function () {
  function KFWWPDefaultWidgets(options) {
    _classCallCheck(this, KFWWPDefaultWidgets);
    this.options = $.extend(true, {}, options);
    this._init();
  }
  return _createClass(KFWWPDefaultWidgets, [{
    key: "_init",
    value: function _init() {
      this._dropdown();
    }

    /**
     * Add select2 for dropdown in default WordPress widgets
     */
  }, {
    key: "_dropdown",
    value: function _dropdown() {
      if (typeof $.fn.select2 !== 'function') {
        return;
      }

      /** Archive Widget */
      $('.widget.widget_archive select').select2({});

      /** Category Widget */
      $('.widget.widget_categories select').select2({});

      /** Text Widget */
      $('.widget.widget_text select').select2({});
    }
  }]);
}();


/***/ }),

/***/ "./src/js/utils.js":
/*!*************************!*\
  !*** ./src/js/utils.js ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ KFWUtils)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var KFWUtils = /*#__PURE__*/function () {
  function KFWUtils(options) {
    _classCallCheck(this, KFWUtils);
    this.options = $.extend(true, {}, options);
  }
  return _createClass(KFWUtils, [{
    key: "_console",
    value: function _console($arg) {
      console.log($arg);
    }
  }, {
    key: "_isMobile",
    value: function _isMobile() {
      var _self = this;
      return _self._isAndroid() || _self._isBlackBerry() || _self._isiOS() || _self._isOpera() || _self._isWindows();
    }
  }, {
    key: "_isAndroid",
    value: function _isAndroid() {
      return navigator.userAgent.match(/Android/i);
    }
  }, {
    key: "_isBlackBerry",
    value: function _isBlackBerry() {
      return navigator.userAgent.match(/BlackBerry/i);
    }
  }, {
    key: "_isiOS",
    value: function _isiOS() {
      return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    }
  }, {
    key: "_isOpera",
    value: function _isOpera() {
      return navigator.userAgent.match(/Opera Mini/i);
    }
  }, {
    key: "_isWindows",
    value: function _isWindows() {
      return navigator.userAgent.match(/IEMobile|Windows Phone/i);
    }
  }, {
    key: "_isBool",
    value: function _isBool($arg) {
      switch ($arg) {
        case true:
        case "true":
        case "TRUE":
        case 1:
        case "1":
        case "on":
        case "ON":
        case "yes":
        case "YES":
          return true;
        default:
          return false;
      }
    }
  }, {
    key: "_setState",
    value: function _setState($ele, $state) {
      $($ele).addClass($state);
    }
  }, {
    key: "_removeState",
    value: function _removeState($ele, $state) {
      $($ele).removeClass($state);
    }
  }, {
    key: "_hasState",
    value: function _hasState($ele, $state) {
      return $($ele).hasClass($state);
    }
  }, {
    key: "_toggleState",
    value: function _toggleState($ele, $state) {
      $($ele).toggleClass($state);
    }
  }, {
    key: "_scrollToHash",
    value: function _scrollToHash() {
      var target = document.querySelector(window.location.hash);
      if (target) {
        target.scrollIntoView({
          behavior: "smooth"
        });
      }
    }
  }, {
    key: "_setCookie",
    value: function _setCookie($name, $value, $days) {
      var $secureFlag = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
      var $sameSiteFlag = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : 'None';
      return function ($days) {
        var $expires = "";
        var $days = $days ? $days : 7;
        if ($days) {
          var date = new Date();
          date.setTime(date.getTime() + $days * 24 * 60 * 60 * 1000);
          $expires = "; expires=" + date.toUTCString();
        }

        // Add Secure attribute if the secureFlag is true
        var $secureAttribute = $secureFlag ? '; Secure' : '';

        // Add SameSite attribute
        var $sameSiteAttribute = "; SameSite=".concat($sameSiteFlag);
        document.cookie = $name + "=" + $value + $expires + "; path=/" + $secureAttribute + $sameSiteAttribute;
      }($days);
    }
  }, {
    key: "_getCookie",
    value: function _getCookie($name) {
      var nameEQ = $name + "=";
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        while (cookie.charAt(0) == ' ') {
          cookie = cookie.substring(1, cookie.length);
        }
        if (cookie.indexOf(nameEQ) == 0) {
          return cookie.substring(nameEQ.length, cookie.length);
        }
      }
      return null;
    }
  }]);
}();


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
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!****************************!*\
  !*** ./src/js/function.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./src/js/utils.js");
/* harmony import */ var _components_body_scroll_smoother__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/body-scroll-smoother */ "./src/js/components/body-scroll-smoother.js");
/* harmony import */ var _components_address_bar__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/address-bar */ "./src/js/components/address-bar.js");
/* harmony import */ var _components_anchor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/anchor */ "./src/js/components/anchor.js");
/* harmony import */ var _components_svg_convert__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/svg-convert */ "./src/js/components/svg-convert.js");
/* harmony import */ var _components_cursor__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/cursor */ "./src/js/components/cursor.js");
/* harmony import */ var _components_pre_loader__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/pre-loader */ "./src/js/components/pre-loader.js");
/* harmony import */ var _components_scroll_bar__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/scroll-bar */ "./src/js/components/scroll-bar.js");
/* harmony import */ var _components_headers_sticky_header__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./components/headers/sticky-header */ "./src/js/components/headers/sticky-header.js");
/* harmony import */ var _components_headers_mobile_header__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./components/headers/mobile-header */ "./src/js/components/headers/mobile-header.js");
/* harmony import */ var _components_headers_submenu_hover_effect__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./components/headers/submenu-hover-effect */ "./src/js/components/headers/submenu-hover-effect.js");
/* harmony import */ var _components_headers_elements_search__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./components/headers/elements/search */ "./src/js/components/headers/elements/search.js");
/* harmony import */ var _components_headers_elements_user_login__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./components/headers/elements/user-login */ "./src/js/components/headers/elements/user-login.js");
/* harmony import */ var _components_go_to_top__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./components/go-to-top */ "./src/js/components/go-to-top.js");
/* harmony import */ var _components_single_blog_post__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./components/single-blog-post */ "./src/js/components/single-blog-post.js");
/* harmony import */ var _components_ripple_button__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ./components/ripple-button */ "./src/js/components/ripple-button.js");
/* harmony import */ var _components_fitvids__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! ./components/fitvids */ "./src/js/components/fitvids.js");
/* harmony import */ var _components_image_gallery__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! ./components/image-gallery */ "./src/js/components/image-gallery.js");
/* harmony import */ var _components_wp_widgets__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! ./components/wp-widgets */ "./src/js/components/wp-widgets.js");
/* harmony import */ var _components_woo_messages__WEBPACK_IMPORTED_MODULE_19__ = __webpack_require__(/*! ./components/woo/messages */ "./src/js/components/woo/messages.js");
/* harmony import */ var _components_woo_added_to_cart_button__WEBPACK_IMPORTED_MODULE_20__ = __webpack_require__(/*! ./components/woo/added-to-cart-button */ "./src/js/components/woo/added-to-cart-button.js");
/* harmony import */ var _components_woo_qty_buttons__WEBPACK_IMPORTED_MODULE_21__ = __webpack_require__(/*! ./components/woo/qty-buttons */ "./src/js/components/woo/qty-buttons.js");
/* harmony import */ var _components_woo_select2__WEBPACK_IMPORTED_MODULE_22__ = __webpack_require__(/*! ./components/woo/select2 */ "./src/js/components/woo/select2.js");
/* harmony import */ var _components_woo_tooltipsters__WEBPACK_IMPORTED_MODULE_23__ = __webpack_require__(/*! ./components/woo/tooltipsters */ "./src/js/components/woo/tooltipsters.js");
/* harmony import */ var _components_woo_empty_cart__WEBPACK_IMPORTED_MODULE_24__ = __webpack_require__(/*! ./components/woo/empty-cart */ "./src/js/components/woo/empty-cart.js");
/* harmony import */ var _components_woo_header_elements_mini_cart__WEBPACK_IMPORTED_MODULE_25__ = __webpack_require__(/*! ./components/woo/header/elements/mini-cart */ "./src/js/components/woo/header/elements/mini-cart.js");
/* harmony import */ var _components_woo_login_form__WEBPACK_IMPORTED_MODULE_26__ = __webpack_require__(/*! ./components/woo/login-form */ "./src/js/components/woo/login-form.js");
/* harmony import */ var _components_woo_my_account_page__WEBPACK_IMPORTED_MODULE_27__ = __webpack_require__(/*! ./components/woo/my-account-page */ "./src/js/components/woo/my-account-page.js");
/* harmony import */ var _components_woo_sale_price_date__WEBPACK_IMPORTED_MODULE_28__ = __webpack_require__(/*! ./components/woo/sale-price-date */ "./src/js/components/woo/sale-price-date.js");
/* harmony import */ var _components_headers_elements_hamburger_button__WEBPACK_IMPORTED_MODULE_29__ = __webpack_require__(/*! ./components/headers/elements/hamburger-button */ "./src/js/components/headers/elements/hamburger-button.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }




















/**
 * wooCommerce
 */











var KFWFramework = /*#__PURE__*/function () {
  function KFWFramework(options) {
    _classCallCheck(this, KFWFramework);
    this.options = $.extend(true, {
      name: KIN_FW_ONNAT_OBJ.theme,
      author: KIN_FW_ONNAT_OBJ.themeAuthor,
      popupModalToggleClass: "kinfw-popup-modal-open"
    }, options);
    this._init();
  }
  return _createClass(KFWFramework, [{
    key: "_init",
    value: function _init() {
      gsap.registerPlugin(ScrollTrigger, ScrollSmoother);
      gsap.config({
        nullTargetWarn: false,
        trialWarn: false
      });
      ScrollTrigger.normalizeScroll(false);
      var _self = this;
      _self._initOptions();
      _self._initModules();
    }
  }, {
    key: "_initOptions",
    value: function _initOptions() {
      var _self = this;
      _self.options.bodyEle = $("body");
      _self.options.bodyAltEle = document.querySelector('body');
      _self.options.windowEle = $(window);
      _self.options.utils = new _utils__WEBPACK_IMPORTED_MODULE_0__["default"]();
      if ('undefined' === typeof window.elementorFrontend) {
        _self.options.elementorMode = false;
      } else {
        _self.options.elementorMode = window.elementorFrontend.config.environmentMode.edit;
      }
    }
  }, {
    key: "_initModules",
    value: function _initModules() {
      var _self = this;

      /**
       * Body ScrollSmoother
       */
      new _components_body_scroll_smoother__WEBPACK_IMPORTED_MODULE_1__["default"](_self.options);

      /**
       * Browser address bar color
       */
      new _components_address_bar__WEBPACK_IMPORTED_MODULE_2__["default"](_self.options);

      /**
       * Convert img.kinfw-switch-svg into svg tag
       */
      new _components_svg_convert__WEBPACK_IMPORTED_MODULE_4__["default"](_self.options);

      /**
       * Init Module: Custom Cursor
       */
      _self.options.customCursor = new _components_cursor__WEBPACK_IMPORTED_MODULE_5__["default"](_self.options);

      /**
       * Init Module: Pre Loader
       */
      _self.options.preLoader = new _components_pre_loader__WEBPACK_IMPORTED_MODULE_6__["default"](_self.options);

      /**
       * Init Module: Scroll Bar
       */
      _self.options.scrollBar = new _components_scroll_bar__WEBPACK_IMPORTED_MODULE_7__["default"](_self.options);

      /**
       * Init Module: Header
       */

      /**
       * Sticky Header
       */
      _self.options.stickyHeader = new _components_headers_sticky_header__WEBPACK_IMPORTED_MODULE_8__["default"](_self.options);

      /**
       * Sticky Header
       */
      _self.options.subMenuHoverEffect = new _components_headers_submenu_hover_effect__WEBPACK_IMPORTED_MODULE_10__["default"](_self.options);

      /**
       * Mobile Header
       */
      _self.options.mobileHeader = new _components_headers_mobile_header__WEBPACK_IMPORTED_MODULE_9__["default"](_self.options);

      /**
       * Elements
       */
      _self.options.headerElementSearch = new _components_headers_elements_search__WEBPACK_IMPORTED_MODULE_11__["default"](_self.options);
      _self.options.headerElementUserLogin = new _components_headers_elements_user_login__WEBPACK_IMPORTED_MODULE_12__["default"](_self.options);
      _self.options.headerElementHamburgerButton = new _components_headers_elements_hamburger_button__WEBPACK_IMPORTED_MODULE_29__["default"](_self.options);

      /**
       * Init Module: Go To Top
       */
      _self.options.goToTop = new _components_go_to_top__WEBPACK_IMPORTED_MODULE_13__["default"](_self.options);

      /**
       * Init Module: Single Blog Post
       */
      _self.options.singleBlogPost = new _components_single_blog_post__WEBPACK_IMPORTED_MODULE_14__["default"](_self.options);

      /**
       * Init Module: FitVids
       */
      _self.options.fitVids = new _components_fitvids__WEBPACK_IMPORTED_MODULE_16__["default"]();

      /**
       * Init Module: ImageGallery
       */
      _self.options.magnificPopup = new _components_image_gallery__WEBPACK_IMPORTED_MODULE_17__["default"](_self.options);

      /**
       * Init Module: WordPress Widgets
       */
      _self.options.wpWidgets = new _components_wp_widgets__WEBPACK_IMPORTED_MODULE_18__["default"]();

      /**
       * Init Module: Ripple Button
       */
      new _components_ripple_button__WEBPACK_IMPORTED_MODULE_15__["default"]();

      /**
       * wooCommerce
       */

      /**
       * Init Module: wooCommerce message
       */
      _self.options.wooMessages = new _components_woo_messages__WEBPACK_IMPORTED_MODULE_19__["default"](_self.options);

      /**
       * Init Module: Shop Page - After product added to cart, modify the added to cart button
       */
      _self.options.shopPageAddToCart = new _components_woo_added_to_cart_button__WEBPACK_IMPORTED_MODULE_20__["default"]();

      /**
       * Init Module: wooQtyButtons
       */
      _self.options.wooQtyButtons = new _components_woo_qty_buttons__WEBPACK_IMPORTED_MODULE_21__["default"](_self.options);

      /**
       * Init Module: wooCommerce select elements
       */
      _self.options.wooSelect2 = new _components_woo_select2__WEBPACK_IMPORTED_MODULE_22__["default"]();

      /**
       * Init Module: wooCommerce tooltipsters
       */
      _self.options.wooTooltipsters = new _components_woo_tooltipsters__WEBPACK_IMPORTED_MODULE_23__["default"](_self.options);
      _self.options.wooEmptyCart = new _components_woo_empty_cart__WEBPACK_IMPORTED_MODULE_24__["default"]();

      /**
       * Init Module: Header Element : MiniCart
       */
      _self.options.headerElementMiniCart = new _components_woo_header_elements_mini_cart__WEBPACK_IMPORTED_MODULE_25__["default"](_self.options);

      /**
       * Init Module: WooCommerce Login Form
       */
      _self.options.wooLoginFormPage = new _components_woo_login_form__WEBPACK_IMPORTED_MODULE_26__["default"](_self.options);

      /**
       * Init Module: WooCommerce My Account Page
       */
      _self.options.wooMyAccountPage = new _components_woo_my_account_page__WEBPACK_IMPORTED_MODULE_27__["default"](_self.options);

      /**
       * Init Module: Sale Price Date Counter
       */
      _self.options.woo = new _components_woo_sale_price_date__WEBPACK_IMPORTED_MODULE_28__["default"](_self.options);

      //new KFWAnchors( _self.options );
    }
  }]);
}();
new KFWFramework();
})();

/******/ })()
;