//Library Imports
import _ from 'lodash';
import Vue from 'vue';
import VueResource from 'vue-resource';

//Side-effect library imports (Can't call these directly unless you specify in webpack config provider plugin)
import 'jquery';
import 'tether';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';

//Main vue instance
new Vue({
    //To work with twig we have to adjust calling brackets
    delimiters: ['${', '}'],
    el: '#main-body',
    data: {
        test: ''
    },
    computed: {
        bodyLength() {
            return this.test.length;
        }
    }
});