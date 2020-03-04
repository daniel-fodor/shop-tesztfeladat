var sizeSelect = document.getElementById("sizeSelect");
var colorSelect = document.getElementById("colorSelect");
var orderSelect = document.getElementById("orderSelect");

var stepButtons = document.querySelectorAll(".steps button");

/* filters */
sizeSelect.addEventListener("change", function(evt) {
    var selectedVal = evt.target.value;
    var selectPage = $(".counter").find('.current').text().trim();
    sentAjaxRequest(selectPage, selectedVal, "size");
});

colorSelect.addEventListener("change", function(evt) {
    var selectedVal = evt.target.value;
    var selectPage = $(".counter").find('.current').text().trim();
    sentAjaxRequest(selectPage, selectedVal, "color");
});

orderSelect.addEventListener("change", function(evt) {
    var selectedVal = evt.target.value;
    var selectPage = $(".counter").find('.current').text().trim();
    sentAjaxRequest(selectPage, selectedVal, "order");
});

/* pagination */
var buttonItems = [].slice.call(stepButtons);
buttonItems.forEach(function(item, idx) {
    item.addEventListener("click", function() {
        var dataVal = item.dataset.page;
        sentAjaxRequest(dataVal, selectedVal = null, "pagination");
    });
});

function sentAjaxRequest(pageVal, selectedVal, typeVal) {
    // filters
    var orderVal = $("#orderSelect").val();
    var sizeVal = $("#sizeSelect").val();
    var colorVal = $("#colorSelect").val();
    var page = 1;

    if (pageVal === "+1") {
        pageTxt =  $(".counter")
            .find(".current")
            .text()
            .trim();
        
        allItem = $(".counter")
        .find(".all")
        .text()
        .trim(); 
        page = parseInt(pageTxt) + 1;

        if (page > parseInt(allItem)) {
            page = parseInt(allItem);
        }
    }

    if (pageVal === "-1") {
        pageTxt =  $(".counter")
        .find(".current")
        .text()
        .trim();
        page = parseInt(pageTxt) - 1;

        if (page < 1) {
            page = 1;
        }
    }

    if (pageVal === "last") {
        page = $(".counter")
            .find(".all")
            .text()
            .trim();
    }

    if (pageVal === "first") {
        page = 1;
    }

    $.ajax({
        url: window.location.href + "/api/request.php",
        method: "POST",
        data: {
            orderVal: orderVal,
            sizeVal: sizeVal,
            colorVal: colorVal,
            page: page
        },
        success: function(result) {
            if (result) {
                $(".products__list").empty();
                $(".products__list").append(result.data);

                $(".counter")
                    .find(".current")
                    .html(page);

                var total = result.total;
                $('product-numbers').find('.value').text(total);
                total = Math.ceil(total / 8);
                $(".counter").find('.all').text(total);

            } else {
                $(".products__list").empty();
                $(".products__list").append("Nincs találat!");
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
}
