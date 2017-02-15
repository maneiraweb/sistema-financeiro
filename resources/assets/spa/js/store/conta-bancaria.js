import { ContaBancaria } from '../services/resources';
import SearchOptions from '../services/search-options';

const USER = 'user';

const state = {
    contasBancarias: [],
    contaBancariaDelete: null,
    searchOptions: new SearchOptions('banco')
};

const mutations = {
    set(state, contasBancarias) {
        state.contasBancarias = contasBancarias;
    },
    setDelete(state, contaBancariaDelete) {
        state.contaBancariaDelete = contaBancariaDelete;
    },
    'delete'(state) {
        state.contasBancarias.$remove(state.contaBancariaDelete);
    },
    setOrder(state, key) {
        state.searchOptions.order.key = key;
        let sort = state.searchOptions.order.sort;
        state.searchOptions.order.sort = sort == 'desc' ? 'asc' : 'desc';
    },
    setPagination(state, pagination) {
        state.searchOptions.pagination = pagination;
    },
    setCurrentPage(state, current_page) {
        state.searchOptions.pagination.current_page = current_page;
    },
    setFilter(state, filter) {
        state.searchOptions.search = filter;
    }
};

const actions = {
    query(context) {
        let searchOptions = context.state.searchOptions;
        return ContaBancaria.query(searchOptions.createOptions()).then((response) => {
            context.commit('set', response.data.data);
            context.commit('setPagination', response.data.meta.pagination);
        });
    },
    queryWithSortBy(context, key) {
        context.commit('setOrder', key);
        context.dispatch('query');
    },
    queryWithPagination(context, currentPage) {
        context.commit('setCurrentPage', currentPage);
        context.dispatch('query');
    },
    queryWithFilter(context, filter) {
        context.dispatch('query');
    }
};

const module = {
    state, mutations, actions
}
export default module;