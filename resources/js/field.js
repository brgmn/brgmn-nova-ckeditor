import IndexField from './components/IndexField.vue';
import DetailField from './components/DetailField.vue';
import FormField from './components/FormField.vue';

Nova.booting((Vue, router, store) => {
    Vue.component('index-ckeditor', IndexField)
    Vue.component('detail-ckeditor', DetailField)
    Vue.component('form-ckeditor', FormField)
})