
var data = [
    { id: 1, firstname: 'My journey with Vue', surname: 'ererer'},
    { id: 2, firstname: 'Blogging with Vue', surname: 'ererer' },
    { id: 3, firstname: 'Why Vue is so fun', surname: 'ererer' }
];

setTimeout(function () {
    data.push({id:4, firstname: "Кролик", surname: "белый"});
},1000)

new Vue({
    el: '#app',
    data: {
        items: data
    }
});


var ContactList = (function() {

})();


