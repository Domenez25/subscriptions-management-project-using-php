function sortTable(column) {
    const urlParams = new URLSearchParams(window.location.search);
    const currentSortColumn = urlParams.get('sortColumn');
    const currentSortOrder = urlParams.get('sortOrder');
    const currentContent = urlParams.get('content');

    let newSortOrder = 'asc';
    if (column === currentSortColumn && currentSortOrder === 'asc') {
        newSortOrder = 'desc';
    }

    const newUrlParams = new URLSearchParams();
    newUrlParams.set('content', currentContent);
    newUrlParams.set('sortColumn', column);
    newUrlParams.set('sortOrder', newSortOrder);

    window.location.href = '?' + newUrlParams.toString();
}


// function toggleDurationRadios(isWeekly) {
//     var durationRadios = document.getElementsByName("duration");

//     for (var i = 0; i < durationRadios.length; i++) {
//         durationRadios[i].disabled = isWeekly;
//     }
// }

function calculateTotalPrice() {
    var subscriptionType = document.querySelector('input[name="subscriptionType"]:checked').value;
    var duration = document.querySelector('input[name="duration"]:checked').value;

    var name = "promo=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(';');

    cookieExist = false;
    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i].trim();
        if (cookie.indexOf(name) === 0) {
            promo = parseInt(cookie.substring(name.length, cookie.length));
            cookieExist = true;
        }
    }
    
    var totalPrice = calculatePrice(subscriptionType, duration);
    var totalPriceContainer = document.getElementById("totalPrice");

    if(cookieExist) {
        newPrice = totalPrice * promo / 100;
        totalPriceContainer.innerHTML = "Total Price: <s>$" + totalPrice.toFixed(2) + "</s> <b>$" + newPrice.toFixed(2) + "</b> with promo of " + promo + "%";
    } else {
    totalPriceContainer.innerHTML = "Total Price: $" + totalPrice.toFixed(2);
    }
}

function calculatePrice(subscriptionType, duration) {
    
    
    var prices = {
        
        "weekly": {
            "weekly": 400,
            "month": 400,
            "trimester": 400,
            "year": 400
        },

        "employer": {
            "month": 1000,
            "trimester": 2500,
            "year": 10000
        },

        "student": {
            "month": 600,
            "trimester": 2000,
            "year": 6000
        },

        "scholar": {
            "month": 400,
            "trimester": 1000,
            "year": 4000
        },

        "retired": {
            "month": 1000,
            "trimester": 2500,
            "year": 10000
        },

        "other": {
            "month": 1200,
            "trimester": 3200,
            "year": 12000
        },

        "multimodal": {
            "month": 1500,
            "trimester": 4000,
            "year": 15000
        },

        "special": {
            "month": 500,
            "trimester": 1200,
            "year": 5000
        },
        
    };

    return prices[subscriptionType][duration];
}

function toggleDurationRadios(enable) {
    
    
    var durationRadios = document.querySelectorAll('input[name="duration"]');
    durationRadios.forEach(function (radio) {
        radio.disabled = enable;
    });

    
    calculateTotalPrice();
}