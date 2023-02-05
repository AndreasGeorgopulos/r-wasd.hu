import React from 'react';
import "./AddToCart.scss";

class AddToCart extends React.Component {
	constructor(props) {
		super(props)
		this.state = {
			csrf_token: props.csrf_token,
			amount: props.amount ? props.amount : 1,
			product_id: props.product_id,
			add_url: props.add_url,
		}
		this.addProduct = this.addProduct.bind(this)
		this.handleInputChange = this.handleInputChange.bind(this)
	}

	addProduct() {
		const url = this.state.add_url + '/' + this.state.product_id + '/' + this.state.amount
		fetch(url)
			.then(res => res.json())
			.then(
				(result) => {
					window.location.replace('/cart')
				},
				(error) => {
					this.setState({
						error: error
					});
				}
			)
	}

	handleInputChange = (event) => {
		this.setState({
			[event.target.name]: event.target.value
		});
	}

	render() {
		return (
			<form className="add-to-cart">
				<div className="input-div">
					<input type='number'
						   name='amount'
						   onChange={this.handleInputChange}
						   defaultValue={this.state.amount} />
				</div>
				<div className="button-div">
					<button type="button" className="btn" onClick={this.addProduct}>
						<i className="fa fa-cart-plus"></i>
					</button>
				</div>
			</form>
		);
	}
}

export default AddToCart