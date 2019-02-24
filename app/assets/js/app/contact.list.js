Vue.filter('numberPhone', function (number) {
    var result = number;

    if (number.length == 11) {
        if (number[0] == 7) {
            result = '+7(' + number.slice(1, 4) + ') ' + number.slice(4, 7) + '-' + number.slice(7, 9) + '-' + number.slice(9, 11);
        }
        if (number[0] == 8) {
            result = '8(' + number.slice(1, 4) + ') ' + number.slice(4, 7) + '-' + number.slice(7, 9) + '-' + number.slice(9, 11);
        }
    }
    return result;
});

new Vue({
    el: '#app',
    data: function () {
        return {
            loaderHide: false,
            message: null,
            error: null,
            form: {
                id: '',
                firstname: '',
                surname: '',
                newRecord: true
            },
            modelPhone: {
                number: null,
                memberId: null
            },
            items: [],
            search: [],
            formComponent: true,
            activeComponent: 'tableComponent'
        }
    },
    computed: {
        contactFilter: function () {
            // return this.items;
            var q = this.search;

            console.log(q);
            return this.items.filter(function (item) {
                return item.firstname.includes(q) || item.surname.includes(q);
            })
            //return this.findBy(this.items, this.query)
        }
    },

    methods: {
        setMessage(message) {
            var self = this;
            self.message = message;
            setTimeout(function () {
                self.message = null;
            }, 5000)
        },
        setError(message) {
            var self = this;
            self.error = message;
            setTimeout(function () {
                self.error = null;
            }, 5000)
        },
        loadData() {
            var self = this;
            return axios.get('/api/member')
                .then(function (response) {
                    self.items = response.data.data;
                    console.log(response.data.data);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });

        },
        contactDelete: function (id, event) {
            var self = this;
            return axios.delete('/api/member/' + id)
                .then(function (response) {
                    self.loadData();
                    self.setMessage('Контакт удален!');
                })
                .catch(function (error) {
                })
        },
        cancelContact: function () {
            this.activeComponent = 'tableComponent';
        },
        newPhone: function (i) {
            var self = this;
            self.modelPhone.number = null;
            self.modelPhone.editMode = true;
            self.modelPhone.memberId = self.items[i].id;
        },
        deletePhone(id) {
            var self = this;
            return axios.delete('/api/member/phone/' + id)
                .then(function (response) {
                    self.loadData();
                    self.setMessage('Телефон удален!');
                })
                .catch(function (error) {
                    self.setError(error.response.data.message);
                })
        },
        newPhoneSend: function () {
            var self = this;

            if (self.modelPhone.number === null || self.modelPhone.number.length == 0) {
                self.modelPhone.memberId = null;
            } else if (self.modelPhone.number.length < 5) {
                self.setError('Телефон слишком короткий')
            } else {
                const params = new URLSearchParams();
                params.append('phone', self.modelPhone.number);

                return axios.post('/api/member/' + self.modelPhone.memberId + '/phone', params)
                    .then(function (response) {
                        self.loadData();
                        self.modelPhone.memberId = null;
                        self.setMessage('Телефон добавлен!');
                    })
                    .catch(function (error) {
                        self.setError(error.response.data.message);
                    });
            }


        },
        newContact: function () {
            this.activeComponent = 'formComponent';
            this.form.id = '';
            this.form.firstname = '';
            this.form.surname = '';
            this.form.newRecord = true;
        },
        editContact: function (index) {
            this.activeComponent = 'formComponent';
            this.form.id = this.items[index].id;
            this.form.firstname = this.items[index].firstname;
            this.form.surname = this.items[index].surname;
            this.form.newRecord = false;
        },
        editContactSend: function () {
            var self = this;
            const params = new URLSearchParams();
            params.append('firstname', this.form.firstname);
            params.append('surname', this.form.surname);

            if (self.form.newRecord === true) {
                var url = '/api/member';
            } else {
                var url = '/api/member/' + this.form.id;
            }

            return axios({
                method: 'post',
                url: url,
                data: params
            })
                .then(function (response) {
                    self.loadData().then(function () {
                        self.activeComponent = 'tableComponent';
                        self.setMessage('Контакт обновлен!');
                    });
                })
                .catch(function (error) {
                    self.setError(error.response.data.message);
                });
        },
    },

    mounted: function () {
        this.loadData();
        this.loaderHide = true;
    }

});


function formatPhone(phone) {
    return '99';
}