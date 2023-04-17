(function () {
	const selector = '.container.cart.checkout';

	if (!$(selector).length) {
		return;
	}

	const Checkout = {
		area: null,
		select_country: null,

		init: function () {
			this.area = $(selector);
			this.select_country = this.area.find('select[name="shipping_country_id"]');
			this.eventHandlers();
		},

		eventHandlers: function () {
			const $this = this;
			$this.select_country.off('change');
			$this.select_country.on('change', function (e) {
				$this.getPostalFee($(this).val());
			});
		},

		getPostalFee: function (countryID) {
			const url = '/order/get_postal_fee/' + countryID;

			$('#payment-postal-fee').html('');
			$('#payment-total').html('');
			$.get(url, function (response) {
				$('#payment-postal-fee').html(response.fee_formated);
				$('#payment-total').html(response.total_formated);
			});
		}
	};

	Checkout.init();
})()