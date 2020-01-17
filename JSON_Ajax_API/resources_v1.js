/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */


$(document).ready(function () {

    $('#retrieve-resources').click(function () {
        var displayResources = $('#display-resources');

        displayResources.text('Loading data from JSON source...');
        function view(result) {
            var output="<table><thead><tr><th>Name</th><th>Provider</th><th>URL</th></thead><tbody>";
            for (var id in result)
            {
                output+="<tr "+"data-collection=resources data-id="+id+"><td "+"data-name=name>" + result[id].name + "</td><td "+"data-name=provider>" + result[id].provider + "</td><td "+"data-name=url>" + result[id].url + "</td></tr>";
            }
            output+="</tbody></table>";
            return output;
        }
        $.ajax({
            type: "GET",
            url: "resources.json",
            success: function(result)
            {
                console.log(result);
                displayResources.html(view(result));
                $("table").addClass("table").attr("contenteditable", true);
            }
        });

    });
});
