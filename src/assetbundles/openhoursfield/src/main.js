// import Vue from 'vue'
// Vue.config.devtools = true;
var Vue = window.Vue;
import BusinessHours from './BusinessHours.vue'

const initOpenHours = (context) => {
    let {id, namespaceName, namespacedId, value} = context;
    let vueEl = new Vue({
        el: `#${namespacedId}`,
        components: {
            'business-hours': BusinessHours,
        }
    })
}

window.initOpenHours = initOpenHours;



