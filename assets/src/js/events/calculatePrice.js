export default function calculatePrice() {
    document.endPrice = 0;
    document.querySelectorAll(".em-ticket").forEach(function(ticket) {
        var price = ticket.querySelector(".em-bookings-ticket-table-price").innerText;
        price = price.trim().replace(/[^0-9]/g, '').replace(/(\d{2})$/, '.$1');
        price = parseFloat(price);
        var multiplicator = Number(ticket.querySelector(".em-ticket-select").value);
        var ticketPrice = (price * multiplicator);
        document.endPrice += ticketPrice;
    });
    
    var currency = lang == "de-CH" ?  "CHF" : "EUR";
    document.querySelector("#price").innerText = Intl.NumberFormat(lang, { style: 'currency', currency: currency }).format(document.endPrice);
}