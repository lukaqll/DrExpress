"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_Dashboard_Adresses_Cities_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
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
  data: function data() {
    return {
      loading: false,
      saveLoading: false,
      uf: {},
      editCity: {},
      city: {},
      createModal: false,
      updateModal: false
    };
  },
  mounted: function mounted() {
    this.getCities();
  },
  watch: {
    updateModal: function updateModal(v) {
      if (!v) this.editCity = {};
    },
    createModal: function createModal() {
      this.city = {};
    }
  },
  methods: {
    getCities: function getCities() {
      var _this = this;

      if (!this.$can('view-address')) return;
      this.loading = true;
      this.$commom.request({
        url: '/uf/' + this.$route.params.id + '/cities',
        auth: true,
        success: function success(resp) {
          _this.uf = _objectSpread({}, resp);
          _this.loading = false;
        },
        error: function error() {
          return _this.loading = false;
        }
      });
    },
    getCity: function getCity(id) {
      var city = this.uf.cities.find(function (s) {
        return s.id == id;
      });
      this.editCity = _objectSpread({}, city);
      this.updateModal = true;
    },
    createCity: function createCity() {
      var _this2 = this;

      if (!this.$can('create-address')) return;
      this.saveLoading = true;
      this.$commom.request({
        url: "/uf/".concat(this.uf.id, "/city"),
        type: 'post',
        auth: true,
        data: this.city,
        setError: true,
        success: function success(resp) {
          _this2.getCities();

          _this2.city = {};
          _this2.saveLoading = false;
        },
        error: function error(e) {
          _this2.saveLoading = false;
        }
      });
    },
    updateCity: function updateCity() {
      var _this3 = this;

      if (!this.$can('update-address')) return;
      this.saveLoading = true;
      this.$commom.request({
        url: "/city/".concat(this.editCity.id),
        type: 'put',
        auth: true,
        data: this.editCity,
        setError: true,
        success: function success(resp) {
          _this3.getCities();

          _this3.saveLoading = false;
          _this3.editCity = {};
          _this3.updateModal = false;
        },
        error: function error(e) {
          _this3.saveLoading = false;
        }
      });
    },
    deleteCity: function deleteCity(id) {
      var _this4 = this;

      if (!this.$can('delete-address')) return;
      this.$commom.confirm({
        title: 'Deseja deletar esta cidade?',
        onConfirm: function onConfirm() {
          _this4.saveLoading = true;

          _this4.$commom.request({
            url: "/city/".concat(id),
            type: 'delete',
            auth: true,
            setError: true,
            success: function success(resp) {
              _this4.getCities();

              _this4.saveLoading = false;
            },
            error: function error(e) {
              _this4.saveLoading = false;
            }
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[3]!./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[3]!./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".theme--light.v-data-table {\n  background-color: #FFFFFF;\n  color: rgba(0, 0, 0, 0.87);\n}\n.theme--light.v-data-table .v-data-table__divider {\n  border-right: thin solid rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table.v-data-table--fixed-header thead th {\n  background: #FFFFFF;\n  box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr > th {\n  color: rgba(0, 0, 0, 0.6);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {\n  border-bottom: thin solid rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:not(.v-data-table__mobile-row),\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:not(.v-data-table__mobile-row) {\n  border-bottom: thin solid rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:last-child,\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:last-child {\n  border-bottom: thin solid rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr.active {\n  background: #f5f5f5;\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:hover:not(.v-data-table__expanded__content):not(.v-data-table__empty-wrapper) {\n  background: #eeeeee;\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td:not(.v-data-table__mobile-row),\n.theme--light.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th:not(.v-data-table__mobile-row) {\n  border-top: thin solid rgba(0, 0, 0, 0.12);\n}\n\n.theme--dark.v-data-table {\n  background-color: #1E1E1E;\n  color: #FFFFFF;\n}\n.theme--dark.v-data-table .v-data-table__divider {\n  border-right: thin solid rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table.v-data-table--fixed-header thead th {\n  background: #1E1E1E;\n  box-shadow: inset 0 -1px 0 rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > thead > tr > th {\n  color: rgba(255, 255, 255, 0.7);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {\n  border-bottom: thin solid rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:not(.v-data-table__mobile-row),\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:not(.v-data-table__mobile-row) {\n  border-bottom: thin solid rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:last-child,\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:last-child {\n  border-bottom: thin solid rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr.active {\n  background: #505050;\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:hover:not(.v-data-table__expanded__content):not(.v-data-table__empty-wrapper) {\n  background: #616161;\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td:not(.v-data-table__mobile-row),\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th:not(.v-data-table__mobile-row) {\n  border-top: thin solid rgba(255, 255, 255, 0.12);\n}\n\n.v-data-table {\n  line-height: 1.5;\n  max-width: 100%;\n}\n.v-data-table > .v-data-table__wrapper > table {\n  width: 100%;\n  border-spacing: 0;\n}\n.v-data-table > .v-data-table__wrapper > table > tbody > tr > td,\n.v-data-table > .v-data-table__wrapper > table > tbody > tr > th,\n.v-data-table > .v-data-table__wrapper > table > thead > tr > td,\n.v-data-table > .v-data-table__wrapper > table > thead > tr > th,\n.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td,\n.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {\n  padding: 0 16px;\n  transition: height 0.2s cubic-bezier(0.4, 0, 0.6, 1);\n}\n.v-data-table > .v-data-table__wrapper > table > tbody > tr > th,\n.v-data-table > .v-data-table__wrapper > table > thead > tr > th,\n.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {\n  -webkit-user-select: none;\n     -moz-user-select: none;\n      -ms-user-select: none;\n          user-select: none;\n  font-size: 0.75rem;\n  height: 48px;\n}\n.v-application--is-ltr .v-data-table > .v-data-table__wrapper > table > tbody > tr > th,\n.v-application--is-ltr .v-data-table > .v-data-table__wrapper > table > thead > tr > th,\n.v-application--is-ltr .v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {\n  text-align: left;\n}\n.v-application--is-rtl .v-data-table > .v-data-table__wrapper > table > tbody > tr > th,\n.v-application--is-rtl .v-data-table > .v-data-table__wrapper > table > thead > tr > th,\n.v-application--is-rtl .v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {\n  text-align: right;\n}\n.v-data-table > .v-data-table__wrapper > table > tbody > tr > td,\n.v-data-table > .v-data-table__wrapper > table > thead > tr > td,\n.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td {\n  font-size: 0.875rem;\n  height: 48px;\n}\n\n.v-data-table__wrapper {\n  overflow-x: auto;\n  overflow-y: hidden;\n}\n\n.v-data-table__progress {\n  height: auto !important;\n}\n.v-data-table__progress th {\n  height: auto !important;\n  border: none !important;\n  padding: 0;\n  position: relative;\n}\n\n.v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td,\n.v-data-table--dense > .v-data-table__wrapper > table > thead > tr > td,\n.v-data-table--dense > .v-data-table__wrapper > table > tfoot > tr > td {\n  height: 32px;\n}\n.v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > th,\n.v-data-table--dense > .v-data-table__wrapper > table > thead > tr > th,\n.v-data-table--dense > .v-data-table__wrapper > table > tfoot > tr > th {\n  height: 32px;\n}\n\n.v-data-table--has-top > .v-data-table__wrapper > table > tbody > tr:first-child:hover > td:first-child {\n  border-top-left-radius: 0;\n}\n.v-data-table--has-top > .v-data-table__wrapper > table > tbody > tr:first-child:hover > td:last-child {\n  border-top-right-radius: 0;\n}\n\n.v-data-table--has-bottom > .v-data-table__wrapper > table > tbody > tr:last-child:hover > td:first-child {\n  border-bottom-left-radius: 0;\n}\n.v-data-table--has-bottom > .v-data-table__wrapper > table > tbody > tr:last-child:hover > td:last-child {\n  border-bottom-right-radius: 0;\n}\n\n.v-data-table--fixed-height .v-data-table__wrapper {\n  overflow-y: auto;\n}\n\n.v-data-table--fixed-header > .v-data-table__wrapper {\n  overflow-y: auto;\n}\n.v-data-table--fixed-header > .v-data-table__wrapper > table > thead > tr > th {\n  border-bottom: 0px !important;\n  position: -webkit-sticky;\n  position: sticky;\n  top: 0;\n  z-index: 2;\n}\n.v-data-table--fixed-header > .v-data-table__wrapper > table > thead > tr:nth-child(2) > th {\n  top: 48px;\n}\n.v-application--is-ltr .v-data-table--fixed-header .v-data-footer {\n  margin-right: 17px;\n}\n.v-application--is-rtl .v-data-table--fixed-header .v-data-footer {\n  margin-left: 17px;\n}\n\n.v-data-table--fixed-header.v-data-table--dense > .v-data-table__wrapper > table > thead > tr:nth-child(2) > th {\n  top: 32px;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass":
/*!**************************************************************************!*\
  !*** ./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_1_postcss_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_2_sass_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_3_VSimpleTable_sass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../css-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[1]!../../../../postcss-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[2]!../../../../sass-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[3]!./VSimpleTable.sass */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[3]!./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_css_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_1_postcss_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_2_sass_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_3_VSimpleTable_sass__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_css_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_1_postcss_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_2_sass_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_3_VSimpleTable_sass__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Cities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Cities.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Cities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=template&id=46639ee0&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=template&id=46639ee0& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Cities_vue_vue_type_template_id_46639ee0___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Cities_vue_vue_type_template_id_46639ee0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Cities_vue_vue_type_template_id_46639ee0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Cities.vue?vue&type=template&id=46639ee0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=template&id=46639ee0&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=template&id=46639ee0&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=template&id=46639ee0& ***!
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
    "div",
    [
      _c("div", { staticClass: "row justify-content-center" }, [
        _c(
          "div",
          { staticClass: "col-md-10" },
          [
            _c(
              "v-card",
              { attrs: { loading: _vm.loading } },
              [
                _c("v-card-title", [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col-md-6" }, [
                      _c(
                        "ul",
                        { staticClass: "breadcrumb" },
                        [
                          _c(
                            "router-link",
                            {
                              staticClass: "small breadcrumb-item",
                              attrs: { to: "/admin/adresses" },
                            },
                            [_vm._v("Endereços")]
                          ),
                          _vm._v(" "),
                          _c(
                            "li",
                            { staticClass: "small breadcrumb-item active" },
                            [_vm._v(_vm._s(_vm.uf.name))]
                          ),
                        ],
                        1
                      ),
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-6 text-right" },
                      [
                        _vm.$can("create-address") && _vm.uf.id
                          ? _c(
                              "v-btn",
                              {
                                attrs: { small: "" },
                                on: {
                                  click: function ($event) {
                                    _vm.createModal = true
                                  },
                                },
                              },
                              [
                                _c("v-icon", { attrs: { small: "" } }, [
                                  _vm._v("fa fa-plus"),
                                ]),
                                _vm._v(
                                  "\n                                Adicionar Cidade\n                            "
                                ),
                              ],
                              1
                            )
                          : _vm._e(),
                      ],
                      1
                    ),
                  ]),
                ]),
                _vm._v(" "),
                _c("v-card-text", [
                  _c("div", { staticClass: "row" }, [
                    _c(
                      "div",
                      { staticClass: "col-md-12" },
                      [
                        _c("v-simple-table", [
                          _c("thead", [
                            _c("tr", [
                              _c("th", [_vm._v("Nome")]),
                              _vm._v(" "),
                              _c("th", [_vm._v("IBGE")]),
                              _vm._v(" "),
                              _c("th", [_vm._v("CEP")]),
                              _vm._v(" "),
                              _c("th"),
                            ]),
                          ]),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            _vm._l(_vm.uf.cities, function (city) {
                              return _c("tr", { key: city.id }, [
                                _c("td", [_vm._v(_vm._s(city.name))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(city.ibge_code))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(city.cep))]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  [
                                    _vm.$can("view-address")
                                      ? _c(
                                          "v-btn",
                                          {
                                            tag: "router-link",
                                            attrs: {
                                              text: "",
                                              to:
                                                "/admin/city/" +
                                                city.id +
                                                "/districts",
                                            },
                                          },
                                          [
                                            _vm._v(
                                              "\n                                                " +
                                                _vm._s(city.districts.length) +
                                                " Bairros\n                                            "
                                            ),
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$can("update-address")
                                      ? _c(
                                          "v-btn",
                                          {
                                            attrs: {
                                              icon: "",
                                              color: "primary",
                                            },
                                            on: {
                                              click: function () {
                                                return _vm.getCity(city.id)
                                              },
                                            },
                                          },
                                          [
                                            _c(
                                              "v-icon",
                                              { attrs: { small: "" } },
                                              [_vm._v("fa fa-edit")]
                                            ),
                                          ],
                                          1
                                        )
                                      : _vm._e(),
                                  ],
                                  1
                                ),
                              ])
                            }),
                            0
                          ),
                        ]),
                      ],
                      1
                    ),
                  ]),
                ]),
              ],
              1
            ),
          ],
          1
        ),
      ]),
      _vm._v(" "),
      _c(
        "v-dialog",
        {
          attrs: { "max-width": "600" },
          on: {
            "click:outside": function ($event) {
              _vm.dialog = null
            },
          },
          model: {
            value: _vm.createModal,
            callback: function ($$v) {
              _vm.createModal = $$v
            },
            expression: "createModal",
          },
        },
        [
          _c(
            "v-card",
            [
              _c("v-card-title", [_vm._v("Adicionar Cidade")]),
              _vm._v(" "),
              _c(
                "v-card-text",
                [
                  _c(
                    "v-form",
                    {
                      on: {
                        submit: function ($event) {
                          $event.preventDefault()
                          return _vm.createCity.apply(null, arguments)
                        },
                      },
                    },
                    [
                      _c("div", { staticClass: "row" }, [
                        _c(
                          "div",
                          { staticClass: "col-md-12" },
                          [
                            _c("v-text-field", {
                              attrs: { autofocus: "", label: "Nome" },
                              model: {
                                value: _vm.city.name,
                                callback: function ($$v) {
                                  _vm.$set(_vm.city, "name", $$v)
                                },
                                expression: "city.name",
                              },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-6" },
                          [
                            _c("v-text-field", {
                              directives: [
                                {
                                  name: "mask",
                                  rawName: "v-mask",
                                  value: "#####-###",
                                  expression: "'#####-###'",
                                },
                              ],
                              attrs: { label: "CEP" },
                              model: {
                                value: _vm.city.cep,
                                callback: function ($$v) {
                                  _vm.$set(_vm.city, "cep", $$v)
                                },
                                expression: "city.cep",
                              },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-6" },
                          [
                            _c("v-text-field", {
                              attrs: { label: "Código IBGE" },
                              model: {
                                value: _vm.city.ibge_code,
                                callback: function ($$v) {
                                  _vm.$set(_vm.city, "ibge_code", $$v)
                                },
                                expression: "city.ibge_code",
                              },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-12 d-flex justify-end" },
                          [
                            _c(
                              "v-btn",
                              {
                                attrs: { text: "", color: "error" },
                                on: {
                                  click: function ($event) {
                                    _vm.createModal = false
                                  },
                                },
                              },
                              [_vm._v("Fechar")]
                            ),
                            _vm._v(" "),
                            _c(
                              "v-btn",
                              {
                                attrs: {
                                  loading: _vm.saveLoading,
                                  type: "submit",
                                  color: "primary",
                                },
                              },
                              [_vm._v("Salvar")]
                            ),
                          ],
                          1
                        ),
                      ]),
                    ]
                  ),
                ],
                1
              ),
            ],
            1
          ),
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-dialog",
        {
          attrs: { "max-width": "600" },
          model: {
            value: _vm.updateModal,
            callback: function ($$v) {
              _vm.updateModal = $$v
            },
            expression: "updateModal",
          },
        },
        [
          _c(
            "v-card",
            [
              _c("v-card-title", [_vm._v("Editar Cidade")]),
              _vm._v(" "),
              _c(
                "v-card-text",
                [
                  _c(
                    "v-form",
                    {
                      on: {
                        submit: function ($event) {
                          $event.preventDefault()
                          return _vm.updateCity.apply(null, arguments)
                        },
                      },
                    },
                    [
                      _c("div", { staticClass: "row" }, [
                        _c(
                          "div",
                          { staticClass: "col-md-12" },
                          [
                            _c("v-text-field", {
                              attrs: { autofocus: "", label: "Nome" },
                              model: {
                                value: _vm.editCity.name,
                                callback: function ($$v) {
                                  _vm.$set(_vm.editCity, "name", $$v)
                                },
                                expression: "editCity.name",
                              },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-6" },
                          [
                            _c("v-text-field", {
                              directives: [
                                {
                                  name: "mask",
                                  rawName: "v-mask",
                                  value: "#####-###",
                                  expression: "'#####-###'",
                                },
                              ],
                              attrs: { label: "CEP" },
                              model: {
                                value: _vm.editCity.cep,
                                callback: function ($$v) {
                                  _vm.$set(_vm.editCity, "cep", $$v)
                                },
                                expression: "editCity.cep",
                              },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-6" },
                          [
                            _c("v-text-field", {
                              attrs: { label: "Código IBGE" },
                              model: {
                                value: _vm.editCity.ibge_code,
                                callback: function ($$v) {
                                  _vm.$set(_vm.editCity, "ibge_code", $$v)
                                },
                                expression: "editCity.ibge_code",
                              },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-12 d-flex justify-end" },
                          [
                            _c(
                              "v-btn",
                              {
                                attrs: { text: "", color: "error" },
                                on: {
                                  click: function ($event) {
                                    _vm.updateModal = false
                                  },
                                },
                              },
                              [_vm._v("Fechar")]
                            ),
                            _vm._v(" "),
                            _c(
                              "v-btn",
                              {
                                attrs: {
                                  loading: _vm.saveLoading,
                                  type: "submit",
                                  color: "primary",
                                },
                              },
                              [_vm._v("Salvar")]
                            ),
                          ],
                          1
                        ),
                      ]),
                    ]
                  ),
                ],
                1
              ),
            ],
            1
          ),
        ],
        1
      ),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/Dashboard/Adresses/Cities.vue":
/*!**********************************************************!*\
  !*** ./resources/js/pages/Dashboard/Adresses/Cities.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Cities_vue_vue_type_template_id_46639ee0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Cities.vue?vue&type=template&id=46639ee0& */ "./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=template&id=46639ee0&");
/* harmony import */ var _Cities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Cities.vue?vue&type=script&lang=js& */ "./resources/js/pages/Dashboard/Adresses/Cities.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vuetify-loader/lib/runtime/installComponents.js */ "./node_modules/vuetify-loader/lib/runtime/installComponents.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuetify/lib/components/VBtn */ "./node_modules/vuetify/lib/components/VBtn/VBtn.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/VCard.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/index.js");
/* harmony import */ var vuetify_lib_components_VDialog__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vuetify/lib/components/VDialog */ "./node_modules/vuetify/lib/components/VDialog/VDialog.js");
/* harmony import */ var vuetify_lib_components_VForm__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! vuetify/lib/components/VForm */ "./node_modules/vuetify/lib/components/VForm/VForm.js");
/* harmony import */ var vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! vuetify/lib/components/VIcon */ "./node_modules/vuetify/lib/components/VIcon/VIcon.js");
/* harmony import */ var vuetify_lib_components_VDataTable__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! vuetify/lib/components/VDataTable */ "./node_modules/vuetify/lib/components/VDataTable/VSimpleTable.js");
/* harmony import */ var vuetify_lib_components_VTextField__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! vuetify/lib/components/VTextField */ "./node_modules/vuetify/lib/components/VTextField/VTextField.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Cities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Cities_vue_vue_type_template_id_46639ee0___WEBPACK_IMPORTED_MODULE_0__.render,
  _Cities_vue_vue_type_template_id_46639ee0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* vuetify-loader */
;









_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default()(component, {VBtn: vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_4__["default"],VCard: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__["default"],VCardText: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardText,VCardTitle: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardTitle,VDialog: vuetify_lib_components_VDialog__WEBPACK_IMPORTED_MODULE_7__["default"],VForm: vuetify_lib_components_VForm__WEBPACK_IMPORTED_MODULE_8__["default"],VIcon: vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_9__["default"],VSimpleTable: vuetify_lib_components_VDataTable__WEBPACK_IMPORTED_MODULE_10__["default"],VTextField: vuetify_lib_components_VTextField__WEBPACK_IMPORTED_MODULE_11__["default"]})


/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Dashboard/Adresses/Cities.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VCard/index.js":
/*!************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VCard/index.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "VCard": () => (/* reexport safe */ _VCard__WEBPACK_IMPORTED_MODULE_1__["default"]),
/* harmony export */   "VCardActions": () => (/* binding */ VCardActions),
/* harmony export */   "VCardSubtitle": () => (/* binding */ VCardSubtitle),
/* harmony export */   "VCardText": () => (/* binding */ VCardText),
/* harmony export */   "VCardTitle": () => (/* binding */ VCardTitle),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _VCard__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./VCard */ "./node_modules/vuetify/lib/components/VCard/VCard.js");
/* harmony import */ var _util_helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../util/helpers */ "./node_modules/vuetify/lib/util/helpers.js");


const VCardActions = (0,_util_helpers__WEBPACK_IMPORTED_MODULE_0__.createSimpleFunctional)('v-card__actions');
const VCardSubtitle = (0,_util_helpers__WEBPACK_IMPORTED_MODULE_0__.createSimpleFunctional)('v-card__subtitle');
const VCardText = (0,_util_helpers__WEBPACK_IMPORTED_MODULE_0__.createSimpleFunctional)('v-card__text');
const VCardTitle = (0,_util_helpers__WEBPACK_IMPORTED_MODULE_0__.createSimpleFunctional)('v-card__title');

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  $_vuetify_subcomponents: {
    VCard: _VCard__WEBPACK_IMPORTED_MODULE_1__["default"],
    VCardActions,
    VCardSubtitle,
    VCardText,
    VCardTitle
  }
});
//# sourceMappingURL=index.js.map

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VDataTable/VSimpleTable.js":
/*!************************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VDataTable/VSimpleTable.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _src_components_VDataTable_VSimpleTable_sass__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../src/components/VDataTable/VSimpleTable.sass */ "./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass");
/* harmony import */ var _util_helpers__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../util/helpers */ "./node_modules/vuetify/lib/util/helpers.js");
/* harmony import */ var _mixins_themeable__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../mixins/themeable */ "./node_modules/vuetify/lib/mixins/themeable/index.js");
/* harmony import */ var _util_mixins__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../util/mixins */ "./node_modules/vuetify/lib/util/mixins.js");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_util_mixins__WEBPACK_IMPORTED_MODULE_1__["default"])(_mixins_themeable__WEBPACK_IMPORTED_MODULE_2__["default"]).extend({
  name: 'v-simple-table',
  props: {
    dense: Boolean,
    fixedHeader: Boolean,
    height: [Number, String]
  },
  computed: {
    classes() {
      return {
        'v-data-table--dense': this.dense,
        'v-data-table--fixed-height': !!this.height && !this.fixedHeader,
        'v-data-table--fixed-header': this.fixedHeader,
        'v-data-table--has-top': !!this.$slots.top,
        'v-data-table--has-bottom': !!this.$slots.bottom,
        ...this.themeClasses
      };
    }

  },
  methods: {
    genWrapper() {
      return this.$slots.wrapper || this.$createElement('div', {
        staticClass: 'v-data-table__wrapper',
        style: {
          height: (0,_util_helpers__WEBPACK_IMPORTED_MODULE_3__.convertToUnit)(this.height)
        }
      }, [this.$createElement('table', this.$slots.default)]);
    }

  },

  render(h) {
    return h('div', {
      staticClass: 'v-data-table',
      class: this.classes
    }, [this.$slots.top, this.genWrapper(), this.$slots.bottom]);
  }

}));
//# sourceMappingURL=VSimpleTable.js.map

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VForm/VForm.js":
/*!************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VForm/VForm.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _util_mixins__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../util/mixins */ "./node_modules/vuetify/lib/util/mixins.js");
/* harmony import */ var _mixins_binds_attrs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../mixins/binds-attrs */ "./node_modules/vuetify/lib/mixins/binds-attrs/index.js");
/* harmony import */ var _mixins_registrable__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../mixins/registrable */ "./node_modules/vuetify/lib/mixins/registrable/index.js");
// Mixins



/* @vue/component */

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_util_mixins__WEBPACK_IMPORTED_MODULE_0__["default"])(_mixins_binds_attrs__WEBPACK_IMPORTED_MODULE_1__["default"], (0,_mixins_registrable__WEBPACK_IMPORTED_MODULE_2__.provide)('form')
/* @vue/component */
).extend({
  name: 'v-form',

  provide() {
    return {
      form: this
    };
  },

  inheritAttrs: false,
  props: {
    disabled: Boolean,
    lazyValidation: Boolean,
    readonly: Boolean,
    value: Boolean
  },
  data: () => ({
    inputs: [],
    watchers: [],
    errorBag: {}
  }),
  watch: {
    errorBag: {
      handler(val) {
        const errors = Object.values(val).includes(true);
        this.$emit('input', !errors);
      },

      deep: true,
      immediate: true
    }
  },
  methods: {
    watchInput(input) {
      const watcher = input => {
        return input.$watch('hasError', val => {
          this.$set(this.errorBag, input._uid, val);
        }, {
          immediate: true
        });
      };

      const watchers = {
        _uid: input._uid,
        valid: () => {},
        shouldValidate: () => {}
      };

      if (this.lazyValidation) {
        // Only start watching inputs if we need to
        watchers.shouldValidate = input.$watch('shouldValidate', val => {
          if (!val) return; // Only watch if we're not already doing it

          if (this.errorBag.hasOwnProperty(input._uid)) return;
          watchers.valid = watcher(input);
        });
      } else {
        watchers.valid = watcher(input);
      }

      return watchers;
    },

    /** @public */
    validate() {
      return this.inputs.filter(input => !input.validate(true)).length === 0;
    },

    /** @public */
    reset() {
      this.inputs.forEach(input => input.reset());
      this.resetErrorBag();
    },

    resetErrorBag() {
      if (this.lazyValidation) {
        // Account for timeout in validatable
        setTimeout(() => {
          this.errorBag = {};
        }, 0);
      }
    },

    /** @public */
    resetValidation() {
      this.inputs.forEach(input => input.resetValidation());
      this.resetErrorBag();
    },

    register(input) {
      this.inputs.push(input);
      this.watchers.push(this.watchInput(input));
    },

    unregister(input) {
      const found = this.inputs.find(i => i._uid === input._uid);
      if (!found) return;
      const unwatch = this.watchers.find(i => i._uid === found._uid);

      if (unwatch) {
        unwatch.valid();
        unwatch.shouldValidate();
      }

      this.watchers = this.watchers.filter(i => i._uid !== found._uid);
      this.inputs = this.inputs.filter(i => i._uid !== found._uid);
      this.$delete(this.errorBag, found._uid);
    }

  },

  render(h) {
    return h('form', {
      staticClass: 'v-form',
      attrs: {
        novalidate: true,
        ...this.attrs$
      },
      on: {
        submit: e => this.$emit('submit', e)
      }
    }, this.$slots.default);
  }

}));
//# sourceMappingURL=VForm.js.map

/***/ })

}]);