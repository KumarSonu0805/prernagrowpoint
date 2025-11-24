// JavaScript Document
function createTagify(whitelist,defaultValues,inputName,maxTags,enforceWhitelist=false){
    if(inputName.indexOf('#')!=-1){
        inputName=inputName.replace('#','');
        var input = document.getElementById(inputName);
    }
    else if(inputName.indexOf('.')!=-1){
        var index=-1;
        inputName=inputName.replace('.','');
        if(inputName.indexOf(':eq')!=-1){
            var regex = /\w+:eq\((\d+)\)/;
            var match = inputName.match(regex);
            if (match) {
                index=match[1];
                inputName=inputName.substr(0,inputName.indexOf(':eq'));
            }
        }
        var inputs = document.getElementsByClassName(inputName);
        inputs = Array.prototype.filter.call(inputs, function(element) {
            // Return only elements that do not have the 'exclude' class
            return !element.classList.contains('tagify');
        });
        if(inputs.length==0){
           var input = document.querySelector('input[name="'+inputName+'"]');
        }
        else if(inputs.length==1){
            var input=inputs[0];        
        }
        else if(index!=-1){
            var input=inputs[index];   
        }
        else{
           var input = document.querySelector('input[name="'+inputName+'"]');
        }
    }
    else{
        var input = document.querySelector('input[name="'+inputName+'"]');
    }
    if(input===undefined || input===null){
        console.log(inputName+'-Input Not found!');
        return false;
    }
    // init Tagify script on the above inputs
    var closeOnSelect=false;
    if(maxTags==1){
        closeOnSelect=true;
    }
    tagify = new Tagify(input, {
        enforceWhitelist: enforceWhitelist,
        whitelist: whitelist,
        templates: {
        tag: function(tagData) {
              return `<tag title="${tagData.value}" contenteditable='false' spellcheck="false" class='tagify__tag ${tagData.class ? tagData.class : ""}' ${this.getAttributes(tagData)}>
                        <x title='' class='tagify__tag__removeBtn'></x>
                        <div>
                            <span class='tagify__tag-text'>${tagData.value}</span>
                            <span class='tagify__tag-id'></span>
                        </div>
                      </tag>`;
            }
          },
        maxTags: maxTags,
        dropdown: {
            maxItems: 20,           // <- mixumum allowed rendered suggestions
            classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
            enabled: 0,             // <- show suggestions on focus
            closeOnSelect: closeOnSelect    // <- do not hide the suggestions dropdown once an item has been selected
          }
    });
    tagify.addTags(defaultValues);
    tagify.on('change', function() {
        var ele = document.getElementById(inputName+'-error');
        if (tagify.value.length > 0 && ele) {
            ele.style.display = 'none';
        }
    });
    return tagify;
}