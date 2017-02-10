<template src="./_form.html"></template>

<script type="text/javascript">
    import {ContaBancaria, Banco} from '../../services/resources';
    import PageTitleComponent from '../PageTitle.vue';
    import 'materialize-autocomplete';
    import _ from 'lodash';

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
                },
                bancos: []
            };
        },
        created() {
            this.getBancos();
            this.getContaBancaria(this.$route.params.id);
        },
        methods: {
            submit() {
                let id = this.$route.params.id
                ContaBancaria.update({id: id}, this.contaBancaria).then(() => {
                    Materialize.toast('Conta bancária atualizada com sucesso!', 4000);
                    this.$router.go({name: 'conta-bancaria.list'});
                })
            },
            getBancos() {
                Banco.query().then((response) => {
                    this.bancos = response.data.data;
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
                            let bancos = self.filterBancoPorNome(value);
                            bancos = bancos.map((o) => {
                                return {id: o.id, text: o.nome};
                            })
                            callback(value, bancos);
                        },
                        onSelect(item) {
                            self.contaBancaria.banco_id = item.id;
                        }
                    });
                });
            },
            filterBancoPorNome(nome) {
                let bancos = _.filter(this.bancos, (o) => {
                    return _.includes(o.nome.toLowerCase(), nome.toLowerCase());
                });
                return bancos;
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