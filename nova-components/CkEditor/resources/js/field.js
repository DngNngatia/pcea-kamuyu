import CKEditor from 'ckeditor4-vue';
Nova.booting((Vue, router) => {
    Vue.use( CKEditor );
    Vue.component('index-ck-editor', require('./components/IndexField'));
    Vue.component('detail-ck-editor', require('./components/DetailField'));
    Vue.component('form-ck-editor', require('./components/FormField'));
})
