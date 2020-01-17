/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/* global liveblock */

function getGetUrl(elem) {
    // url = window.location až k poslednímu lomítku + / + routa
    var location = window.location.toString();
    var route = 'api/v1/pribeh/' + elem.attr("data-id") + '/'
    var url = location.substr(0, location.lastIndexOf('/')+1) + route;
    return url;
}

$(document).ready(function () {

    liveblock.hookGetTemplateData();

//    $('#retrieve-pribeh').click(function () {
//        var displayElement = $('#display-pribeh');
//        displayElement.text('Loading data from JSON source...');
//        $.ajax({
//            type: "GET",
//            url: getGetUrl(displayElement),
////            url: "database/database.json",
//        })
//        .done(function(result, textStatus, jqXHR) {
//                console.log(result);
//                var html = liveblock.view(template.pribehTemplate, result);
//                console.log(html);
//                displayElement.html(html);
//                liveblock.hookPostActionToEditable();
//            })
//        .fail(function(jqXHR, textStatus, errorThrown){
//                alert( "Selhalo: " + errorThrown );
//                displayElement.text('Loading data from JSON source... FAILED!');
//            });
//    });

});

