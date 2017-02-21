import PageTitleComponent from '../components/PageTitle.vue'
import ModalComponent from '../../../_default/components/Modal.vue';
import store from '../store/store';

export default {
    components: {
        'modal': ModalComponent,
        'page-title': PageTitleComponent
    },
    props:{
        index: {
            type: Number,
            required: false,
            'default': -1
        },
        modalOptions: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            bill: {
                id: 0,
                date_due: '',
                name: '',
                value: '',
                done: false
            }
        };
    },
    computed: {
        //Opções para o campo select2 de Categoria Pai
        cpOptions() {
            return {
                data: this.categoriesFormatted,
                templateResult(category) {
                    let margin = '&nbsp;'.repeat(category.level * 8);
                    let text = category.hasChildren ? `<strong>${category.text}</strong>` : category.text;
                    return `${margin}${text}`;
                },
                escapeMarkup(m) {
                    return m;
                }
            }
        },
        categories() {
            return store.state[this.namespace()].categories;
        },
        categoriesFormatted() {
            return store.getters[`${this.namespace()}/categoriesFormatted`];
        },
        categoryDelete() {
            return store.state[this.namespace()].category;
        },
        modalOptionsSave() {
            return { id: `modal-category-save-${this._uid}` };
        },
        modalOptionsDelete() {
            return { id: `modal-category-delete-${this._uid}` };
        },
    },
    created() {
        store.dispatch(`${this.namespace()}/query`);
    },
    methods: {
        doneId() {
            return `done-${this._uid}`;
        },
        submit() {
            if(this.bill.id !== 0) {
                store.dispatch(`${this.namespace()}/edit`, {
                   bill: this.bill,
                   index: thid.index 
                }).then(() => {
                    Materialize.toast('Conta atualizada com sucesso!', 4000);
                    this.resetScope();
                });
            } else {
                store.dispatch(`${this.namespace()}/save`, this.bill).then(() => {
                    Materialize.toast('Conta criada com sucesso!', 4000);
                    this.resetScope();
                });
            }
        },
        resetScope() {
            this.bill = {
                id: 0,
                date_due: '',
                name: '',
                value: '',
                done: false
            };
        }
    }
}