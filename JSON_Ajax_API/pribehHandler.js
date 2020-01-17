/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

function getUrl(elem) {
    // url = window.location až k poslednímu lomítku + / + routa
    var location = window.location.toString();
    var parent = elem.parentNode;
    var route = 'api/v1/' + parent.getAttribute("data-id") + '/' + elem.getAttribute("data-name") + '/'
    return location.substr(0, location.lastIndexOf('/')+1) + route;
}

function hookPostActionToEditable() {
    var list = document.getElementsByClassName("editable");
    for (var i = 0; i < list.length; i++) {
        elem = list[i];

        elem.onclick = function (event) {
    //            event.preventDefault();
        };

        elem.ondblclick = function (e) {
        };

        elem.onmouseout = function (event) {
            var targetElement = event.target;
            var data = {};
            data['html'] = targetElement.innerHTML;
            $.ajax({
                type: "POST",
                data: data,
                url: getUrl(targetElement),
            })
            .done(function(requestResult, textStatus, jqXHR) {
                    console.log(requestResult);
                    displayResources.html(view(requestResult));
                    $("table").addClass("table").attr("contenteditable", true);
                })
            .fail(function(jqXHR, textStatus, errorThrown){
                    alert( "Selhalo odeslání: " + errorThrown );
    //                displayResources.text('Loading data from JSON source... FAILED!');
                });
        };

//        list[i].addEventListener("mousedown", logEvent);
//        list[i].addEventListener("mouseup", logEvent);
//        list[i].addEventListener("click", logEvent);
//        list[i].addEventListener("mouseenter", logEvent);
//        list[i].addEventListener("mouseleave", logEvent);


    }
}

$(document).ready(function () {

    $('#retrieve-pribeh').click(function () {
        var displayPribeh = $('#display-pribeh');
        displayPribeh.text('Loading data from JSON source...');
        $.ajax({
            type: "GET",
            url: "database/database.json",
        })
        .done(function(result, textStatus, jqXHR) {
                console.log(result);
                console.log(view(template.pribehTemplate, result));
                displayPribeh.html(view(template.pribehTemplate, result));
                $("editable").addClass("table").attr("contenteditable", true);
                hookPostActionToEditable();
            })
        .fail(function(jqXHR, textStatus, errorThrown){
                alert( "Selhalo: " + errorThrown );
                displayPribeh.text('Loading data from JSON source... FAILED!');
            });
    });

});

