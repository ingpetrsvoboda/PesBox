var template = (function() {
        return {
            render:  function resourceTableTemplate(result) {
                var output="<table><thead><tr><th>Name</th><th>Provider</th><th>URL</th></thead><tbody>";
                for (var id in result)
                {
                    output+="<tr "+"data-collection=resources data-id="+id+"><td "+"data-name=name>" + result[id].name + "</td><td "+"data-name=provider>" + result[id].provider + "</td><td "+"data-name=url>" + result[id].url + "</td></tr>";
                }
                output+="</tbody></table>";
                return output;
            }
        };
    }
)();

