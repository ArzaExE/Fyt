initialize();

async function initialize() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const sessionId = urlParams.get('session_id');
    const response = await fetch("/return", {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        method: "POST",
        body: JSON.stringify({ session_id: sessionId }),
    });
    const session = await response.json();

    if (session.status == 'complete') {
        document.getElementById('total').innerHTML = ` ${session.amount_total/100} €`;
        //document.getElementById('order_id').innerHTML = ` #${session.order_id}`;

    }
}
