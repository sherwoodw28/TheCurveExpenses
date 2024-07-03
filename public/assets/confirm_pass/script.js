const errorBox = document.querySelector('#message');

document.querySelector('#change_pass').addEventListener('submit', async (e)=>{
    e.preventDefault();

    let pass = document.querySelector('#password');
    let passConf = document.querySelector('#cnfrm-password');

    if(pass != passConf){
        errorBox.textContent = 'Password must match';
    }
});