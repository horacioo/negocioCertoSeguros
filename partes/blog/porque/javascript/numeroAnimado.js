function animarContador(elemento, final, duracao) {
  const inicio = performance.now();

  function atualizar(agora) {
    const tempoDecorrido = agora - inicio;
    const progresso = Math.min(tempoDecorrido / duracao, 1); // de 0 a 1

    const valorAtual = Math.floor(progresso * final);
    elemento.textContent = valorAtual.toLocaleString();

    if (progresso < 1) {
      requestAnimationFrame(atualizar);
    }
  }

  requestAnimationFrame(atualizar);
}


var valorInfo = 10000

  animarContador(document.querySelector("#contador1"), 30, valorInfo);
  animarContador(document.querySelector("#contador2"), 3000, valorInfo);
