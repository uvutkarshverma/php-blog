const navlist = document.querySelector('.nav-list');
const navright =document.querySelector('.nav-right')
const navleft =document.querySelector('.nav-left')
const nav = document.querySelector('.navigation')
const burger = document.querySelector('.burger')

burger.addEventListener('click',()=>{
navlist.classList.toggle('show');
navright.classList.toggle('show');
nav.classList.toggle('hnav');
navleft.classList.toggle('nav-left-border');
})

