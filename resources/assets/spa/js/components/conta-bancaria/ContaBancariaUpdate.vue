<template src="./_form.html"></template>

<script type="text/javascript">
    import {ContaBancaria, Banco} from '../../services/resources';
    import PageTitleComponent from '../PageTitle.vue';

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
                });
            },
            getContaBancaria(id){
                ContaBancaria.get({id: id}).then((response) => {
                    this.contaBancaria = response.data.data;
                })
            }
        }
    };
</script>