import { ContaBancaria } from '../services/resources';
import SearchOptions from '../services/search-options';
import _ from 'lodash';

const USER = 'user';

const state = {
    contasBancarias: [],
    lists: [],
    contaBancariaDelete: null,
    searchOptions: new SearchOptions('banco')
};

const mutations = {
    set(state, contasBancarias) {
        state.contasBancarias = contasBancarias;
    },
    setLists(state, lists) {
        state.lists = lists;
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
    lists(context) {
        return ContaBancaria.lists().then(response => {
            context.commit('setLists', response.data);
        });
    },
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
    },
    'delete'(context) {
        let id = context.state.contaBancariaDelete.id;
        return ContaBancaria.delete({ id: id }).then((response) => {
            context.commit('delete');
            context.commit('setDelete', null);

            let contasBancarias = context.state.contasBancarias;
            let pagination = context.state.searchOptions.pagination;
            if (contasBancarias.length === 0 && pagination.current_page > 0) {
                context.commit('setCurrentPage', pagination.current_page--);
            }
            return response;
        });
    },
    save(context, contaBancaria) {
        return ContaBancaria.save({}, contaBancaria).then((response) => {
            return response;
        })
    },
};

const getters = {
    filterBankAccountByName: (state) => (name) => {
        let bankAccounts = _.filter(state.lists, (o) => {
            return _.includes(o.nome.toLowerCase(), name.toLowerCase());
        });
        return bankAccounts;
    },
    mapBankAccounts(state, getters) {
        return (name) => {
            let bankAccounts = getters.filterBankAccountByName(name);
            return bankAccounts.map((o) => {
                return { id: o.id, text: getters.textAutoComplete(o) };
            });
        }
    },
    textAutoComplete: (state) => (bankAccount) => {
        return `${bankAccount.nome} - ${bankAccount.conta}`;
    }
};

const module = {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}
export default module;