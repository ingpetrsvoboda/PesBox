

var template = (function() {
    return {
        pribehTemplate:  function pribehTemplate(result) {
            var output = `
                <div class="ui breadcrumb">
                        <a class="section" href="index.php?main=pribehy">Příběhy studentů</a>
                        <i class="right angle icon divider"></i>
                        <p class="active section">${result.autor}</p>
                </div>
                <article class="editable" data-id="sem-patri-id-clanku">
                    <h2 data-name="pribehyPerexTitleText">${result.pribehPerex.pribehyPerexTitleText}</h2>
                    <p data-name="pribehyPerexTitleText">${result.pribehPerex.pribehyPerexText}</p>
                    <img ${liveblock.helper.attributes(result.pribehClanek.imgPribehuAttributes)} />
                    <p data-name="pribehyPerexTitleText">${result.pribehClanek.castPribehu}</p>
                    <img ${liveblock.helper.attributes(result.pribehClanek.imgAutoraAttributes)} />
                    <p data-name="pribehyPerexTitleText">${result.pribehClanek.cast2Pribehu}</p>
                </article>
                `;

                return output;
            }
        }
    }
)();

