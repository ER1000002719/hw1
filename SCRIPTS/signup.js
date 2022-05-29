const FormStatus = {
    name: false,
    surname: false,
    username: false,
    email: false,
    password: false,
    confirm: false
};

function onResponse(response){
    return response.json();
}

function onJsonUsername(json){
    const mail = document.querySelector('input[name="user"]');

    if(json.exists){
        mail.classList.add('error');
        document.querySelector('#username-error').textContent = "Username gia' in uso";
        FormStatus.email = false;
    }
}

function onJsonMail(json){
    const mail = document.querySelector('input[name="mail"]');

    if(json.exists){
        mail.classList.add('error');
        document.querySelector('#mail-error').textContent = "E-mail gia' in uso";
        FormStatus.email = false;
    }
}

function checkName(event){
    const nome = document.querySelector('input[name="Nome"]');

    if (!/^[a-z A-Z]+$/.test(nome.value)){
        nome.classList.add('error');
        document.querySelector('#name-error').textContent = 'Titolo non valido';
        FormStatus.name = false;
    }else{
        nome.classList.remove('error');
        document.querySelector('#name-error').textContent = '';
        FormStatus.name = true;
    }
}

function checkSurname(event){
    const cognome = document.querySelector('input[name="Cognome"]');

    if (!/^[a-z A-Z]+$/.test(cognome.value)){
        cognome.classList.add('error');
        document.querySelector('#surname-error').textContent = 'Cognome non valido';
        FormStatus.surname = false;
    }else{
        cognome.classList.remove('error'); 
        document.querySelector('#surname-error').textContent = '';
        FormStatus.surname = true;
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

function checkEmail(event){
    const mail = document.querySelector('input[name="mail"]');
    const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    if (!regex.test(mail.value)){
        mail.classList.add('error');
        document.querySelector('#mail-error').textContent = 'E-mail non valida';
        FormStatus.email = false;
    }else{
        mail.classList.remove('error');
        document.querySelector('#mail-error').textContent = '';
        FormStatus.email = true;
        console.log('PHP/checkEmail.php?check='+encodeURIComponent(mail.value));
        fetch('PHP/checkEmail.php?check='+encodeURIComponent(mail.value)).then(onResponse).then(onJsonMail);
    }
}

function checkPass(event){
    const pass = document.querySelector('input[name="pass"]');
    const regex = /^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/;

    if (!regex.test(pass.value)){
        pass.classList.add('error');
        document.querySelector('#password-error').textContent = 'Password non conforme';
        FormStatus.password = false;
    }else{
        pass.classList.remove('error');
        document.querySelector('#password-error').textContent = '';
        FormStatus.password = true;
    }
}

function checkConfirm(event){
    const conf = document.querySelector('input[name="pass-confirm"]');
    const pass = document.querySelector('input[name="pass"]');
    if (conf.value !== pass.value){
        conf.classList.add('error');
        document.querySelector('#confirm-error').textContent = 'I due campi devono essere uguali';
        FormStatus.confirm = false;
    }else{
        conf.classList.remove('error');
        document.querySelector('#confirm-error').textContent = '';
        FormStatus.confirm = true;
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

document.querySelector('input[name="Nome"]').addEventListener('blur', checkName);
document.querySelector('input[name="Cognome"]').addEventListener('blur', checkSurname);
document.querySelector('input[name="user"]').addEventListener('blur', checkUsername);
document.querySelector('input[name="mail"]').addEventListener('blur', checkEmail);
document.querySelector('input[name="pass"]').addEventListener('blur', checkPass);
document.querySelector('input[name="pass-confirm"]').addEventListener('blur', checkConfirm);

document.forms['Form'].addEventListener('submit', checkForm);




