const stripe = Stripe('pk_test_51RM2F0Rpytf03PxV4G40aHMOrMVnTBFuOYR9c9NUu7UGOoe9PICGd8vxDrZM1UA5M2oNO022LnHgpyUxoygJvNMv00TvUpu8to');

initialize();

// Create a Checkout Session
async function initialize() {
    const fetchClientSecret = async () => {
        const response = await fetch("/checkoutprocess", {
            method: "POST",
        });
        const { clientSecret } = await response.json();
        return clientSecret;
    };

    const checkout = await stripe.initEmbeddedCheckout({
        fetchClientSecret,
    });

    // Mount Checkout
    checkout.mount('#checkout');
}
