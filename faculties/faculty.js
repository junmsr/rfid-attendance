const open = document.getElementById('new-faculty');
const container_form = document.getElementById('form-container');
const close = document.getElementById('btn-close');

open.addEventListener('click', () => {
    container_form.classList.add('show');
});

close.addEventListener('click', () => {
    container_form.classList.remove('show');
});


// $(document).ready(function(){
//     $('#rfid-tag').focus();
//     $('body').mouseover(function(){
//         $('#rfid-tag').focus();
//     });
// });