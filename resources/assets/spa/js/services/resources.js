export class Jwt{
    static accessToken(email, password) {
        return Vue.http.post('access_token', {
            email: email,
            password: password
        });
    }

    static logout() {
        return Vue.http.post('logout');
    }

    static refreshToken() {
        return Vue.http.post('refresh_token');
    }
}

let User = Vue.resource('user');
let ContaBancaria = Vue.resource('contas_bancarias{/id}', {}, {
    lists: {method: 'GET', url: 'contas_bancarias/lists'}
});
let Banco = Vue.resource('bancos');
let CategoryRevenue = Vue.resource('category_revenues{/id}');
let CategoryExpense = Vue.resource('category_expenses{/id}');
let BillPay = Vue.resource('bill_pays{/id}');

export {User, ContaBancaria, Banco, CategoryRevenue, CategoryExpense, BillPay};