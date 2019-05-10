function openModal(url) {
  document.querySelector('.modal__cover').classList.remove('modal__cover-hide')
  document.querySelector('.modal').classList.remove('modal-hide')
  document.querySelector('.modal').innerHTML = `
    <div class="modal__container__spinner">
      <div class="modal__spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
      </div>
    </div>
  `
  fetch(url)
    .then(response => response.text())
    .then(data => {
      document.querySelector('.modal').innerHTML = data
    })
}

function closeModal() {
  document.querySelector('.modal__cover').classList.add('modal__cover-hide')
  document.querySelector('.modal').classList.add('modal-hide')
}

function closeFlashMsg(closeBtn) {
  return closeBtn.parentNode.remove()
}

function validateField(input) {
  input.classList.add('input--on-blur')
}

function isActiveLink() {
  const path_name = location.origin + location.pathname
  document.querySelectorAll('.active-link').forEach(link => {
    link.href === path_name && (link.className += ' active')
  })
}

function main() {
  document.querySelector('body').classList.remove('preload')
  isActiveLink()
}

window.onload = main()
