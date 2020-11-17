const buttonCreate = document.querySelector('.button-create');
const buttonCancel = document.querySelector('#cancel-create');
const popUpCreate = document.querySelector('.pop-up-create');
const overlay = document.querySelector('.overlay');

if (buttonCreate !== null) {
  buttonCreate.addEventListener('click', (e) => {
    document.body.style.overflow = 'hidden';
    overlay.classList.remove('overlay--hide');
    popUpCreate.classList.add('pop-up-create--show');
  })
}

if (buttonCancel !== null) {
  buttonCancel.addEventListener('click', (e) => {
    document.body.style.overflow = 'visible';
    overlay.classList.add('overlay--hide');
    popUpCreate.classList.remove('pop-up-create--show');
  })
}