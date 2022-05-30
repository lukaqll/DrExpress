"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_Admin_Home_index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ReportHomeCard/index.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ReportHomeCard/index.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    data: Object
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Admin/Home/index.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Admin/Home/index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_ReportHomeCard__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../components/ReportHomeCard */ "./resources/js/components/ReportHomeCard/index.vue");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ReportHomeCard: _components_ReportHomeCard__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      data: {}
    };
  },
  computed: {
    cards: function cards() {
      return [{
        title: 'Vendedores',
        color: 'yellow darken-2',
        icon: 'fa fa-store',
        info: this.data.sellers,
        link: '/admin/sellers',
        canLink: ['view-sellers']
      }, {
        title: 'Operadores',
        color: 'purple',
        icon: 'fa fa-users',
        info: this.data.operators,
        link: '/admin/users',
        canLink: ['view-users']
      }, {
        title: 'Clientes',
        color: 'success darken-2',
        icon: 'fa fa-mobile-alt',
        info: this.data.clients
      }];
    }
  },
  mounted: function mounted() {
    this.getHomeData();
  },
  methods: {
    getHomeData: function getHomeData() {
      var _this = this;

      this.$commom.request({
        url: '/admin/home',
        auth: true,
        success: function success(resp) {
          _this.data = _objectSpread({}, resp);
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ReportHomeCard/index.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/ReportHomeCard/index.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ReportHomeCard/index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Admin/Home/index.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/pages/Admin/Home/index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Admin/Home/index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ReportHomeCard/index.vue?vue&type=template&id=1cdf8791&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/ReportHomeCard/index.vue?vue&type=template&id=1cdf8791& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1cdf8791___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1cdf8791___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1cdf8791___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=template&id=1cdf8791& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ReportHomeCard/index.vue?vue&type=template&id=1cdf8791&");


/***/ }),

/***/ "./resources/js/pages/Admin/Home/index.vue?vue&type=template&id=6b41cb0b&":
/*!********************************************************************************!*\
  !*** ./resources/js/pages/Admin/Home/index.vue?vue&type=template&id=6b41cb0b& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_6b41cb0b___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_6b41cb0b___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_6b41cb0b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=template&id=6b41cb0b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Admin/Home/index.vue?vue&type=template&id=6b41cb0b&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ReportHomeCard/index.vue?vue&type=template&id=1cdf8791&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ReportHomeCard/index.vue?vue&type=template&id=1cdf8791& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-card",
    { staticClass: "h-100" },
    [
      _c("v-card-text", [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-12" }, [
            _c("div", { staticClass: "row" }, [
              _c(
                "div",
                { staticClass: "col-2" },
                [
                  _c(
                    "v-avatar",
                    { attrs: { color: _vm.data.color, icon: "" } },
                    [
                      _c("v-icon", { attrs: { dark: "" } }, [
                        _vm._v(_vm._s(_vm.data.icon)),
                      ]),
                    ],
                    1
                  ),
                ],
                1
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-10" }, [
                _vm.data.info
                  ? _c("span", { staticClass: "text-h4" }, [
                      _vm._v(_vm._s(_vm.data.info.total)),
                    ])
                  : _vm._e(),
                _c("br"),
                _vm._v(" "),
                _c("span", { staticClass: "h5" }, [
                  _vm._v(_vm._s(_vm.data.title)),
                ]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-12" },
            [
              _vm.data.info
                ? _c("v-sparkline", {
                    attrs: {
                      value: _vm.data.info.chart,
                      "auto-draw": "",
                      "auto-draw-duration": 1000,
                      color: _vm.data.color,
                      "auto-line-width": false,
                      "stroke-linecap": "round",
                      smooth: "15",
                      "line-width": "2",
                      height: "50",
                    },
                  })
                : _vm._e(),
            ],
            1
          ),
          _vm._v(" "),
          _vm.data.link
            ? _c("div", { staticClass: "col-12" }, [
                !_vm.data.canLink ||
                (_vm.data.canLink && _vm.$can(_vm.data.canLink))
                  ? _c(
                      "div",
                      [
                        _c(
                          "v-btn",
                          {
                            tag: "router-link",
                            attrs: {
                              to: _vm.data.link,
                              text: "",
                              block: "",
                              color: _vm.data.color,
                            },
                          },
                          [_vm._v("Detalhes")]
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
              ])
            : _vm._e(),
        ]),
      ]),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Admin/Home/index.vue?vue&type=template&id=6b41cb0b&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Admin/Home/index.vue?vue&type=template&id=6b41cb0b& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "row" },
    _vm._l(_vm.cards, function (card, i) {
      return _c(
        "div",
        { key: i, staticClass: "col-md-4" },
        [_c("report-home-card", { attrs: { data: card } })],
        1
      )
    }),
    0
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/ReportHomeCard/index.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/ReportHomeCard/index.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _index_vue_vue_type_template_id_1cdf8791___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=1cdf8791& */ "./resources/js/components/ReportHomeCard/index.vue?vue&type=template&id=1cdf8791&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/js/components/ReportHomeCard/index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vuetify-loader/lib/runtime/installComponents.js */ "./node_modules/vuetify-loader/lib/runtime/installComponents.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuetify_lib_components_VAvatar__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuetify/lib/components/VAvatar */ "./node_modules/vuetify/lib/components/VAvatar/VAvatar.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/VCard.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/index.js");
/* harmony import */ var vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vuetify/lib/components/VIcon */ "./node_modules/vuetify/lib/components/VIcon/VIcon.js");
/* harmony import */ var vuetify_lib_components_VSparkline__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! vuetify/lib/components/VSparkline */ "./node_modules/vuetify/lib/components/VSparkline/VSparkline.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _index_vue_vue_type_template_id_1cdf8791___WEBPACK_IMPORTED_MODULE_0__.render,
  _index_vue_vue_type_template_id_1cdf8791___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* vuetify-loader */
;





_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default()(component, {VAvatar: vuetify_lib_components_VAvatar__WEBPACK_IMPORTED_MODULE_4__["default"],VCard: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__["default"],VCardText: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardText,VIcon: vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_7__["default"],VSparkline: vuetify_lib_components_VSparkline__WEBPACK_IMPORTED_MODULE_8__["default"]})


/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ReportHomeCard/index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Admin/Home/index.vue":
/*!*************************************************!*\
  !*** ./resources/js/pages/Admin/Home/index.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _index_vue_vue_type_template_id_6b41cb0b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=6b41cb0b& */ "./resources/js/pages/Admin/Home/index.vue?vue&type=template&id=6b41cb0b&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/js/pages/Admin/Home/index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _index_vue_vue_type_template_id_6b41cb0b___WEBPACK_IMPORTED_MODULE_0__.render,
  _index_vue_vue_type_template_id_6b41cb0b___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Admin/Home/index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VSparkline/VSparkline.js":
/*!**********************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VSparkline/VSparkline.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _mixins_colorable__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../mixins/colorable */ "./node_modules/vuetify/lib/mixins/colorable/index.js");
/* harmony import */ var _util_mixins__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../util/mixins */ "./node_modules/vuetify/lib/util/mixins.js");
/* harmony import */ var _helpers_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./helpers/core */ "./node_modules/vuetify/lib/components/VSparkline/helpers/core.js");
/* harmony import */ var _helpers_path__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./helpers/path */ "./node_modules/vuetify/lib/components/VSparkline/helpers/path.js");
// Mixins
 // Utilities




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_util_mixins__WEBPACK_IMPORTED_MODULE_0__["default"])(_mixins_colorable__WEBPACK_IMPORTED_MODULE_1__["default"]).extend({
  name: 'VSparkline',
  inheritAttrs: false,
  props: {
    autoDraw: Boolean,
    autoDrawDuration: {
      type: Number,
      default: 2000
    },
    autoDrawEasing: {
      type: String,
      default: 'ease'
    },
    autoLineWidth: {
      type: Boolean,
      default: false
    },
    color: {
      type: String,
      default: 'primary'
    },
    fill: {
      type: Boolean,
      default: false
    },
    gradient: {
      type: Array,
      default: () => []
    },
    gradientDirection: {
      type: String,
      validator: val => ['top', 'bottom', 'left', 'right'].includes(val),
      default: 'top'
    },
    height: {
      type: [String, Number],
      default: 75
    },
    labels: {
      type: Array,
      default: () => []
    },
    labelSize: {
      type: [Number, String],
      default: 7
    },
    lineWidth: {
      type: [String, Number],
      default: 4
    },
    padding: {
      type: [String, Number],
      default: 8
    },
    showLabels: Boolean,
    smooth: {
      type: [Boolean, Number, String],
      default: false
    },
    type: {
      type: String,
      default: 'trend',
      validator: val => ['trend', 'bar'].includes(val)
    },
    value: {
      type: Array,
      default: () => []
    },
    width: {
      type: [Number, String],
      default: 300
    }
  },
  data: () => ({
    lastLength: 0
  }),
  computed: {
    parsedPadding() {
      return Number(this.padding);
    },

    parsedWidth() {
      return Number(this.width);
    },

    parsedHeight() {
      return parseInt(this.height, 10);
    },

    parsedLabelSize() {
      return parseInt(this.labelSize, 10) || 7;
    },

    totalHeight() {
      let height = this.parsedHeight;
      if (this.hasLabels) height += parseInt(this.labelSize, 10) * 1.5;
      return height;
    },

    totalWidth() {
      let width = this.parsedWidth;
      if (this.type === 'bar') width = Math.max(this.value.length * this._lineWidth, width);
      return width;
    },

    totalValues() {
      return this.value.length;
    },

    _lineWidth() {
      if (this.autoLineWidth && this.type !== 'trend') {
        const totalPadding = this.parsedPadding * (this.totalValues + 1);
        return (this.parsedWidth - totalPadding) / this.totalValues;
      } else {
        return parseFloat(this.lineWidth) || 4;
      }
    },

    boundary() {
      if (this.type === 'bar') return {
        minX: 0,
        maxX: this.totalWidth,
        minY: 0,
        maxY: this.parsedHeight
      };
      const padding = this.parsedPadding;
      return {
        minX: padding,
        maxX: this.totalWidth - padding,
        minY: padding,
        maxY: this.parsedHeight - padding
      };
    },

    hasLabels() {
      return Boolean(this.showLabels || this.labels.length > 0 || this.$scopedSlots.label);
    },

    parsedLabels() {
      const labels = [];
      const points = this._values;
      const len = points.length;

      for (let i = 0; labels.length < len; i++) {
        const item = points[i];
        let value = this.labels[i];

        if (!value) {
          value = typeof item === 'object' ? item.value : item;
        }

        labels.push({
          x: item.x,
          value: String(value)
        });
      }

      return labels;
    },

    normalizedValues() {
      return this.value.map(item => typeof item === 'number' ? item : item.value);
    },

    _values() {
      return this.type === 'trend' ? (0,_helpers_core__WEBPACK_IMPORTED_MODULE_2__.genPoints)(this.normalizedValues, this.boundary) : (0,_helpers_core__WEBPACK_IMPORTED_MODULE_2__.genBars)(this.normalizedValues, this.boundary);
    },

    textY() {
      let y = this.parsedHeight;
      if (this.type === 'trend') y -= 4;
      return y;
    },

    _radius() {
      return this.smooth === true ? 8 : Number(this.smooth);
    }

  },
  watch: {
    value: {
      immediate: true,

      handler() {
        this.$nextTick(() => {
          if (!this.autoDraw || this.type === 'bar' || !this.$refs.path) return;
          const path = this.$refs.path;
          const length = path.getTotalLength();

          if (!this.fill) {
            path.style.transition = 'none';
            path.style.strokeDasharray = length + ' ' + length;
            path.style.strokeDashoffset = Math.abs(length - (this.lastLength || 0)).toString();
            path.getBoundingClientRect();
            path.style.transition = `stroke-dashoffset ${this.autoDrawDuration}ms ${this.autoDrawEasing}`;
            path.style.strokeDashoffset = '0';
          } else {
            path.style.transformOrigin = 'bottom center';
            path.style.transition = 'none';
            path.style.transform = `scaleY(0)`;
            path.getBoundingClientRect();
            path.style.transition = `transform ${this.autoDrawDuration}ms ${this.autoDrawEasing}`;
            path.style.transform = `scaleY(1)`;
          }

          this.lastLength = length;
        });
      }

    }
  },
  methods: {
    genGradient() {
      const gradientDirection = this.gradientDirection;
      const gradient = this.gradient.slice(); // Pushes empty string to force
      // a fallback to currentColor

      if (!gradient.length) gradient.push('');
      const len = Math.max(gradient.length - 1, 1);
      const stops = gradient.reverse().map((color, index) => this.$createElement('stop', {
        attrs: {
          offset: index / len,
          'stop-color': color || 'currentColor'
        }
      }));
      return this.$createElement('defs', [this.$createElement('linearGradient', {
        attrs: {
          id: this._uid,
          gradientUnits: 'userSpaceOnUse',
          x1: gradientDirection === 'left' ? '100%' : '0',
          y1: gradientDirection === 'top' ? '100%' : '0',
          x2: gradientDirection === 'right' ? '100%' : '0',
          y2: gradientDirection === 'bottom' ? '100%' : '0'
        }
      }, stops)]);
    },

    genG(children) {
      return this.$createElement('g', {
        style: {
          fontSize: '8',
          textAnchor: 'middle',
          dominantBaseline: 'mathematical',
          fill: 'currentColor'
        }
      }, children);
    },

    genPath() {
      const points = (0,_helpers_core__WEBPACK_IMPORTED_MODULE_2__.genPoints)(this.normalizedValues, this.boundary);
      return this.$createElement('path', {
        attrs: {
          d: (0,_helpers_path__WEBPACK_IMPORTED_MODULE_3__.genPath)(points, this._radius, this.fill, this.parsedHeight),
          fill: this.fill ? `url(#${this._uid})` : 'none',
          stroke: this.fill ? 'none' : `url(#${this._uid})`
        },
        ref: 'path'
      });
    },

    genLabels(offsetX) {
      const children = this.parsedLabels.map((item, i) => this.$createElement('text', {
        attrs: {
          x: item.x + offsetX + this._lineWidth / 2,
          y: this.textY + this.parsedLabelSize * 0.75,
          'font-size': Number(this.labelSize) || 7
        }
      }, [this.genLabel(item, i)]));
      return this.genG(children);
    },

    genLabel(item, index) {
      return this.$scopedSlots.label ? this.$scopedSlots.label({
        index,
        value: item.value
      }) : item.value;
    },

    genBars() {
      if (!this.value || this.totalValues < 2) return undefined;
      const bars = (0,_helpers_core__WEBPACK_IMPORTED_MODULE_2__.genBars)(this.normalizedValues, this.boundary);
      const offsetX = (Math.abs(bars[0].x - bars[1].x) - this._lineWidth) / 2;
      return this.$createElement('svg', {
        attrs: {
          display: 'block',
          viewBox: `0 0 ${this.totalWidth} ${this.totalHeight}`
        }
      }, [this.genGradient(), this.genClipPath(bars, offsetX, this._lineWidth, 'sparkline-bar-' + this._uid), this.hasLabels ? this.genLabels(offsetX) : undefined, this.$createElement('g', {
        attrs: {
          'clip-path': `url(#sparkline-bar-${this._uid}-clip)`,
          fill: `url(#${this._uid})`
        }
      }, [this.$createElement('rect', {
        attrs: {
          x: 0,
          y: 0,
          width: this.totalWidth,
          height: this.height
        }
      })])]);
    },

    genClipPath(bars, offsetX, lineWidth, id) {
      const rounding = typeof this.smooth === 'number' ? this.smooth : this.smooth ? 2 : 0;
      return this.$createElement('clipPath', {
        attrs: {
          id: `${id}-clip`
        }
      }, bars.map(item => {
        return this.$createElement('rect', {
          attrs: {
            x: item.x + offsetX,
            y: item.y,
            width: lineWidth,
            height: item.height,
            rx: rounding,
            ry: rounding
          }
        }, [this.autoDraw ? this.$createElement('animate', {
          attrs: {
            attributeName: 'height',
            from: 0,
            to: item.height,
            dur: `${this.autoDrawDuration}ms`,
            fill: 'freeze'
          }
        }) : undefined]);
      }));
    },

    genTrend() {
      return this.$createElement('svg', this.setTextColor(this.color, {
        attrs: { ...this.$attrs,
          display: 'block',
          'stroke-width': this._lineWidth || 1,
          viewBox: `0 0 ${this.width} ${this.totalHeight}`
        }
      }), [this.genGradient(), this.hasLabels && this.genLabels(-(this._lineWidth / 2)), this.genPath()]);
    }

  },

  render(h) {
    if (this.totalValues < 2) return undefined;
    return this.type === 'trend' ? this.genTrend() : this.genBars();
  }

}));
//# sourceMappingURL=VSparkline.js.map

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VSparkline/helpers/core.js":
/*!************************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VSparkline/helpers/core.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "genBars": () => (/* binding */ genBars),
/* harmony export */   "genPoints": () => (/* binding */ genPoints)
/* harmony export */ });
function genPoints(values, boundary) {
  const {
    minX,
    maxX,
    minY,
    maxY
  } = boundary;
  const totalValues = values.length;
  const maxValue = Math.max(...values);
  const minValue = Math.min(...values);
  const gridX = (maxX - minX) / (totalValues - 1);
  const gridY = (maxY - minY) / (maxValue - minValue || 1);
  return values.map((value, index) => {
    return {
      x: minX + index * gridX,
      y: maxY - (value - minValue) * gridY,
      value
    };
  });
}
function genBars(values, boundary) {
  const {
    minX,
    maxX,
    minY,
    maxY
  } = boundary;
  const totalValues = values.length;
  let maxValue = Math.max(...values);
  let minValue = Math.min(...values);
  if (minValue > 0) minValue = 0;
  if (maxValue < 0) maxValue = 0;
  const gridX = maxX / totalValues;
  const gridY = (maxY - minY) / (maxValue - minValue || 1);
  const horizonY = maxY - Math.abs(minValue * gridY);
  return values.map((value, index) => {
    const height = Math.abs(gridY * value);
    return {
      x: minX + index * gridX,
      y: horizonY - height + +(value < 0) * height,
      height,
      value
    };
  });
}
//# sourceMappingURL=core.js.map

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VSparkline/helpers/math.js":
/*!************************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VSparkline/helpers/math.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "checkCollinear": () => (/* binding */ checkCollinear),
/* harmony export */   "getDistance": () => (/* binding */ getDistance),
/* harmony export */   "moveTo": () => (/* binding */ moveTo)
/* harmony export */ });
function int(value) {
  return parseInt(value, 10);
}
/**
 * https://en.wikipedia.org/wiki/Collinearity
 * x=(x1+x2)/2
 * y=(y1+y2)/2
 */


