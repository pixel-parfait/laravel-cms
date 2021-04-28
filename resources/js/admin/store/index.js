import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        defaultLocale: 'en',
        availableLocales: []
    },
    mutations: {
        setDefaultLocale (state, locale) {
            state.defaultLocale = locale
        },
        setAvailableLocales (state, locales) {
            state.availableLocales = locales
        }
    }
})
