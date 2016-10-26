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
		},

		formatPrice(price){
			return number_format(price, 0, '.', ' ');
		}
	}
});

function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '')
		.replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		toFixedFix = function(n, prec) {
			var k = Math.pow(10, prec);
			return '' + (Math.round(n * k) / k)
					.toFixed(prec);
		};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
		.split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '')
			.length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1)
			.join('0');
	}
	return s.join(dec);
}