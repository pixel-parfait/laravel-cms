window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from 'vue'

import VueRouter from 'vue-router'
import VueAxios from 'vue-axios'
import VueSweetalert2 from 'vue-sweetalert2'

import moment from 'moment'

import axios from 'axios'

import { routes } from './routes'

// Fontawesome
import { library } from '@fortawesome/fontawesome-svg-core'
import {
    faPlus, faEdit, faTrash, faEye, faEyeSlash, faAt,
    faSyncAlt, faDownload, faCheck, faTimes, faGripLines,
    faExclamationTriangle, faLink, faEnvelope, faLock,
    faUsers, faPowerOff, faBars, faUpload, faChevronUp,
    faChevronDown, faSpinner, faNewspaper, faPhotoVideo,
    faFile
} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
    faPlus, faEdit, faTrash, faEye, faEyeSlash, faAt,
    faSyncAlt, faDownload, faCheck, faTimes, faGripLines,
    faExclamationTriangle, faLink, faEnvelope, faLock,
    faUsers, faPowerOff, faBars, faUpload, faChevronUp,
    faChevronDown, faSpinner, faNewspaper, faPhotoVideo,
    faFile
)

Vue.component('fa-icon', FontAwesomeIcon)

// TinyMCE
import Editor from '@tinymce/tinymce-vue'
import 'tinymce/tinymce'

import 'tinymce/themes/silver/theme'
import 'tinymce/icons/default/icons'
import 'tinymce/plugins/anchor'
import 'tinymce/plugins/autolink'
import 'tinymce/plugins/code'
import 'tinymce/plugins/image'
import 'tinymce/plugins/link'
import 'tinymce/plugins/lists'
import 'tinymce/plugins/media'
import 'tinymce/plugins/noneditable'
import 'tinymce/plugins/paste'
import 'tinymce/plugins/table'

Vue.component('editor', Editor)

axios.get('/sanctum/csrf-cookie').then(response => {
    console.log('Successfully logged in.')
})

Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(VueSweetalert2)

Vue.filter('date', function (value) {
    if (! value) {
        return ''
    }

    return moment(value).format('YYYY-MM-DD - HH:mm:ss')
})

import Pagination from './components/partials/Pagination.vue'

Vue.component('pagination', Pagination)

const router = new VueRouter({
    mode: 'history',
    routes: routes,
    linkActiveClass: 'is-active',
})

import App from './App.vue'
import store from './store'

const app = new Vue({
    el: '#app',
    router: router,
    store,
    components: {
        App,
    }
})
