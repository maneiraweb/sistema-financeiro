import { Banco } from '../services/resources';
import _ from 'lodash';

const USER = 'user';

const state = {
    bancos: [],
};

const mutations = {
    set(state, bancos) {
        state.bancos = bancos;
    }
};

const actions = {
    query(context) {
        return Banco.query().then((response) => {
            context.commit('set', response.data.data);
        });
    }
};

const getters = {
    filterBancoPorNome: (state) => (name) => {
        let bancos = _.filter(state.bancos, (o) => {
            return _.includes(o.nome.toLowerCase(), name.toLowerCase());
        });
        return bancos;
    },
    mapBancos(state, getters) {
        return (name) => {
            let bancos = getters.filterBancoPorNome(name);
            return bancos.map((o) => {
                return { id: o.id, text: o.nome };
            });
        }
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