import './bootstrap'
import './orejime'
import smoothscroll from 'smoothscroll-polyfill'

smoothscroll.polyfill()

(function () {

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.navbar-burger').addEventListener('click', () => {
            document.getElementById('navbar').classList.toggle('is-active')
        })
    })

    document.getElementById('back-to-top').addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        })
    })

})()
