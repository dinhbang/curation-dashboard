import Vue from 'vue'
import App from './App.vue'
import VuejsDialog from 'vuejs-dialog';

// include the default style
import 'vuejs-dialog/dist/vuejs-dialog.min.css';
Vue.use(VuejsDialog);

const app = new Vue({
    el: '#app',
    components: { App },
    template: `<app></app>`
});