function verify() {
    let datenow = new Date(Date.now())
    let datereservation = new Date($("#form-res-date-field").val().slice(0, -3) + ":00")
    let reservationday = datereservation.toLocaleString('en-US', {weekday: 'short'})
    let datemax = addDaysToDate(datenow, 60)
    console.log ("reservationDay : ", reservationday);

    if (datereservation < datenow) {
        document.getElementById("slots").innerHTML = 'La réservation ne peut-être antérieur à la date du jour';
    } else if (datereservation > datemax) {
        document.getElementById("slots").innerHTML = 'Vous ne pouvez pas réserver au dela de 60 Jours à l\'avance';
    } else {
        ajaxGetReservationSlots();
    }
}

function addDaysToDate(date, days) {
    var res = new Date(date);
    res.setDate(res.getDate() + days);
    return res;
}

function ajaxGetReservationSlots () {
    let datereservation = $("#form-res-date-field").val().slice(0, -3) + ":00"
    console.log ("datereservation : ", datereservation);

    $.ajax({
        url: "/a/reservation_slots",
        method: "POST",
        data: JSON.stringify({bookingDate: datereservation}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
    })
        .done(function(data) {
       $("#slots") .text(data['slots']);
        console.log("data : ", data);
    });

}

if (window.location.href.indexOf("/reservation") > -1) {
    verify();

    $("#form-res-date-field").change(function() {
        verify();
    })
}




