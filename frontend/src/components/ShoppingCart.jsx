
import Product from './Product';

const ShoppingCart = ({ products }) => {
  return (
    <div>
      {products.length > 0 ? (
        products.map((product) => (
          <div key={product.id} className="product-grid-item">
            <Product product={product} />
          </div>
        ))
      ) : (
        <p>Your shopping cart is empty. There are no products in your shopping cart.</p>
      )}
    </div>
  );
};

export default ShoppingCart;
