function isActiveLink() {
  const link_list = document.querySelectorAll('.active-link')
  const path_name = window.location.href

  for (const link of link_list) {
    if (link.href === path_name) {
      link.className += ' active'
      console.log('yeah')
    }
    console.log(link.href)
  }
}

function main() {
  isActiveLink()
}

window.onload = main()
