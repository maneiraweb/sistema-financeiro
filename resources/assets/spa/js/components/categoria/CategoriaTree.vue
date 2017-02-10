<template>
    <ul class="categoria-tree">
        <li v-for="(index, o) in categorias" class="categoria-child">
            <div class="valign-wrapper">
                <a :data-activates="dropdownId(o)" href="#" class="categoria-symbol" 
                :class="{'green-text': o.children.data.length > 0, 'grey-text': !o.children.data.length}">
                    <i class="material-icons">{{ categoriaIcon(o) }}</i>
                </a>
                <ul :id="dropdownId(o)" class="dropdown-content">
                    <li>
                        <a href="#" @click.prevent="categoriaNew(o)">Adicionar</a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="categoriaEdit(o)">Editar</a>
                    </li>
                    <li>
                        <a href="#">Excluir</a>
                    </li>
                </ul>
                <span class="valign">{{{ categoriaText(o) }}}</span>
            </div>
            <categoria-tree :categorias="o.children.data"></categoria-tree>
        </li>
    </ul>
</template>

<script type="text/javascript">

    export default {
        name: 'categoria-tree',
        props: {
            categorias: {
                type: Array,
                required: true
            }
        },
        watch: {
            categorias: {
                handler(categorias){
                    $('.categoria-child > div > a').dropdown({
                        hover: true,
                        inDuration: 300,
                        outDuration: 400,
                        belowOrigin: true
                    });
                },
                deep: true
            }
        },
        methods: {
            dropdownId(categoria) {
                return `categoria-tree-dropdown-${categoria.id}`;
            },
            categoriaText(categoria) {
                return categoria.children.data.length > 0 ? `<strong>${categoria.nome}</strong>` : categoria.nome;
            },
            categoriaIcon(categoria) {
                return categoria.children.data.length > 0 ? 'folder' : 'label';
            },
            categoriaNew(categoria) {
                this.$dispatch('categoria-new', categoria);
            }, 
            categoriaEdit(categoria) {
                this.$dispatch('categoria-edit', categoria);
            }
        }
    }
</script>