<templatesrc="../_form.html"></template>

<script type="text/javascript">
    import billBayMixin from '../../../mixins/bill-mixin';

    export default {
        mixins: [billBayMixin],
        methods: {
            namespace() {
                return 'billPay';
            },
            title() {
                return 'Novo pagamento';
            }
        }
    }
</script>