import PageTitleComponent from '../components/PageTitle.vue'
import ModalComponent from '../../../_default/components/Modal.vue';
import SelectMaterialComponent from '../../../_default/components/SelectMaterial.vue';
import store from '../store/store';

export default {
    components: {
        'modal': ModalComponent,
        'select-material': SelectMaterialComponent,
        'page-title': PageTitleComponent
    },
    props: {
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
                value: 0,
                done: false,
                bank_account_id: 0,
                category_id: 0
            }
        };
    },
    computed: {
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
        bankAccounts() {
            return store.state.contaBancaria.lists;
        },
        categoriesFormatted() {
            return store.getters[`${this.categoryNamespace()}/categoriesFormatted`];
        }
    },
    watch: {
        bankAccounts(bankAccounts) {
            if(bankAccounts.length > 0) {
                this.initAutocomplete();
            }
        }
    },
    methods: {
        doneId() {
            return `done-${this._uid}`;
        },
        bankAccountTextId() {
            return `bank-account-text-${this._uid}`;
        },
        bankAccountDropdownId() {
            return `bank-account-dropdown-${this._uid}`;
        },
        initAutocomplete() {
            let self = this;
            $(`#${this.bankAccountTextId()}`).one('focus', function () {
                $(this).click();
            });
            $(`#${this.bankAccountTextId()}`).materialize_autocomplete({
                limit: 10,
                multiple: {
                    enable: false
                },
                dropdown: {
                    el: `#${this.bankAccountDropdownId()}`
                },
                getData(value, callback) {
                    let mapBankAccounts = store.getters['contaBancaria/mapBankAccounts'];
                    let bankAccounts = mapBankAccounts(value);
                    callback(value, bankAccounts);
                },
                onSelect(item) {
                    self.bill.bank_account_id = item.id;
                }
            });
        },
        submit() {
            if (this.bill.id !== 0) {
                store.dispatch(`${this.namespace()}/edit`, {
                    bill: this.bill,
                    index: this.index
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
                value: 0,
                done: false,
                bank_account_id: 0,
                category_id: 0
            };
        }
    }
}