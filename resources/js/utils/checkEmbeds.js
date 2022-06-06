let checkIfValidVideo = function(url) {
  let regex = [
    /^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/i,
    /^.*vimeo.com\/(\d+)($|\/|\b)/i,
    /^.*(?:\/video|dai.ly)\/([A-Za-z0-9]+)([^#\&\?]*).*/i,
    /^.*coub.com\/(?:embed|view)\/([A-Za-z0-9]+)([^#\&\?]*).*/i
  ]
  for (let i = 0; i < regex.length; i++) {
    const v = regex[i];
    var m = v.exec(url);
    if (m) {
      return true
    }
  }
  return false
}

export default checkIfValidVideo
