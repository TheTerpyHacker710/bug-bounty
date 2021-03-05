const { vue } = require("laravel-mix");
const { VueLoaderPlugin } = require("vue-loader");

Vue.component('task', {
    template: '<li><slot></slot></li>'
});

new Vue({
    el: '#root'
});