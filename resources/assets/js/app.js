require('./bootstrap');

window.Vue = require('vue');

import toasterPlugin from 'v-toaster-evolution'
import 'v-toaster-evolution/dist/v-toaster-evolution.css'

import VeeValidate, { Validator } from 'vee-validate'
import es from './lang/es'
Validator.localize('es', es)
const config = {errorBagName: 'errors', fieldsBagName: 'fields', delay: 0, locale: 'es', dictionary: null, strict: true, classes: false, classNames: {touched: 'touched', untouched: 'untouched', valid: 'valid', invalid: 'invalid', pristine: 'pristine', dirty: 'dirty'}, events: 'input|blur', inject: true, validity: false, aria: true }; Vue.use(VeeValidate, config);
Vue.use(toasterPlugin);


import Reservation from './components/Reservation.vue'

const app = new Vue({
    el: '#reservation',
    components:{
    	Reservation
    }
});
