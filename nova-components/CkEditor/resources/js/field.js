Nova.booting((Vue, router) => {
    Vue.component('index-ck-editor', require('./components/IndexField'));
    Vue.component('detail-ck-editor', require('./components/DetailField'));
    Vue.component('form-ck-editor', require('./components/FormField'));
})
