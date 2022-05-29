const FormStatus = {
    title: false,
    content: false
};

function onResponse(response){
    return response.json();
}
 
function onJsonGames(json){
    document.querySelector("#searchresult").innerHTML = '';

    div = document.createElement('div');
    title = document.createElement('h1');
    img = document.createElement('img');

    title.textContent = json.name;
    img.src = json.background_image;

    div.appendChild(title);
    div.appendChild(img);

    document.querySelector("#searchresult").appendChild(div);

    document.querySelector('form').classList.remove('hidden');
    document.querySelector('input[name="Game"]').value = json.slug;
}


function search(event){
    event.preventDefault;
    const textarea = event.currentTarget.parentNode.querySelector("textarea");
    const string = textarea.value.trim();
    const game = string.replace(/\s+/g, '-');
    fetch("PHP/getGames.php?Game="+game).then(onResponse).then(onJsonGames);
    textarea.value = '';
}

function empty(event){
    event.currentTarget.value = '';
    event.currentTarget.removeEventListener('focus', empty);
}

function checkTitle(){
    const title = document.querySelector('input[name="Title"]');

    if (!/^(?!\s*$).+/.test(title.value)){
        title.classList.add('error');
        document.querySelector('#title-error').textContent = 'Titolo non valido';
        FormStatus.title = false;
    }else{
        title.classList.remove('error');
        document.querySelector('#title-error').textContent = '';
        FormStatus.title = true;
    }
}

function checkContent(event){
    const textarea = event.currentTarget;

    if(!/^(?!\s*$).+/.test(textarea.value)){
        textarea.classList.add('error');
        document.querySelector('#content-error').textContent = 'inserisci qualcosa';
        FormStatus.content = false;
    }else{
        textarea.classList.remove('error');
        document.querySelector('#content-error').textContent = '';
        FormStatus.content = true;
    }
}

function checkForm(event){
    let confirm = true;
    for(let status in FormStatus)
        if (FormStatus[status] === false)
            confirm = false;
        
    if (!confirm)
        event.preventDefault();
}

document.querySelector("#searchbox button").addEventListener('click', search);
document.querySelector("#content").addEventListener('focus', empty);

document.querySelector('input[name="Title"]').addEventListener('blur', checkTitle);
document.querySelector('#content').addEventListener('blur', checkContent);

document.forms['Form'].addEventListener('submit', checkForm);