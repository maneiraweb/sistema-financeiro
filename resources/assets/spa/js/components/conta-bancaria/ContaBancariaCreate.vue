<template src="./_form.html"></template>

<script type="text/javascript">
    import {ContaBancaria} from '../../services/resources';
    import PageTitleComponent from '../PageTitle.vue';
    import 'materialize-autocomplete';
    import store from '../../store/store';

    export default {
        components: {
            'page-title': PageTitleComponent
        },
        data() {
            return {
                title: 'Nova conta bancária',
                contaBancaria: {
                    nome: '',
                    agencia: '',
                    conta: '',
                    banco_id: '',
                    'default': false,
                },
                banco: {
                    nome: ""
                }
            };
        },
        computed: {
            bancos() {
                return store.state.banco.bancos;
            }
        },
        created() {
            this.getBancos();
        },
        methods: {
            submit() {
                store.dispatch('contaBancaria/save', this.contaBancaria).then(() => {
                    Materialize.toast('Conta bancária criada com sucesso!', 4000);
                    this.$router.go({name: 'conta-bancaria.list'});
                });
            },
            getBancos() {
                store.dispatch('banco/query').then((response) => {
                    this.initAutocomplete();
                });
            },
            initAutocomplete() {
                let self = this;
                $(document).ready(() => {
                    $('#banco-id').one('focus', function () {
                        $(this).click();
                    });
                    $('#banco-id').materialize_autocomplete({
                        limit: 10,
                        multiple: {
                            enable: false
                        },
                        dropdown: {
                            el: '#banco-id-dropdown'
                        },
                        getData(value, callback) {
                            let mapBancos = store.getters['banco/mapBancos'];
                            let bancos = mapBancos(value);
                            callback(value, bancos);
                        },
                        onSelect(item) {
                            self.contaBancaria.banco_id = item.id;
                        }
                    });
                });
            }
        }
    };
</script>