function checkCollinear(p0, p1, p2) {
  return int(p0.x + p2.x) === int(2 * p1.x) && int(p0.y + p2.y) === int(2 * p1.y);
}
function getDistance(p1, p2) {
  return Math.sqrt(Math.pow(p2.x - p1.x, 2) + Math.pow(p2.y - p1.y, 2));
}
function moveTo(to, from, radius) {
  const vector = {
    x: to.x - from.x,
    y: to.y - from.y
  };
  const length = Math.sqrt(vector.x * vector.x + vector.y * vector.y);
  const unitVector = {
    x: vector.x / length,
    y: vector.y / length
  };
  return {
    x: from.x + unitVector.x * radius,
    y: from.y + unitVector.y * radius
  };
}
//# sourceMappingURL=math.js.map

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VSparkline/helpers/path.js":
/*!************************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VSparkline/helpers/path.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "genPath": () => (/* binding */ genPath)
/* harmony export */ });
/* harmony import */ var _math__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./math */ "./node_modules/vuetify/lib/components/VSparkline/helpers/math.js");

/**
 * From https://github.com/unsplash/react-trend/blob/master/src/helpers/DOM.helpers.js#L18
 */

function genPath(points, radius, fill = false, height = 75) {
  const start = points.shift();
  const end = points[points.length - 1];
  return (fill ? `M${start.x} ${height - start.x + 2} L${start.x} ${start.y}` : `M${start.x} ${start.y}`) + points.map((point, index) => {
    const next = points[index + 1];
    const prev = points[index - 1] || start;
    const isCollinear = next && (0,_math__WEBPACK_IMPORTED_MODULE_0__.checkCollinear)(next, point, prev);

    if (!next || isCollinear) {
      return `L${point.x} ${point.y}`;
    }

    const threshold = Math.min((0,_math__WEBPACK_IMPORTED_MODULE_0__.getDistance)(prev, point), (0,_math__WEBPACK_IMPORTED_MODULE_0__.getDistance)(next, point));
    const isTooCloseForRadius = threshold / 2 < radius;
    const radiusForPoint = isTooCloseForRadius ? threshold / 2 : radius;
    const before = (0,_math__WEBPACK_IMPORTED_MODULE_0__.moveTo)(prev, point, radiusForPoint);
    const after = (0,_math__WEBPACK_IMPORTED_MODULE_0__.moveTo)(next, point, radiusForPoint);
    return `L${before.x} ${before.y}S${point.x} ${point.y} ${after.x} ${after.y}`;
  }).join('') + (fill ? `L${end.x} ${height - start.x + 2} Z` : '');
}
//# sourceMappingURL=path.js.map

/***/ })

}]);