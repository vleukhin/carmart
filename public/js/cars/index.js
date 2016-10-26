var CarsManager = new Vue({
	el: '#cars',

	mounted: function() {
		this.$http.get('/cars/list').then(function (response) {
			if (response.data.success){
				this.cars = response.data.cars;
			}
			else{
				swal({
						title: 'Список авто не найден',
						text: 'Сгенерировать новый список?',
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#47a528',
						confirmButtonText: 'Сгенерировать',
						cancelButtonText: 'Отмена',
						closeOnConfirm: false,
						closeOnCancel: false
					},
					function(isConfirm){
						if (isConfirm) {
							CarsManager.generateList();
						}
						else{
							swal.close();
						}
					});
			}
		},
		function () {
			swal('Ошибка', 'Ну удалось загрузить список автомобилей.', 'error');
		})
	},

	data: {
		cars: []
	},
	
	methods: {
		generateList: function () {
			this.$http.post('cars/generate').then(function (response) {
				this.cars = response.data.cars;
				swal('Успешно!', 'Список авто сгенерирован!', 'success')
			},
			function () {
				swal('Ошибка', 'Ну удалось сгенерировать список автомобилей.', 'error');
			})
		}
	}
});