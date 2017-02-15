<template src="./_form.html"></template>

<script type="text/javascript">
    import {ContaBancaria, Banco} from '../../services/resources';
    import PageTitleComponent from '../PageTitle.vue';
    import 'materialize-autocomplete';
    import store from '../../store/store';

    export default {
        components: {
            'page-title': PageTitleComponent
        },
        data() {
            return {
                title: 'Edição de conta bancária',
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
            this.getContaBancaria(this.$route.params.id);
        },
        methods: {
            submit() {
                let id = this.$route.params.id;
                ContaBancaria.update({id: id}, this.contaBancaria).then(() => {
                    Materialize.toast('Conta bancária atualizada com sucesso!', 4000);
                    this.$router.go({name: 'conta-bancaria.list'});
                })
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
            },
            getContaBancaria(id){
                ContaBancaria.get({
                    id: id,
                    include: 'banco'
                }).then((response) => {
                    this.contaBancaria = response.data.data;
                    this.banco = response.data.data.banco.data;
                })
            }
        }
    };
</script>