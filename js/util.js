/**
 * Faz um pedido ajax.
 * @param {string} url especifica o url para onde enviar o pedido
 * @param {string} method o método para usar no pedido (POST, GET, PUT)
 * @param {function} callback função usada para lidar com as respostas do servidor
 */
function ajax(url, method, callback) {
  let request = new XMLHttpRequest();
  request.overrideMimeType("application/json");
  request.open(method, url, true);
  request.onreadystatechange = () => {
    if (request.readyState === 4 && request.status == "200") {
        callback(request.responseText);
    }
  };
  request.send(null);
}
