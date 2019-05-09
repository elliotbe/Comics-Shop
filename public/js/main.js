const modal_wrap = document.querySelector('.modal__wrap')
const modal_cover = document.querySelector('.modal__cover')
const modal = document.querySelector('.modal')
const modal_spinner = `
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

window.onload = main()

function openModal(url) {
  modal_cover.classList.remove('modal__cover-hide')
  modal.classList.remove('modal-hide')
  modal.innerHTML = modal_spinner
  fetch(url)
    .then(response => response.text())
    .then(data => {
      modal.innerHTML = data
    })
}

function closeModal() {
  modal_cover.classList.add('modal__cover-hide')
  modal.classList.add('modal-hide')
}

function closeFlashMsg(self) {
  self.parentElement.classList.add('hide')
}

function main() {
  document.querySelector('body').classList.remove('preload')
  isActiveLink()
}

function isActiveLink() {
  const path_name = location.origin + location.pathname
  document.querySelectorAll('.active-link').forEach(link => {
    link.href === path_name && (link.className += ' active')
  })
}
