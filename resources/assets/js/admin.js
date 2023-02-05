require('./components/listTable.js');
const tinymce = require("tinymce");

import { render } from "react-dom";

const loadComponent = (componentId, elementId) => {
	const element = document.getElementById(elementId)
	if (element !== null) {
		render(componentId, element)
	}
}

/*import ImageUploadPreviewComponent from "./components/ImageUploader/ImageUploadPreviewComponent"
(function () {
	const element = document.getElementById('product_image_area')
	if (!element) {
		return;
	}
	loadComponent(<ImageUploadPreviewComponent />, 'product_image_area')
})()*/

/*
tinymce.init({
	selector:'textarea.tinymce',
	width: 900,
	height: 300
});*/
