
/*var data = [
    { id: 1, firstname: 'My journey with Vue', surname: 'ererer'},
    { id: 2, firstname: 'Blogging with Vue', surname: 'ererer' },
    { id: 3, firstname: 'Why Vue is so fun', surname: 'ererer' }
];*/






var ContactList = (function() {
    var self = {};
    var data = [];


    self.loadData = function(){
        axios.get('/api/member')
            .then(function (response) {

      /*          response.data.data.each(function (item) {
                    console.log(item);
                });
*/
                console.log(response.data.data)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    }

    self.init = function () {
        new Vue({
            el: '#app',
            data: {
                items: data
            }
        });




        self.loadData();

    };
    return self;
})();


ContactList.init();