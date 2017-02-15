import Vuex from 'vuex';
import auth from './auth';
import contaBancaria from './conta-bancaria';

export default new Vuex.Store({
    modules: {
        auth,
        contaBancaria
    }
});