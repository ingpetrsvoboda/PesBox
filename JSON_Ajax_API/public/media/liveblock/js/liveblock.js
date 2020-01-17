/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/*
 * https://addyosmani.com/blog/essential-js-namespacing/
 */


/* global template */

var correspondent =  correspondent || {};

// perform a similar existence check when defining nested
// children
correspondent.ajax = correspondent.ajax || {};

var namespace = (function () {

    // defined within the local scope
    var privateMethod1 = function () { /* ... */ };
    var privateMethod2 = function () { /* ... */ };
    var privateProperty1 = 'foobar';

    return {
        // the object literal returned here can have as many
        // nested depths as you wish, however as mentioned,
        // this way of doing things works best for smaller,
        // limited-scope applications in my personal opinion
        publicMethod1: privateMethod1,

        //nested namespace with public properties
        properties:{
            publicProperty1: privateProperty1
        },

        //another tested namespace
        utils:{
            publicMethod2: privateMethod2
        }

    };
})();

var liveblock = (function () {
    // defined within the local scope
    var attributes = function attributes(attrJson) {
            var attrString = "";
            var keys = Object.keys(attrJson);
            for(var i=0;i<keys.length;i++){
                    var key = keys[i];
                    attrString += ' ' + key + '= "' + attrJson[key] + '"';
                }
            return attrString;
        };

    var view = function view(template, result) {
            return template(result);
        };

    var getGetUrl = function getGetUrl(elem) {
            // url = window.location až k poslednímu lomítku + / + routa
            var location = window.location.toString();
            var parent = elem.parentNode;
            var route = 'api/v1/pribeh/' + elem.getAttribute("data-name") + '/'
            var url = location.substr(0, location.lastIndexOf('/')+1) + route;
            return url;
        };

    var getPostUrl = function getPostUrl(elem) {
            // url = window.location až k poslednímu lomítku + / + routa
            var location = window.location.toString();
            var parent = elem.parentNode;
            var route = 'api/v1/pribeh/' + parent.getAttribute("data-id") + '/' + elem.getAttribute("data-name") + '/'
            var url = location.substr(0, location.lastIndexOf('/')+1) + route;
            return url;
        };

    var hookGetTemplateData = function hookGetTemplateData() {
        var list = document.getElementsByClassName("retrieve-template");
        for (var i = 0; i < list.length; i++) {
            elem = list[i];
            elem.onclick = function (event) {
            var retrieveElement = event.target;
            retrieveElement.innerHtml = 'Loading template data from JSON source...';
            $.ajax({
                type: "GET",
                url: getGetUrl(retrieveElement)
    //            url: "database/database.json"
            })
            .done(function(result, textStatus, jqXHR) {
                    console.log(result);
                    var html = liveblock.view(template.pribehTemplate, result);
                    console.log(html);
                    var displayEkemenrId = retrieveElement.getAttribute("data-display-id");
                    var displayElement = document.getElementsById(displayEkemenrId);
                    displayElement.innerHtml(html);
                    liveblock.hookPostActionToEditable();
                })
            .fail(function(jqXHR, textStatus, errorThrown){
                    alert( "Selhalo: " + errorThrown );
                    retrieveElement.innerHtml = 'Loading data from JSON source... FAILED!';
                });
            }
        }
    };


    var hookPostActionToEditable = function hookPostActionToEditable() {
        var list = document.getElementsByClassName("editable");
        for (var i = 0; i < list.length; i++) {
            elem = list[i];

//            elem.onclick = function (event) {
//        //            event.preventDefault();
//            };
//
//            elem.ondblclick = function (e) {
//            };

            elem.onmouseout = function (event) {
                var targetElement = event.target;
                var data = {};
                data['html'] = targetElement.innerHTML;
                $.ajax({
                    type: "POST",
                    data: data,
                    url: getPostUrl(targetElement),
                })
                .done(function(requestResult, textStatus, jqXHR) {
                        console.log(requestResult);
                        displayResources.html(view(requestResult));
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

    var privateProperty1 = 'foobar';

    return {
        view: view,
        hookGetTemplateData: hookGetTemplateData,
        hookPostActionToEditable: hookPostActionToEditable,

        //nested namespace with public properties
        properties:{
            publicProperty1: privateProperty1
        },

        //another nested namespace
        helper:{
            attributes: attributes
        }
    };
}
)();