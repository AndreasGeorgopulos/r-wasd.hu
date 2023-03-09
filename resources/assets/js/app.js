window.$ = window.jQuery = require('jquery');
require('bootstrap');

require('cookieconsent/build/cookieconsent.min');
require('./link_to_top');

//require('recaptcha');

/*require('select2');
$('.select2').select2();*/

import { render } from "react-dom";

const loadComponent = (componentId, elementId) => {
	const element = document.getElementById(elementId)
	if (element !== null) {
		render(componentId, element)
	}
}

import AddToCart from "./components/Cart/AddToCart"
(function () {
	const element = document.getElementById('add-to-cart')
	if (!element) {
		return;
	}
	const product_id = element.getAttribute('data-product-id')
	const csrf_token = element.getAttribute('data-csrf-token')
	const add_url = element.getAttribute('data-add-url')
	loadComponent(<AddToCart product_id={product_id} csrf_token={csrf_token} add_url={add_url} />, 'add-to-cart')
})()

import Cart from "./components/Cart/Cart"
(function () {
	const element = document.getElementById('cart-page')
	if (!element) {
		return;
	}

	const load_url = element.getAttribute('data-load-url')
	const set_url = element.getAttribute('data-set-url')
	loadComponent(<Cart load_url={load_url} set_url={set_url} />, 'cart-page')
})()