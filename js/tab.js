const reel = document.querySelector('.tab_reel');
const tab1 = document.querySelector('.tab1');
const tab2 = document.querySelector('.tab2');
const panel1 = document.querySelector('.tab_panel1');
const panel2 = document.querySelector('.tab_panel2');

function slideLeft(e) {
  tab2.classList.remove('active');
  this.classList.add('active');
  reel.style.transform = "translateX(0%)";
}

function slideRight(e) {
  tab1.classList.remove('active');
  this.classList.add('active');
  reel.style.transform = "translateX(-50%)";
}

tab1.addEventListener('click', slideLeft);
tab2.addEventListener('click', slideRight);