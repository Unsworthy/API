import { useState, useEffect } from "react";

const Home = () => {
    const [data, setData] = useState([]);

    useEffect(() => {
        fetch("api/product", {
            headers: {
                Accept: "Application/json",
            },
        })
            .then((res) => res.json())
            .then((response) => setData(response?.data))
            .catch((error) => console.log(`Apabila GAGAL : ${error}`));
    }, []);

    return (
        <div className="container m-4">
            {data?.length === 0 ? (
                <h1 className="text-center">Loading..</h1>
            ) : (
                <div className="row">
                    {data.map((dt, idx) => (
                        <div className="col-lg-4 col-md-6 col-sm-12" key={idx}>
                            <div
                                className="card bg-light"
                                style={{ width: "18rem" }}
                            >
                                <img
                                    src={dt?.product_image}
                                    className="card-img-top"
                                    alt="product image"
                                />
                                <div className="card-body">
                                    <h5 className="card-title">
                                        {dt?.product_name}
                                    </h5>
                                    <h5 className="card-title">
                                        {dt?.product_type}
                                    </h5>
                                    <h6 className="card-title">
                                        Price: {dt?.price}
                                    </h6>
                                    <p className="card-text">
                                        {dt?.description}
                                    </p>
                                    <p className="card-text">
                                        Stock: {dt?.stock}
                                    </p>
                                    <button
                                        type="button"
                                        className="btn btn-success"
                                        // onClick={() => {
                                        //     dispatch(addToCartProduct(dt));
                                        //     dispatch(addToCart(dt));
                                        // }}
                                    >
                                        Add To Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default Home;
