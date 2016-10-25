var CarsManager = new Vue({
	el: '#cars',

	mounted: function() {
		this.cars.push({
			brand: 'bmw',
			model: 'X6',
			config: '',
			power: 200,
			color: 'red',
			image: 'bmw.jpg',
			price: 4000000,
		})
	},

	data: {
		cars: []
	}
});