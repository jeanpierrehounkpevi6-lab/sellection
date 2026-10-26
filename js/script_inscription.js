function ChangeVoire(IdEnter,IdIcon){
    let input=document.getElementById(IdEnter);
    let icon=document.getElementById(IdIcon);

    if(input.type=='password'){
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    }else{
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}