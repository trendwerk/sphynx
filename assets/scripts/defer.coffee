defer = ->
  script = document.createElement('script')
  script.src = Assets.scripts + '/all.js'
  document.body.appendChild script

if window.addEventListener
  window.addEventListener 'load', defer
else if window.attachEvent
  window.attachEvent 'onload', defer
