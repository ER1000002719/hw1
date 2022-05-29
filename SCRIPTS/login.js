const FormStatus = {
    username: false,
    password: false,
};

function onResponse(response){
    return response.json();
}

function onJsonUsername(json){
    const mail = document.querySelector('input[name="user"]');

    if(!json.exists){
        mail.classList.add('error');
        document.querySelector('#username-error').textContent = "Username inesistente";
        FormStatus.email = false;
    }
}

function checkUsername(event){
    const user = document.querySelector('input[name="user"]');

    if (!/^[a-zA-Z0-9_]+$/.test(user.value)){
        user.classList.add('error');
        document.querySelector('#username-error').textContent = 'Username non valido';
        FormStatus.username = false;
    }else{
        user.classList.remove('error');
        document.querySelector('#username-error').textContent = '';
        FormStatus.username = true;
        console.log('PHP/checkUsername.php?check=' + encodeURIComponent(user.value));
        fetch('PHP/checkUsername.php?check=' + encodeURIComponent(user.value) ).then(onResponse).then(onJsonUsername);
    }
}

function checkPass(event){
    const pass = document.querySelector('input[name="pass"]');

    if (!pass.value){
        pass.classList.add('error');
        document.querySelector('#password-error').textContent = 'inserisci una password';
        FormStatus.password = false;
    }else{
        pass.classList.remove('error');
        document.querySelector('#password-error').textContent = '';
        FormStatus.password = true;
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

document.querySelector('input[name="user"]').addEventListener('blur', checkUsername);
document.querySelector('input[name="pass"]').addEventListener('blur', checkPass);

document.forms['Form'].addEventListener('submit', checkForm);