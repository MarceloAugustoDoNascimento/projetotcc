
let email = document.querySelector('#email')
let labelemail = document.querySelector('#labelemail')
let labelnome = document.querySelector('#labelnome')
let senha1 = document.querySelector('#senha1')
let senha = document.querySelector('#senha')
let verif = document.querySelector('#verif')
let leftspanpadrao = document.querySelector('#leftspanpadrao')
let leftspan = document.querySelector('#leftspan')
let validarsenha1 = false
let validarsenha2 = false
let validarnome = false
let validaremail = false
var emailPattern =  /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;


email.addEventListener('keyup', () => {
    if(!emailPattern.test(document.getElementById('email').value)){
        labelemail.setAttribute('style','color:red')
    } else {
        labelemail.setAttribute('style', 'color:white')
        validaremail = true
    }
})

senha1.addEventListener('keyup', () => {
    if(senha1.value.length <= 8){
        leftspanpadrao.setAttribute('style', 'color: red')
        verif.value = "";
    }
    else {
        leftspanpadrao.setAttribute('style', 'color: green')
        validarsenha1 = true
    }
})
senha.addEventListener('keyup', () => {

    if(senha.value != senha1.value){
        leftspan.setAttribute('style', 'visibility: visible')
        verif.value = "";
    }
    else if(senha.value == senha1.value && senha1.value.length >= 8){
        leftspan.setAttribute('style', 'visibility: hidden')
        verif.value = "ok";
    }

})