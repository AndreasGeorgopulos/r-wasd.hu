import React from 'react';
import "./Cart.scss";
import AddToCart from "./AddToCart";

class Cart extends React.Component {
	constructor(props) {
		super(props)
		this.state = {
			loadUrl: props.load_url,
			setUrl: props.set_url,
		}
		this.load = this.load.bind(this)
		this.remove = this.remove.bind(this)
	}

	componentDidMount() {
		this.load()
	}

	load() {
		fetch(this.state.loadUrl)
			.then(res => res.json())
			.then(
				(result) => {
					console.log(result)
					this.setState({
						data: result
					})
				},
				(error) => {
					this.setState({
						error: error
					});
				}
			)
	}

	remove(product_id) {
		if (!confirm('Are you sure remove this product from cart?')) {
			return;
		}

		this.setState({
			data: null,
		});

		fetch(this.state.setUrl + '/' + product_id)
			.then(res => res.json())
			.then(
				(result) => {
					this.load()
				},
				(error) => {
					this.setState({
						error: error
					});
				}
			)
	}

	render() {
		if (!this.state.data) {
			return (
				<div className="text-center pt-3 pb-3">Loading cart...</div>
			);
		} else if (!this.state.data.cart_item_count) {
			return (
				<div className="text-center pt-3 pb-3">No cart items</div>
			);
		}

		const cart_items = this.state.data.cart_items;

		return (
			<div className="cart pt-3 pb-3">
				<div className="row">
					<div className="col-sm-5 p-2 color-orange">Product</div>
					<div className="col-sm-2 p-2 color-orange">Unit price</div>
					<div className="col-sm-2 p-2 color-orange">Amount</div>
					<div className="col-sm-2 p-2 color-orange">Price</div>
					<div className="col-sm-1 p-2 color-orange"></div>
				</div>
				{cart_items.map((item, index) => (
					<div key={index++} className="row">
						<div className="col-sm-5 p-2 color-gray">
							<a href={item.product.url}>{item.product.name}</a>
						</div>
						<div className="col-sm-2 p-2 color-gray">{item.product.price_formated}</div>
						<div className="col-sm-2 p-2 color-gray">{item.amount}</div>
						<div className="col-sm-2 p-2 color-gray">{item.total_formated}</div>
						<div className="col-sm-1 p-2">
							<button type="button" className="btn btn-danger btn-sm" data-product-id={item.product_id} onClick={() => this.remove(item.product_id)}>
								<i className="fa fa-minus"></i>
							</button>
						</div>
					</div>
				))}
				<div className="row">
					<div className="col-sm-9 p-2 color-orange"></div>
					<div className="col-sm-2 p-2 color-blue">{this.state.data.total_formated}</div>
					<div className="col-sm-1 p-2 color-orange"></div>
				</div>
			</div>
		)
	}
}

export default Cart