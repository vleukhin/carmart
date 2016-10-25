var CarsManager = new Vue({
	el: '#cars',

	mounted: function() {
		this.$http.get('/cars/list').then(function (response) {
			this.cars = response.data.cars;
		},
		function () {
			alert('Ну удалось загрузить список автомобилей.');
		})
	},

	data: {
		cars: []
	}
});